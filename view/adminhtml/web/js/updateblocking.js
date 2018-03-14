define([
    "jquery",
    'mage/template',
    "Magento_Ui/js/modal/modal",
    'mage/translate'
], function ($) {
    return function (config) {
        successBtnMsg = $('#fastly-update-blocking-success-button-msg');
        errorBtnMsg = $('#fastly-update-blocking-error-button-msg');
        warningBtnMsg = $('#fastly-update-blocking-warning-button-msg');

        $('#fastly_update_blocking_button').on('click', function () {
            resetAllMessages();
            $.ajax({
                type: "POST",
                url: config.updateBlockingUrl,
                showLoader: true,
                data: {
                    'service_id': $('#system_full_page_cache_fastly_fastly_service_id').val(),
                    'api_key': $('#system_full_page_cache_fastly_fastly_api_key').val()
                },
                cache: false,
                success: function (response) {
                    if (response.status == false) {
                        return errorBtnMsg.text($.mage.__('Please make sure that blocking is enabled.')).show();
                    } else {
                        return successBtnMsg.text($.mage.__('Blocking snippet has been updated successfully.')).show();
                    }
                },
                error: function (msg) {
                    return errorBtnMsg.text($.mage.__('An error occurred while processing your request. Please try again.')).show();
                }
            });
        });
    };

    function resetAllMessages()
    {
        successBtnMsg.text();
        successBtnMsg.hide();
        errorBtnMsg.text();
        errorBtnMsg.hide();
        warningBtnMsg.text();
        warningBtnMsg.hide();
    }
});