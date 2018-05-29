try {
    window.$ = window.jQuery = require('jquery');
    window.Tether = require('tether');
    window.Popper = require('popper.js').default;
    require('bootstrap');
} catch (e) {}
