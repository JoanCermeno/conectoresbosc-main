<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Family;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;

class SubcategoryCreate extends Component
{

    public $families;

    public $subcategory = [
        'family_id' => '',
        'category_id' => '',
        'name' => '',

    ];

    public function mount()
    {
        $this->families = Family::all();
    }

    public function updatedSubcategoryFamilyId() 
    {
        $this->subcategory['category_id'] = '';
    }

    #[Computed()]
    public function categories() 
    {
        return Category::where('family_id', $this->subcategory['family_id'])->get();
    }

    public function save()
    {
       $this->validate([
            'subcategory.family_id' => 'required|exists:families,id',
            'subcategory.category_id' => 'required|exists:categories,id',
            'subcategory.name' => 'required',
            
       ],[],[
            'subcategory.family_id' => 'Familia',
            'subcategory.category_id' => 'Categoria',
            'subcategory.name' => 'Nombre',
       ]);

       Subcategory::create($this->subcategory);

             session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'Subcategoría creada con éxito.',
        ]);

        return redirect()->route('admin.subcategories.index'); 
    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-create');
    }
}
