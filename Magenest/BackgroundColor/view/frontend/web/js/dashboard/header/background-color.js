define([
    'jquery'
], function ($) {
    'use strict';

    $(document).ready(function () {
        $('#magenest-background-color-select').on('change', function () {
            if ($(this).find('option:selected').val() === 'default') {
                document.body.style.backgroundColor = '#ffffff';
            }
            document.body.style.backgroundColor = $(this).find('option:selected').val();
        });
    });
});
