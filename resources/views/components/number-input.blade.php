@php use Illuminate\Support\Str; @endphp
@props([
    'ref' => 'quantity-' . Str::random(6),
    'min' => 0,
    'max',
    'default' => 0
])

<div
    class="relative flex justify-between items-center bg-white border w-24 md:w-44"
    x-data="{
        min: @js($min),
        max: @js($max ?? null),
        ref: @js($ref),
        counter: null,
        createCounter(min, max) {
            if(this.counter) {
                this.counter.destroy();
                this.counter = null;
            }

            this.counter = new InputCounter($refs[this.ref], null, null, {
                minValue: min,
                maxValue: max,
            })
        },
        decrement() {
            if(this.counter) this.counter.decrement();
        },
        increment() {
            if(this.counter) this.counter.increment();
        },
        init() {
            $nextTick(() => {
                this.createCounter(this.min, this.max);
            });

            $watch('min', (value) => {
                this.createCounter(value,this.max);
                if(this.counter.getCurrentValue() < value) {
                    $refs[this.ref].value = value;
                }
            });
            $watch('max', (value) => {
                this.createCounter(this.min, value);
                if(this.counter.getCurrentValue() > value) {
                    $refs[this.ref].value = value;
                }
            });
        },
    }"
    x-id="['counter-input']"
    wire:ignore
    {{ $attributes }}
>
    <button type="button" class="p-1 md:p-3 h-full" @click="decrement()">
        <x-heroicon-o-minus class="size-4 md:size-6"/>
    </button>
    <input
        x-ref="{{ $ref }}"
        type="text"
        class="h-11 text-center block w-8 md:w-10 p-0 border-none ring-0 focus:ring-0"
        value="{{ $default }}"
    />
    <button type="button" class="p-1 md:p-3 h-full" @click="increment()">
        <x-heroicon-o-plus class="size-4 md:size-6"/>
    </button>
</div>
