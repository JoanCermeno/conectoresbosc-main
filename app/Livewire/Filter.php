<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Filter extends Component
{
    use WithPagination;

    public $family_id;

    public $category_id;

    public $subcategory_id;

    public $options;

    public $selected_features = [];

    public $orderBy = 1;

    public $search;

    public function mount()
    {
        $this->options = Option::verifyFamily($this->family_id)
        ->verifyCategory($this->category_id)
        ->verifySubcategory($this->subcategory_id)
        ->get()->toArray();   
    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
        
    }

    public function render()
    {

        $products = Product::when($this->family_id, function($query){
            $query->whereHas('subcategory.category', function($query){
            $query->where('family_id', $this->family_id);
            });
        })

        ->when($this->category_id, function($query){
            $query->whereHas('subcategory', function($query){
                $query->where('category_id', $this->category_id);
            });
        })
        ->when($this->subcategory_id, function($query){
            $query->where('subcategory_id', $this->subcategory_id);
        })
          
        ->customOrder($this->orderBy)


        ->when($this->selected_features, function($query) {
            $query->whereHas('variants.features', function($query) {
                $query->whereIn('features.id', $this->selected_features);
            });
        })
        ->when($this->search, function($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })

        ->paginate(12);

        return view('livewire.filter', compact('products'));
    }
}
