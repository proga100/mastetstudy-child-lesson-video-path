<?php
wp_enqueue_script('vue.js');
wp_enqueue_script('vue-resource.js');
stm_lms_register_script('account/v1/my-orders');
stm_lms_register_style('cart');
stm_lms_register_style('user-orders');
?>

<?php STM_LMS_Templates::show_lms_template('account/private/parts/top_info', array(
    'title' => esc_html__('Mening To\'lovlarim', 'masterstudy-lms-learning-management-system')
)); ?>

<div id="my-payments">

    <div class="stm-lms-user-orders" >

        <div class="stm-lms-user-order" >
            <h4 class="stm-lms-user-order__title" ></h4>
            <div class="stm-lms-user-order__status"></div>
            <div class="stm-lms-user-order__status" ></div>
            <div class="stm-lms-user-order__more" >
                <i class="lnr"></i>
            </div>

            <div class="stm-lms-user-order__advanced" >

                <table>
                    <tbody>
                    <tr >
                        <td class="image">
                            <div class="stm-lms-user-order__image" ></div>
                        </td>
                        <td class="name">
                            <span ></span>

                        </td>
                        <td class="price">

                            <strong></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <h4 ><?php esc_html_e('Tolov yo\'q.', 'masterstudy-lms-learning-management-system'); ?></h4>

    </div>



</div>