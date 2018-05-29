define([
    "jquery",
    "handlebars",
    'mage/template',
    "Magento_Ui/js/modal/modal",
    'mage/translate'
], function ($, Handlebars) {
    return function (config) {
        $('#fastly_pattern_validation_button').on('click', function () {
            $.ajax({
                type: "GET",
                url: config.patternValidationUrl
            }).done(function (checkService) {
                var template = Handlebars.compile(checkService.data);
                var data = {
                    "rules": [
                        {
                            "pathpattern": "this/is/some/path",
                            "ttl": "3600",
                            "swr": "20",
                            "sie": "30"
                        },
                        {
                            "pathpattern": "some/other/path",
                            "ttl": "1300",
                            "swr": "40",
                            "sie": "50"
                        }
                    ]
                };
                var result = template(data);
                console.log(result);
            });
        });
    };
});