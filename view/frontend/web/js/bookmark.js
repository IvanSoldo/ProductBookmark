define(['jquery'], function ($) {
    'use strict';
    return function (config, element) {
        $.get('/inchoo_bookmark/block', function (result) {
            element.innerHTML = result;
            let id = document.getElementById('product');
            id.value = config.product;
        });
    }
});
