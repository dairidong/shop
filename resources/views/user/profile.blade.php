<x-app-layout>
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <div class="container flex">
        <x-profile.nav />

        <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow border">
                <div class="max-w-3xl mx-auto">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow border">
                <div class="max-w-3xl mx-auto">
                    <livewire:profile.update-security-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
