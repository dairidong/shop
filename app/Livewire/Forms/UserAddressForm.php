<?php

namespace App\Livewire\Forms;

use App\Models\UserAddress;
use Livewire\Form;

class UserAddressForm extends Form
{
    public ?UserAddress $userAddress;

    public string $province;

    public string $city;

    public string $district;

    public string $address;

    public string $zip;

    public string $contact_name;

    public string $contact_phone;

    public function setAddress(UserAddress $userAddress): void
    {
        $this->userAddress = $userAddress;

        $this->fill($userAddress->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
    }

    public function store(): void
    {
        $validated = $this->validate();

        $userAddress = new UserAddress($validated);

        $userAddress->user()->associate(auth()->user());

        $userAddress->save();
    }

    public function update(): void
    {
        $validated = $this->validate();

        $this->userAddress->update($validated);
    }

    public function rules(): array
    {
        return [
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
            'zip' => 'required|postalcode:cn',
            'contact_name' => 'required',
            'contact_phone' => 'required|phone:CN',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'province' => __('user_address.province'),
            'city' => __('user_address.city'),
            'district' => __('user_address.district'),
            'zip' => __('user_address.zip'),
            'contact_name' => __('user_address.contact_name'),
            'contact_phone' => __('user_address.contact_phone'),
        ];
    }
}
