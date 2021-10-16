(function ($) {
    $(document).ready(function () {
        let selected_savol_global = [];
        $('body').on('change', '.sel_savol', function (e) {
            let right_answers = {
                'savol_1': 'Xa',
                'savol_2': 'Xa'
            };

            let checked_answer = [];
            let i = 0;
            $('.sel_savol').each(function (key, value) {
                let user_meta_key = $(value).attr('name');
                if (right_answers[user_meta_key] == $(value).val()) {
                    selected_savol_global [i] = 'true';
                } else {
                    selected_savol_global [i] = 'false';
                }
                i++;
            });

            if (selected_savol_global .includes('false')) {
                $('#tasdiqlash').css('display', 'none');
            } else {

                $('#tasdiqlash').css('display', 'inline-block');

            }

        });

        if (selected_savol_global .includes('false')) {
            console.log(selected_savol_global );
            $('#tasdiqlash').css('display', 'none');
        } else {
            $('#tasdiqlash').css('display', 'inline-block');

            $('body').on('click', '.offerta-accept', function (e) {
                e.preventDefault();
                if (selected_savol_global.includes('false')) {
                    console.log(selected_savol_global);
                   return;
                }
                let userid = $(this).data('userid');
                let accept = $(this).data('accept');
                let select = $(this).parents('.stm-lms-modal-oferta').find('select');
                let selected_savol = {};

                $.each(select, function (key, value) {
                    let user_meta_key = $(value).attr('name');
                    selected_savol[user_meta_key] = {
                        'user_meta_key_value': $(value).val(),
                        'user_meta_key_label': $(value).find('option:selected').text()
                    }
                });
                $.ajax({
                    url: stm_lms_ajaxurl,
                    dataType: 'json',
                    context: this,
                    data: {
                        action: 'stm_lms_offerta',
                        nonce: stm_lms_nonces['load_modal'],
                        userid: userid,
                        accept: accept,
                        selected_javoblar: selected_savol
                    },
                    beforeSend: function beforeSend() {
                        $(this).addClass('loading');
                    },
                    complete: function complete(data) {
                        data = data['responseJSON'];
                        $(this).removeClass('loading');
                       if ( data['accept'] == 'no'){
                           location.href =  data['redirect_url'];
                       }
                    }
                });

            });
        }

        $('.stm-lms-modal-oferta-button').trigger('click');
    });
})(jQuery);
