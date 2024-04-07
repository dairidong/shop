<?php

use App\Livewire\Forms\UserAddressForm;
use App\Models\UserAddress;
use function Livewire\Volt\form;
use function Livewire\Volt\mount;
use function Livewire\Volt\state;

state('submitType');

form(UserAddressForm::class);

mount(function (UserAddress $userAddress, $submitType = 'create') {
    $this->submitType = $submitType;

    if ($submitType === 'edit') {
        $this->form->setAddress($userAddress);
    }
});

$save = function () {
    if ($this->submitType === 'create') {
        $this->form->store();
    } elseif ($this->submitType === 'delete') {
        $this->form->update();
    }
};

?>

<form class="flex flex-col gap-y-6 mt-6" wire:submit="save">
    <x-form-row>
        <div
            class="flex flex-row gap-3"
            x-data="areaSelects({
                province: $wire.entangle('form.province'),
                city: $wire.entangle('form.city'),
                district: $wire.entangle('form.district'),
            })"
        >
            <div class="flex flex-col w-1/3">
                <x-input-label for="province" class="text-base" :value="__('user_address.province')" />
                <select required x-model="province" id="province"
                        class="block mt-1 w-full border-[#ccc] focus:ring-0 focus:border-[#ccc]">
                    <option>请选择省</option>
                    <template x-for="p in availableProvinces" :key="p.code">
                        <option x-text="p.name"></option>
                    </template>
                </select>
            </div>
            <div class="flex flex-col w-1/3">
                <x-input-label for="city" class="text-base" :value="__('user_address.city')" />
                <select required x-model="city" id="city"
                        class="block mt-1 w-full border-[#ccc] focus:ring-0 focus:border-[#ccc]">
                    <option>请选择市</option>
                    <template x-for="c in availableCities" :key="c.code">
                        <option x-text="c.name"></option>
                    </template>
                </select>
            </div>
            <div class="flex flex-col w-1/3">
                <x-input-label for="district" class="text-base" :value="__('user_address.district')" />
                <select required x-model="district" id="district"
                        class="block mt-1 w-full border-[#ccc] focus:ring-0 focus:border-[#ccc]">
                    <option>请选择区域</option>
                    <template x-for="d in availableDistricts" :key="d.code">
                        <option x-text="d.name"></option>
                    </template>
                </select>
            </div>
        </div>

        <x-input-error class="mt-2"
                       :messages="array_merge(
                            $errors->get('form.province'),
                            $errors->get('form.city'),
                            $errors->get('form.district')
                       )"
        />
    </x-form-row>


    <x-form-row>
        <x-input-label for="address" class="text-base" :value="__('user_address.address')" />
        <x-text-input id="address" type="text" class="mt-1 block w-full" wire:model="form.address" required />
        <x-input-error class="mt-2" :messages="$errors->get('form.address')" />
    </x-form-row>

    <x-form-row>
        <x-input-label for="zip" class="text-base" :value="__('user_address.zip')" />
        <x-text-input id="zip" type="text" class="mt-1 block w-full" wire:model="form.zip" required />
        <x-input-error class="mt-2" :messages="$errors->get('form.zip')" />
    </x-form-row>

    <x-form-row>
        <x-input-label for="contact_name" class="text-base" :value="__('user_address.contact_name')" />
        <x-text-input id="contact_name" type="text" class="mt-1 block w-full" wire:model="form.contact_name" required />
        <x-input-error class="mt-2" :messages="$errors->get('form.contact_name')" />
    </x-form-row>

    <x-form-row>
        <x-input-label for="contact_phone" class="text-base" :value="__('user_address.contact_phone')" />
        <x-text-input id="contact_phone" type="text" class="mt-1 block w-full" wire:model="form.contact_phone"
                      required />
        <x-input-error class="mt-2" :messages="$errors->get('form.contact_phone')" />
    </x-form-row>

    <div class="flex items-center gap-4 mt-4">
        <x-primary-button class="px-6" type="submit" :value="__('Save')" />
    </div>
</form>
