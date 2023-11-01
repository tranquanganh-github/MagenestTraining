/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Customer/js/customer-data',
], function (customerData) {
    'use strict';

    var shippingDateExtend = {
        defaults: {
            template: 'Magenest_ShippingDate/shipping-information'
        },

        /**
         * Get shipping method title based on delivery method.
         *
         * @return {String}
         */
        getShippingDate: function () {
            var cartData = customerData.get('cart');

            if (cartData._latestValue.shipping_date !== null) {
                return cartData._latestValue.shipping_date;
            }

            return 'N/A';
        },
    };

    return function (shippingInformation) {
        return shippingInformation.extend(shippingDateExtend);
    };
});
