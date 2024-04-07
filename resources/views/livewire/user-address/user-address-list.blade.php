<div class="container flex mt-14">
    <x-profile.nav />

    <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow border">
            <div class="max-w-3xl mx-auto">

                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('User Address') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Manage your account's addresses.") }}
                        </p>
                    </header>

                    <table class="w-full text-sm text-left text-gray-500 mt-6">
                        <thead class="text-xs text-white bg-black">
                        <tr class="*:border-x *:border-white">
                            <th scope="col" class="px-6 py-3">
                                {{ __('user_address.address') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('user_address.contact_name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('user_address.contact_phone') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="*:bg-white *:border-b">
                        @foreach(auth()->user()->addresses as $user_address)
                            <tr class="last:border-none">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user_address->full_address }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user_address->contact_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user_address->contact_phone }}
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <a class="text-active cursor-pointer"
                                           @click="$dispatch('open-modal', 'delete-address-confirm-{{ $user_address->id}}')"
                                        >
                                            {{ __('Delete') }}
                                        </a>

                                        <x-modal :name="'delete-address-confirm-' . $user_address->id">
                                            <div class="p-6 flex flex-col items-center">
                                                <x-heroicon-o-information-circle class="size-20 text-active" />

                                                <h2 class="text-lg font-bold text-gray-900 mt-6">
                                                    {{ __('Are you sure you want to delete the address?') }}
                                                </h2>

                                                <div class="my-6 text-sm text-gray-600 flex flex-col gap-2">
                                                    <p>
                                                        <strong>{{ __('user_address.address') }}</strong>: {{ $user_address->full_address }}
                                                    </p>
                                                    <p>
                                                        <strong>{{ __('user_address.contact_name') }}</strong>: {{ $user_address->contact_name }}
                                                    </p>
                                                    <p>
                                                        <strong>{{ __('user_address.contact_phone') }}</strong>: {{ $user_address->contact_phone }}
                                                    </p>
                                                </div>

                                                <div class="mt-6 flex gap-6">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3"
                                                                     wire:click="delete({{ $user_address->id }})">
                                                        {{ __('Delete') }}
                                                    </x-danger-button>
                                                </div>
                                            </div>
                                        </x-modal>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="my-6 flex justify-center">
                        <a href="{{ route('user_addresses.create') }}"
                           class="flex items-center justify-center text-white px-14 py-2 bg-gray-800 hover:bg-active"
                           wire:navigate>
                            <span>{{ __('Add New Address') }}</span>
                            <x-heroicon-o-plus class="size-6 ms-2" />
                        </a>
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>
