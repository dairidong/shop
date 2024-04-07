<div class="container flex mt-14">
    <x-profile.nav activeRoute="user_addresses.index" />

    <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow border">
            <div class="max-w-3xl mx-auto">

                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Add User Address') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            添加一个新的收货地址
                        </p>

                    </header>

                    <livewire:user-address.user-address-form />
                </section>
            </div>
        </div>
    </div>
</div>
