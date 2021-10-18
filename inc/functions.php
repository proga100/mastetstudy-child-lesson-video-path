<?php
if (!function_exists('stm_put_log')) {
    function stm_put_log($file_name, $data, $append = true)
    {
        $file = get_stylesheet_directory() . "/logs/{$file_name}.log";
        $data = date('d.m.Y H:i:s', time()) . " - " . var_export($data, true) . "\n";
        if ($append) file_put_contents($file, $data, FILE_APPEND);
        else file_put_contents($file, $data);
    }
}

function add_init_lms()
{
    wp_dequeue_script('stm-lms-lms');
    wp_enqueue_script('stm-lms-lms-custom', get_stylesheet_directory_uri() . '/assets/js/lms.js', [], stm_lms_custom_styles_v(), false);
    wp_localize_script('stm-lms-lms-custom', 'stm_lms_vars', array(
        'symbol' => STM_LMS_Options::get_option('currency_symbol', '$'),
        'position' => STM_LMS_Options::get_option('currency_position', 'left'),
        'currency_thousands' => STM_LMS_Options::get_option('currency_thousands', ','),
        'wp_rest_nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts', 'add_init_lms', 11);
$data = $payload = json_decode(file_get_contents('php://input'), true);
//stm_put_log('all_request', $data);
add_action('init', 'load_modal_oferta');

function load_modal_oferta($modal = 'oferta', $params = [])
{
    $user_id = get_current_user_id();
    $oferta = (get_user_meta($user_id, 'accept', true)) ? get_user_meta($user_id, 'accept', true) : false;

    if ($user_id && $oferta != 'yes') {
        wp_enqueue_script('script-modal-oferta', get_stylesheet_directory_uri() . '/assets/js/lms-oferta.js', array('jquery'), time(), true);
    }
}

add_filter('manage_users_columns', 'pippin_add_user_id_column');
function pippin_add_user_id_column($columns)
{
    $columns['user_id'] = 'User ID';
    return $columns;
}

add_action('manage_users_custom_column', 'pippin_show_user_id_column_content', 10, 3);
function pippin_show_user_id_column_content($value, $column_name, $user_id)
{
    $user = get_userdata($user_id);
    if ('user_id' == $column_name)
        return $user_id;
    return $value;
}


function stm_lms_offerta()
{
    //check_ajax_referer('stm_lms_add_to_cart', 'nonce');
    $user_id = (get_current_user_id()) ? get_current_user_id() : null;
    $accept = ($_REQUEST['accept']) ? sanitize_text_field($_REQUEST['accept']) : null;
    $selected_javoblar = ($_REQUEST['selected_javoblar']) ? (array)json_decode(str_replace("\\", "", $_REQUEST['selected_javoblar'])) : null;

    $passport = upload_stm_file($user_id);

    update_user_meta($user_id, 'accept', $accept);
    $user_info = get_user_meta($user_id);
    foreach ($selected_javoblar as $key => $javoblar) {
        $javoblar = (array)$javoblar;
        update_user_meta($user_id, $key, $javoblar);
    }
    $redirect_url = '';
    if ($passport) {
        update_user_meta($user_id, 'passport', $passport);
        send_email($user_id);
    };
    if ($accept == 'no') {
        wp_logout();
        $redirect_url = site_url();
    }
    $response = [
        'userid' => $user_id,
        'userinfo' => $user_info,
        'redirect_url' => $redirect_url,
        'accept' => $accept
    ];

    wp_send_json($response);
}

add_action('wp_ajax_stm_lms_offerta', 'stm_lms_offerta');
add_action('wp_ajax_nopriv_stm_lms_offerta', 'stm_lms_offerta');


function load_oferta_ajax()
{

    check_ajax_referer('stm_lms_add_to_cart', 'nonce');

    if (empty($_GET['modal'])) die;
    $r = array();

    $modal = 'modals/' . sanitize_text_field($_GET['modal']);
    $params = (!empty($_GET['params'])) ? json_decode(stripslashes_deep($_GET['params']), true) : array();
    $r['params'] = $params;
    $r['modal'] = STM_LMS_Templates::load_lms_template($modal, $params);

    wp_send_json($r);

}

add_action('wp_ajax_load_oferta_ajax', 'load_oferta_ajax');
add_action('wp_ajax_nopriv_load_oferta_ajax', 'load_oferta_ajax');


function upload_stm_file($user_id)
{
    global $wp_filesystem;
    WP_Filesystem();
    $upload = 'uploads/';
    $passport = 'passports';
    $content_directory = $wp_filesystem->wp_content_dir() . $upload;
    $wp_filesystem->mkdir($content_directory . $passport);

    $target_dir_location = $content_directory . "{$passport}/";

    if (isset($_FILES['file'])) {
        $name_file = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $name_file = time() . "_{$user_id}_{$name_file}";
        if (move_uploaded_file($tmp_name, $target_dir_location . $name_file)) {
            return "{$upload}{$passport}/{$name_file}";
        } else {
            return false;
        }
    }
}

function send_email($user_id)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $firstname = get_user_meta($user_id, 'first_name', true);
    $lastname = get_user_meta($user_id, 'lastname', true);
    $passport = get_user_meta($user_id, 'passport', true);
    $accept = (get_user_meta($user_id, 'accept', true) == 'yes') ? 'Xa' : 'Yoq';
    $body = " $firstname $lastname royhatdan otdi. Va Tasdiqlagan hoalti '$accept'. ";
    global $wp_filesystem;
    WP_Filesystem();

    $file = $wp_filesystem->wp_content_dir() . $passport;

    if ($file) {
        $uid = "passport_{$user_id}"; //will map it to this UID
        $name = 'file.jpg'; //this will be the file name for the attachment

        global $phpmailer;
        add_action('phpmailer_init', function (&$phpmailer) use ($file, $uid, $name) {
            $phpmailer->SMTPKeepAlive = true;
            $phpmailer->AddEmbeddedImage($file, $uid, $name);
        });
    }
    $admin_email = get_option('admin_email');
   // $attachments = array(WP_CONTENT_DIR . '/' . $passport);
    $headers = 'From: Itstar <admin@itstar.uz>' . "\r\n";
//print_r ($attachments);
    wp_mail($admin_email, 'Salom Zafar itstar habar', $body, $headers );
}
