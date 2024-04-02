import { InputCounter } from "flowbite";

export default function numberInput({ state = 0, min = 0, max = min }) {
    return {
        state,
        min,
        max,
        counter: null,
        createCounter(min, max) {
            this.destroyCounter();

            this.counter = new InputCounter(
                this.$refs.input,
                this.$refs.incrBtn,
                this.$refs.decrBtn,
                {
                    minValue: min,
                    maxValue: max,
                }
            );
            this.counter.updateOnIncrement(() => {
                this.state = this.counter.getCurrentValue();
            });
            this.counter.updateOnDecrement(() => {
                this.state = this.counter.getCurrentValue();
            });
        },

        destroyCounter() {
            if (this.counter) {
                this.counter.destroyAndRemoveInstance();
            }
            this.counter = null;
        },

        async init() {
            if(this.max < this.min) this.max = this.min;

            await this.$nextTick();

            this.createCounter(this.min, this.max);

            this.$watch('min', (value) => {
                this.createCounter(value, this.max);
                if (this.counter.getCurrentValue() < value) {
                    this.state = value;
                }
            });

            this.$watch('max', (value) => {
                this.createCounter(this.min, value);
                if (this.counter.getCurrentValue() > value) {
                    this.state = value;
                }
            });

            this.$watch('state', (value) => {
                if (value > this.max) {
                    this.state = this.max;
                } else if (value < this.min) {
                    this.state = this.min;
                }
            });
        },
        destroy() {
            this.destroyCounter();
        },
        input: {
            ['x-model.number']: 'state',
            ['x-ref']: 'input',
        },
        wrapper: {
            ['x-modelable']: 'state',
        }
    }
}
