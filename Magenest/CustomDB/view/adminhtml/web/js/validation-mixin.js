define([
    'mage/translate'
], function ($t) {
    'use strict';

    return function (rules) {
        rules['custom-validate-phone-number'] = {
            handler: function (value) {
                const case1 = /^\+?([0-9]{2})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})?[-. ]?([0-9]{3})$/;
                const case2 = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
                const case3 = /^\+?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

                return (value.match(case1) || value.match(case2) || value.match(case3));
            },

            message: $t('Not a valid Phone Number.')
        };

        return rules;
    };
});
