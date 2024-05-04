@php
    use Illuminate\Support\Facades\Route;
    $routes = [
        ['route_name' => 'profile', 'label' => __('Profile Information'), 'icon' => 'heroicon-s-user'],
        ['route_name' => 'orders.index', 'label' => '我的订单', 'icon' => 'heroicon-o-document-text'],
        ['route_name' => 'user.update-password', 'label' => __('Update Password'), 'icon' => 'heroicon-c-shield-exclamation'],
        ['route_name' => 'user_addresses.index', 'label' => __('User Addresses'), 'icon' => 'heroicon-s-home'],
        ['route_name' => 'user.destroy', 'label' => __('Delete Account'), 'icon' => 'heroicon-s-trash'],
    ];
@endphp

@props(['activeRoute' => null])

<div class="w-80 h-full text-lg text-gray-900 bg-white border border-gray-200 shadow">
    @foreach($routes as $route)
        <a href="{{ route($route['route_name']) }}"
           wire:navigate
           @if(Route::current()->named($route['route_name']) || $activeRoute === $route['route_name'])
               class="relative inline-flex items-center w-full px-4 py-2 border-b border-gray-100 bg-gray-100 text-active font-bold hover:bg-gray-100 hover:text-active focus:z-10 focus:text-active"
           @else
               class="relative inline-flex items-center w-full px-4 py-2 font-medium border-b border-gray-200 hover:bg-gray-100 hover:text-active focus:z-10 focus:text-active"
           @endif
        >
            @if(!empty($route['icon']))
                @svg($route['icon'], 'size-5 me-2')
            @endif
            {{ $route['label'] }}
        </a>
    @endforeach
</div>
