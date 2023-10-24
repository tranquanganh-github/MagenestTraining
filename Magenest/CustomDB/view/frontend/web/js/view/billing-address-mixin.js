define([], function () {
    'use strict';

    return function (originalComponent) {
        return originalComponent.extend({
            /**
             * Custom function to display label by value
             */
            getCustomAttributeOptionLabel: function (attributeCode, value) {
                if (attributeCode !== 'vn_region') {
                    return this._super(attributeCode, value)
                }
                /**
                 * Get vn Region array from window.vnRegion
                 */
                let vnRegion = window.vnRegion,
                    resultVnRegion = '';

                if (vnRegion && value) {
                    vnRegion.forEach(function getLabel(item)
                    {
                        if (item.value === value) {
                            resultVnRegion = item.label
                        }
                    })
                }
                return resultVnRegion
            }
        });
    };
});
