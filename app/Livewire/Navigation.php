<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Navigation extends Component
{

    public $families;
    public $family_id;

  public function mount()
    {
        $this->families = \App\Models\Family::all();

        if ($this->families->isNotEmpty()) {
            $this->family_id = $this->families->first()->id;
        } else {
            $this->family_id = null; // o un valor por defecto si lo necesitas
        }
    }

    #[Computed()]
    public function categories()
    {
        if ($this->family_id) {
            return \App\Models\Category::where('family_id', $this->family_id)
                ->with('subcategories')
                ->get();
        }

        return collect(); // colección vacía
    }


    #[Computed()]
    public function familyName()
    {
        if ($this->family_id) {
            return \App\Models\Family::find($this->family_id)?->name;
        }

        return 'Sin familia';
    }


    public function render()
    {
        return view('livewire.navigation');
    }
}
