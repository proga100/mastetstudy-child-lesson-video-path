<?php

STM_LMS_User_Child::init();

class STM_LMS_User_Child
{

    public static function init()
    {

        add_filter('stm_lms_float_menu_items', 'STM_LMS_User_Child::stm_lms_float_menu_items', 20, 4);

    }

    public static function stm_lms_float_menu_items($menus, $current_user, $lms_template_current, $object_id)
    {
echo $lms_template_current;
        $menus[] = array(
            'order' => 250,
            'current_user' => $current_user,
            'lms_template_current' => $lms_template_current,
            'lms_template' => 'stm-lms-user-payments',
            'menu_title' => esc_html__('To\'lovlar', 'masterstudy-child'),
            'menu_icon' => 'fa-shopping-basket',
            'menu_url' => STM_LMS_User::login_page_url().'my-payments/',
        );

        return $menus;
    }
}