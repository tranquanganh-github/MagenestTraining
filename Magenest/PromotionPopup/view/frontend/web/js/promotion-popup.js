define([
    "jquery",
    "Magento_Ui/js/modal/modal"
], function ($, modal) {
    return function (config, element) {
        var options = {
            type: 'popup',
            title: 'Promotion',
            responsive: true,
            innerScroll: true,
            buttons: [
                {
                    text: $.mage.__('Continue'),
                    click: function () {
                        this.closeModal();
                    }
                }
            ]
        }

        modal(options, $('#magenest-promotion-popup'));
        $("#magenest-promotion-popup").modal("openModal");
        $("#magenest-popup-notification").append(config.notification)
    }
});
