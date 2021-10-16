(function ($) {
    $(document).ready(function () {
        $('body').on('click', '.offerta-accept', function (e) {
            e.preventDefault();
            let userid = $(this).data('userid');
            let accept = $(this).data('accept');
            let select = $(this).parents('.stm-lms-modal-oferta').find('select');
            let selected_savol = {};

            $.each(select, function (key, value) {
                let user_meta_key = $(value).attr('name');
                selected_savol[user_meta_key] = {
                    'user_meta_key_value': $(value).val(),
                    'user_meta_key_label': $(value ).find('option:selected').text()
                }
            });
            $.ajax({
                url: stm_lms_ajaxurl,
                data: {
                    action: 'stm_lms_offerta',
                    nonce: stm_lms_nonces['load_modal'],
                    userid: userid,
                    accept: accept,
                    selected_javoblar: JSON.stringify(selected_savol)
                },
                beforeSend: function beforeSend() {
                    $(this).addClass('loading');
                },
                complete: function complete(data) {
                    $(this).removeClass('loading');
                    console.log(data);
                }
            });

        });

        $('.stm-lms-modal-oferta-button').trigger('click');
    });
})(jQuery);
