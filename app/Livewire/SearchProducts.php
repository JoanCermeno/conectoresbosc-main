<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchProducts extends Component
{
    public $search = '';
    public $showResults = false;

    public function render()
    {
        $products = collect();

        if (strlen($this->search) >= 2) {
            $products = Product::where('name', 'like', '%' . $this->search . '%')
                               ->orderBy('name')
                               ->get();
        }

        return view('livewire.search-products', [
            'products' => $products,
        ]);
    }
    
    public function setFocus()
    {
        $this->showResults = true;
    }

    public function updated($property)
    {
        if ($property === 'search') {
            $this->showResults = true;
        }
    }
}