import './bootstrap';
import 'flowbite';
import * as helpers from './helpers';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import numberInput from "./alpine-extends/number-input.js";
import areaSelects from "./alpine-extends/area-selects.js";

function registerHelpers(win, functions) {
    Object.entries(functions).forEach(function ([funcName, func]) {
        win[funcName] = func;
    });
}

registerHelpers(window, helpers);

registerHelpers(window, {
    numberInput,
    areaSelects,
});

Livewire.start();
