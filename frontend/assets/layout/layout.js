jQuery(function() {
    'use strict';

    const $form = jQuery('#parse-request-form');

    $form.on('submit', function(e) {
        e.preventDefault();

        let data = {};

        $form.serializeArray().forEach(({name, value}) => {
            data[name] = value;
        });

        jQuery.ajax({
            url:      '/api/request/',
            data:     data,
            type:     'post',
            dataType: 'json',
            success:  function({data: id}) {
                location.href = `/api/request/${id}/`;
            }
        });
    });
});
