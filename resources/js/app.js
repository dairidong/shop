import './bootstrap';
import 'flowbite';
import * as helpers from './helpers';

function registerHelpers(win, functions) {
    Object.entries(functions).forEach(function ([funcName, func]) {
        win[funcName] = func;
    });
}

registerHelpers(window, helpers)
