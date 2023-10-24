var config = {
    map: {
        "*": {
            customValidateMagenest: 'Magenest_CustomDB/js/custom-validate-phone-number'
        }

    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/billing-address': {
                'Magenest_CustomDB/js/view/billing-address-mixin': true
            }
        }
    }
};
