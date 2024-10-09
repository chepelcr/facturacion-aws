/*var requirejs = require('requirejs');

requirejs.config({
    //Pass the top-level main.js/index.js require
    //function to requirejs so that node modules
    //are loaded relative to the top-level JS file.
    nodeRequire: require
});

const Decimal = requirejs('decimal.js');*/

//Decimal.set({ rounding: Decimal.ROUND_HALF_EVEN });

Decimal.set({ precision: 9, rounding: Decimal.ROUND_HALF_EVEN });
