<div {{ $attributes->merge([
    'class' => 'w-6 flex flex-col gap-1.5 group',
    'data-open' => 'false',
]) }}>
    <span
        {{--:class="open ? 'rotate-[135deg] translate-y-2' : ''"--}}
        class="block w-full h-0.5 bg-white transition-transform duration-300 group-data-[open=true]:rotate-[135deg] group-data-[open=true]:translate-y-2"></span>
    <span
        {{--:class="open ? 'opacity-0' : ''"--}}
        class="block w-full h-0.5 bg-white transition-opacity duration-300 origin-center group-data-[open=true]:opacity-0"></span>
    <span
        {{--:class="open ? 'rotate-[225deg] -translate-y-2' : ''"--}}
        class="block w-full h-0.5 bg-white transition-transform duration-300 group-data-[open=true]:rotate-[225deg] group-data-[open=true]:-translate-y-2"></span>
</div>