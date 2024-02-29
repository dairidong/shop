<x-app-layout>
    <div class="container py-12 flex">
        <x-profile.nav></x-profile.nav>

        <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
