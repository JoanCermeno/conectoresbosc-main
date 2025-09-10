<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Variant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller as BaseController;

class CheckoutController extends BaseController
{
    public function index()
    {
        Cart::instance('shopping');
        $content = Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        });
        $subtotal = $content->sum(function ($item) {
            return $item->subtotal;
        });
        
        return view('checkout.index', compact('content', 'subtotal'));
    }

    public function paid(Request $request)
    {
        // 1. Validar los datos del formulario (esto es lo que se llenó en el checkout)
        $request->validate([
            'delivery_type' => 'required|string',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'order_notes' => 'nullable|string',
        ]);

        Cart::instance('shopping');
        $content = Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        });

        // 2. Crear un array con los datos del formulario, sin importar si el usuario está registrado.
        $address = [
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'delivery_type' => $request->input('delivery_type'),
            'order_notes' => $request->input('order_notes'),
        ];

        // 3. Crear la orden de compra y guardar el array 'address'
        $order = Order::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'content' => $content, 
            'address' => $address, // <-- Ahora se guarda la información del formulario
            'total' => Cart::subtotal(),
        ]);

        // 4. Actualizar el stock y vaciar el carrito
        foreach ($content as $item) {
            Variant::where('sku', $item->options['sku'])->decrement('stock', $item->qty);
            Cart::remove($item->rowId);
        }

         $request->session()->put([
            'order_id' => $order->id,
            'expires_at' => now()->addMinutes(5)->timestamp // La página expira en 5 minutos
        ]);

        Mail::to($order->address['email'])->send(new OrderConfirmationMail($order));

        // 5. Redirigir a la vista de confirmación.
        return redirect()->route('checkout.thanks', ['orderId' => $order->id]);
    }

 public function thanks(Request $request)
    {
        // 1. Obtiene el ID de la orden y la marca de tiempo de la sesión
        $orderId = $request->session()->get('order_id');
        $expiresAt = $request->session()->get('expires_at');
        $order = Order::find($orderId);

        // 2. Valida si la orden existe y si la sesión ha expirado
        if (!$order || !$expiresAt || now()->greaterThan(Carbon::createFromTimestamp($expiresAt))) {
            // Elimina los datos de la sesión para evitar problemas futuros
            $request->session()->forget(['order_id', 'expires_at']);
            // Redirige al inicio si el acceso no es válido o ha expirado
            return redirect()->route('welcome.index')->with('error', 'El enlace de la página ha expirado.');
        }

        // 3. Pasa la orden a la vista y elimina los datos de la sesión para prevenir reingresos
        $request->session()->forget(['order_id', 'expires_at']);

        // Pasa la marca de tiempo para el enlace del PDF
        return view('gracias', compact('order'))->with('timestamp', now()->timestamp);
    }

   public function downloadTicket(Request $request, Order $order)
    {
        // 1. Obtiene la marca de tiempo de la URL
        $timestamp = $request->query('timestamp');

        // 2. Define el tiempo de expiración (por ejemplo, 5 minutos)
        $expirationTime = Carbon::createFromTimestamp($timestamp)->addMinutes(5);

        // 3. Valida si la marca de tiempo existe y si ha expirado
        if (!$timestamp || now()->greaterThan($expirationTime)) {
            // Si el enlace ha expirado o es inválido, redirige al inicio
            return redirect()->route('welcome.index')->with('error', 'El enlace de descarga ha expirado.');
        }

        // Si el enlace es válido, procede con la descarga del PDF
        $pdf = Pdf::loadView('ticket', compact('order'));
        return $pdf->download('ticket-orden-' . $order->id . '.pdf');
    }
}

