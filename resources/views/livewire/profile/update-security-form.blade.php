<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'email' => auth()->user()->email,
]);

rules([
    'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
]);

$updateEmail = function () {
    $user = Auth::user();

    $this->validate();

    if ($user->email !== $this->email) {
        $user->email = $this->email;
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        $this->redirectRoute('verification.notice', navigate: true);
    }

    $this->dispatch('email-updated', name: $user->name);
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Security') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's security information.") }}
        </p>
    </header>

    <form wire:submit="updateEmail"
          class="flex flex-col gap-y-6 mt-6"
          x-data="{uploading: false}"
          x-on:livewire-upload-start="uploading = true"
          x-on:livewire-upload-finish="uploading = false"
          x-on:livewire-upload-cancel="uploading = false"
          x-on:livewire-upload-error="uploading = false"
    >

        <x-form-row>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required
                          autocomplete="username" />
            <p class="text-xs text-gray-400 mt-2 flex gap-1">
                <x-heroicon-o-information-circle class="size-4" />
                修改邮箱需要重新验证
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </x-form-row>

        <div class="flex items-center gap-4">
            <x-primary-button class="w-max px-6" type="submit" wire:loading.class="cursor-not-allowed !bg-gray-500">
                <x-icons.spinner wire:loading :size="5" class="me-1" />
                {{ __('Update') }}
            </x-primary-button>

            <x-action-message class="me-3" on="email-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
