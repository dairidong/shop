<?php

namespace App\Livewire\UserAddress;

use App\Models\UserAddress;
use Livewire\Component;

class EditUserAddress extends Component
{
    public UserAddress $userAddress;

    public function mount(UserAddress $userAddress): void
    {
        $this->authorize('update', $userAddress);

        $this->userAddress = $userAddress;
    }

    public function render()
    {
        return view('livewire.user-address.edit-user-address');
    }
}
