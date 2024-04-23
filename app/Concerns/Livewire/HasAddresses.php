<?php

namespace App\Concerns\Livewire;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

/**
 * @property ?UserAddress $currentAddress
 */
trait HasAddresses
{
    public ?int $addressId;

    /**
     * @var Collection<UserAddress;
     */
    public Collection $addresses;

    public function mountHasAddresses(): void
    {
        /** @var User $user */
        $user = auth()->user();

        $this->addresses = $user->addresses()->latest()->get();

        $this->addressId = $this->addresses->first()?->id;
    }

    #[Computed]
    public function currentAddress(): ?UserAddress
    {
        return $this->addressId
            ? $this->addresses?->firstWhere('id', $this->addressId)
            : $this->addresses?->first();
    }
}
