@php use Illuminate\Support\Str; @endphp
@props([
    'min' => 0,
    'max',
])

<div
    class="relative flex justify-between items-center bg-white border w-24 md:w-44"
    x-data="{
        min: @js($min),
        max: @js($max ?? null),
        inputValue: 0,
        counter: null,
        createCounter(min, max) {
            if(this.counter) {
                this.counter.destroy();
                this.counter = null;
            }

            this.counter = new InputCounter(
                $el.querySelector('input'),
                $el.lastElementChild,
                $el.firstElementChild,
                {
                    minValue: min,
                    maxValue: max,
                }
            );
            this.counter.updateOnIncrement(() =>  {
                this.inputValue = this.counter.getCurrentValue();
            });
            this.counter.updateOnDecrement(() => {
                this.inputValue = this.counter.getCurrentValue();
            });
        },
        init() {
            this.inputValue = this.min;
            this.createCounter(this.min, this.max);

            $watch('min', (value) => {
                this.createCounter(value,this.max);
                if(this.counter.getCurrentValue() < value) {
                    this.inputValue = value;
                }
            });
            $watch('max', (value) => {
                this.createCounter(this.min, value);
                if(this.counter.getCurrentValue() > value) {
                    this.inputValue = value
                }
            });
            $watch('inputValue', (value) => {
                if(value > this.max) {
                    this.inputValue = this.max
                }
            })
        },
        destroy() {
            if (this.counter) this.counter.destroy();
        },
    }"
    x-id="['counter-input']"
    x-modelable="inputValue"
    {{ $attributes }}
>
    <button type="button" class="p-1 md:p-3 h-full">
        <x-heroicon-o-minus class="size-4 md:size-6"/>
    </button>
    <input
        type="text"
        class="h-11 text-center block w-8 md:w-10 p-0 border-none ring-0 focus:ring-0"
        x-model.number="inputValue"
    />
    <button type="button" class="p-1 md:p-3 h-full">
        <x-heroicon-o-plus class="size-4 md:size-6"/>
    </button>
</div>
