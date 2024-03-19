export const isEmpty = (obj) => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;

export const unique = (array) => [...new Set(array)];
