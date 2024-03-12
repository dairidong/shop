<x-app-layout>
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>


    <div class="container flex mt-14">
        <x-profile.nav></x-profile.nav>

        <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow border">
                <div class="max-w-3xl mx-auto">
                    <livewire:profile.update-password-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
