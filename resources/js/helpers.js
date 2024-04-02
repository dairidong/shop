export const isEmpty = (obj) => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;

export const unique = (array) => [...new Set(array)];

export const debounce = (func, wait, immediate) => {
    let timeout;
    return function () {
        let context = this, args = arguments;
        clearTimeout(timeout);
        if (immediate && !timeout) func.apply(context, args);
        timeout = setTimeout(function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        }, wait);
    };
}
