<?php

namespace App\Livewire\UserAddress;

use App\Models\UserAddress;
use Livewire\Component;

class UserAddressList extends Component
{
    public function delete(UserAddress $userAddress)
    {
        $this->authorize('delete', $userAddress);

        $userAddress->delete();

        $this->dispatch('close-modal', 'delete-address-confirm-'.$userAddress->id);
    }

    public function render()
    {
        return view('livewire.user-address.user-address-list');
    }
}
