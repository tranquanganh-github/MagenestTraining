define(
    [
        "jquery",
        "Magento_Ui/js/modal/modal"
    ], function ($, modal) {
        let optionsModalAlert = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Modal popup',
            clickableOverlay: true,
            buttons: [{
                text: $.mage.__('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        }

        let optionsModalLogin = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Login',
            clickableOverlay: true,
            buttons: []
        }

        modal(optionsModalAlert, $('#modal-alert-content'));
        $('#modal-button-alert').on('click', function () {
            $('#modal-alert-content').modal('openModal');
        })

        modal(optionsModalLogin, $('#modal-login-content'));
        $('#modal-button-login').on('click', function () {
            $('#modal-login-content').modal('openModal');
        })
    }
);
