require([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $(document).on('change focus', "[name='group_id']", function () {
        $("[name='group_id']").autocomplete({
            source: function (request, response) {
                var base_url = window.location.origin;
                $.ajax({
                    url: base_url + "/admin/cybage_storelocator/dealer/grouplist",
                    dataType: "json",
                    showLoader: true,
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1
        });
    });

    $(document).on('change focus', "[name='city_id']", function () {
        $("[name='city_id']").autocomplete({
            source: function (request, response) {
                var base_url = window.location.origin;
                $.ajax({
                    url: base_url + "/admin/cybage_storelocator/dealer/citylist",
                    dataType: "json",
                    showLoader: true,
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1
        });
    });
});