try {                // globally assign select2 fn to $ element
    require('select2/dist/css/select2.css') ;
    window.$ = window.jQuery = require('jquery');
    window.Tether = require('tether');
    window.Popper = require('popper.js').default;
    require('bootstrap');
    require('select2')
} catch (e) {}
