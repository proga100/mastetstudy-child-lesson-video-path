<?php
/**
 *
 * @var $id
 */

$lesson_video_poster = get_post_meta($id, 'lesson_video_poster', true);
$lesson_video_url = get_post_meta($id, 'lesson_video_url', true);
$lesson_video = get_post_meta($id, 'lesson_video', true);
$lesson_video_width = get_post_meta($id, 'lesson_video_width', true);
if (!empty($lesson_video)) {
	$uploaded_video = wp_get_attachment_url($lesson_video);
	$type = explode('.', $uploaded_video);
	$type = strtolower(end($type));
}

if (!empty($lesson_video_poster) and !empty($lesson_video_url)): ?>
    <div class="stm_lms_video stm_lms_video__iframe"
         style="background: url('<?php echo esc_url(stm_lms_get_image_url($lesson_video_poster, 'full')); ?>');">
        <i class="stm_lms_play"></i>
        <iframe data-src="<?php echo esc_url($lesson_video_url); ?>" allowfullscreen webkitallowfullscreen
                mozallowfullscreen></iframe>
    </div>
<?php endif;

if (!empty($uploaded_video)): ?>
    <video
           controls
           controlsList="nodownload" width="576" height="720"
           src="<?php echo esc_url($uploaded_video); ?>" type='video/<?php echo esc_attr($type); ?>'
    >

    </video>
<?php endif; ?>
