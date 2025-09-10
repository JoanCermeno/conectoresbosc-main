<?php

namespace App\Livewire;

use App\Models\Address;
use Livewire\Component;
use App\Livewire\Forms\CreateAddressForm;
use App\Livewire\Forms\Shipping\EditAddressForm;

class ShippingAddresses extends Component
{
    public $addresses;
    public $newAddress = false;
    public CreateAddressForm $createAddress;
    public EditAddressForm $editAddress;

    public function mount()
{
    // Verifica si el usuario está autenticado
    if (auth()->check()) {
        // Lógica para usuarios logueados: obtener direcciones de la base de datos
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Rellena receiver_info con los datos del usuario logueado
        $this->createAddress->receiver_info = [
            'name' => auth()->user()->name,
            'last_name' => auth()->user()->last_name,
            'document_type' => auth()->user()->document_type,
            'document_number' => auth()->user()->document_number,
            'phone' => auth()->user()->phone,     
        ];
    } else {
        // Lógica para invitados: obtener direcciones de la sesión
        $this->addresses = collect(session('guest_addresses', []));
        
        // Inicializa receiver_info como un array vacío para que el invitado lo llene
        $this->createAddress->receiver_info = [];
    }
}

    public function store()
    {
        $this->createAddress->save();
        $this->addresses = Address::where('user_id', auth()->id())
            ->get();
        $this->newAddress = false;
    }

    public function edit($id)
    {
        $address = Address::find($id);
        $this->editAddress->edit($address);
        
    }

    public function update()
    {
        $this->editAddress->update();
        $this->addresses = Address::where('user_id', auth()->id())
            ->get();
    }

    public function deleteAddress($id)
    {
        Address::find($id)->delete();
        
        $this->addresses = Address::where('user_id', auth()->id())
            ->get();

        if ($this->addresses->where('default', true)->count() == 0 && $this->addresses->count() > 0) {
            $this->addresses->first()->update(['default' => true]);
        }
    }

    public function setDefaultAddress($id)
    {
        $this->addresses->each(function($address) use ($id) {
            $address->update([
                'default' => $address->id == $id ? true : false
            ]);
        });
    }

    public function render()
    {
        return view('livewire.shipping-addresses');
    }
}
