<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddToCart extends Component
{

    public $product;

    public $variant;

    public $qty = 1;

    public $stock;

    public $selectedFeatures = [];

    public function mount() 
    {
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray();

        $this->getVariant();
    }

    public function updatedSelectedFeatures()
    {
        $this->getVariant();
    }

 
    public function getVariant()
    {
        $this->variant = $this->product->variants->filter(function ($variant){
            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures);
        })->first();

        $this->stock = $this->variant->stock;
        $this->qty = 1;
    }

      public function add_to_cart()
    {

        Cart::instance('shopping');

        $cartItem = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->options->sku === $this->variant->sku;
        })->first();

        
        if ($cartItem) {
            $stock = $this->stock - $cartItem->qty;

            if ($stock < $this->qty) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Lo siento!',
                    'text' => 'No hay suficiente stock disponible'
                ]);
                return;
            }
        }

        

        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'image' => $this->product->image,
                'sku' => $this->variant->sku,
                'stock' => $this->variant->stock,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                ->pluck('description', 'id')
                ->toArray()
            ]
        ]);
         if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->dispatch('cartUpdated', Cart::count());

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Bien Hecho!',
            'text' => 'El producto se ha agregado al carrito'
        ]);
    }

    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
