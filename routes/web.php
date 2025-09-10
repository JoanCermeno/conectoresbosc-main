<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('families/{family}', [FamilyController::class, 'show'])->name('families.show');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('products/{product}', [ProductController::class, 'show' ])->name('products.show');
    
Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('shipping', [ShippingController::class, 'index'])
    ->name('shipping.index');

Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::post('checkout', [CheckoutController::class, 'paid'])->name('checkout.paid');

// Route::get('gracias', function () {
//     return view('gracias');
// })->name('gracias');

Route::get('gracias', [CheckoutController::class, 'thanks'])
    ->name('checkout.thanks');

Route::get('orders/{order}/download-ticket', [CheckoutController::class, 'downloadTicket'])
    ->name('order.download-ticket');

Route::get('/contactanos', function () {
    return view('contactanos');
})
->name('contactanos');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//  Route::get('ticket', function(){
//     $order = Order::first(); 

//     $pdf = Pdf::loadView('orders.ticket', compact('order'))->setPaper('a5', 'landscape');

//     $pdf->save(storage_path('/app/public/tickets/ticket-' . $order->id . '.pdf'));

//     $order->pdf_path = 'tickets/ticket-' . $order->id . '.pdf';
//     $order->save();
//  });
