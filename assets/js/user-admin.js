(function ($) {
    $(document).ready(function () {

        $('body').on('click', '.user-accept', function (e) {
            e.preventDefault();
            let userid = $(this).data('userid');
            let accept = $(this).data('accept');

            fd = new FormData();
            fd.append('action', 'stm_lms_offerta_accept');
            fd.append('nonce', stm_lms_nonces['stm_lms_add_to_cart']);
            fd.append('userid', userid);
            fd.append('accept', accept);
            $(this).text('Loading...');

            $.ajax({
                url: stm_lms_ajaxurl,
                type: "POST",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function beforeSend() {
                    $(this).addClass('user-stm-loader');

                },
                complete: function complete(data) {
                    data = data['responseJSON'];
                    $(this).removeClass('user-stm-loader');
                 $('#user_stm_id_'+userid).parents('.user-stm-button').html(data['button'])
                }
            });
        });
    });
})(jQuery);
