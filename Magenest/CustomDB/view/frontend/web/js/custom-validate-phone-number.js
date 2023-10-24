define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function ($) {
    'use strict';
    return function () {
        $.validator.addMethod(
            "custom-validate-phone-number",
            function (value) {
                const case1 = /^\+?([0-9]{2})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})?[-. ]?([0-9]{3})$/;
                const case2 = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
                const case3 = /^\+?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

                return (value.match(case1) || value.match(case2) || value.match(case3));
            },
            $.mage.__("Your validation message.")
        );
    }
});
