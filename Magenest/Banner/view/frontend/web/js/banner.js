define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    return Component.extend({
        /**
         * @override
         */
        initialize: function () {
            this._super();
            this.bannerListing = ko.observable(this.bannerAvailable);
        },
    });
});
