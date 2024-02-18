<div {{ $attributes->merge(['class' => 'w-6 flex flex-col gap-1.5']) }}>
    <span :class="open ? 'rotate-[135deg] translate-y-2' : ''"
          class="block w-full h-0.5 bg-white transition-transform duration-300"></span>
    <span :class="open ? 'opacity-0' : ''"
          class="block w-full h-0.5 bg-white transition-opacity duration-300 origin-center"></span>
    <span :class="open ? 'rotate-[225deg] -translate-y-2' : ''"
          class="block w-full h-0.5 bg-white transition-transform duration-300"></span>
</div>