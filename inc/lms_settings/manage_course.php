<?php

if (class_exists('STM_LMS_Manage_Course')):
	class STM_LMS_Manage_Course_Child
	{
		public static function init()
		{
			remove_action('wp_ajax_stm_lms_pro_save_lesson', 'STM_LMS_Manage_Course::save_lesson');
			add_action('wp_ajax_stm_lms_pro_save_lesson', 'STM_LMS_Manage_Course_child::save_lesson');
		}

		public static function save_lesson()
		{

			check_ajax_referer('stm_lms_pro_save_lesson', 'nonce');

			$post_id = intval($_POST['post_id']);
			$post_title = sanitize_text_field($_POST['post_title']);
			$allowed_tags = stm_lms_pro_allowed_html();
			$content = wp_kses($_POST['content'], $allowed_tags);

			do_action('stm_lms_pro_before_save_lesson');


			if (!empty($_FILES)) {
				$is_valid_image = Validation::is_valid($_FILES, array(
					'image' => 'required_file|extension,png;jpg;jpeg',
					'lesson_video' => 'required_file|extension,mp4;webm;ogg;ogv',
				));

				if ($is_valid_image) {
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');

					if (!empty($_FILES['lesson_video'])) {
						$video = media_handle_upload('lesson_video', 0);


						update_post_meta($post_id, 'lesson_video', $video);
					}
					if (!empty($_FILES['image'])) {
						$attachment_id = media_handle_upload('image', 0);
						update_post_meta($post_id, 'lesson_video_poster', $attachment_id);
					}
				}
			}

			if (!empty($post_id) and !empty($post_title) and isset($content)) {

				kses_remove_filters();

				$post = array(
					'ID' => $post_id,
					'post_content' => $content,
				);

				wp_update_post($post);

				kses_init_filters();
			}

			if (isset($_POST['assignment_tries'])) {
				update_post_meta($post_id, 'assignment_tries', intval($_POST['assignment_tries']));
			}

			if (isset($_POST['lesson_video_url'])) {
				update_post_meta($post_id, 'lesson_video_url', wp_kses_post($_POST['lesson_video_url']));
			}

			if (isset($_POST['lesson_files_pack'])) {
				update_post_meta($post_id, 'lesson_files_pack', wp_kses_post($_POST['lesson_files_pack']));
			}

			if (isset($_POST['lesson_excerpt'])) {
				update_post_meta($post_id, 'lesson_excerpt', wp_kses_post($_POST['lesson_excerpt']));
			}

			if (isset($_POST['type'])) {
				update_post_meta($post_id, 'type', wp_kses_post($_POST['type']));
			}

			if (isset($_POST['duration'])) {
				update_post_meta($post_id, 'duration', wp_kses_post($_POST['duration']));
			}

			if (isset($_POST['stm_password'])) {
				update_post_meta($post_id, 'stm_password', wp_kses_post($_POST['stm_password']));
			}

			if (isset($_POST['stream_start_date'])) {
				update_post_meta($post_id, 'stream_start_date', wp_kses_post($_POST['stream_start_date']));
			}

			if (isset($_POST['stream_start_time'])) {
				update_post_meta($post_id, 'stream_start_time', wp_kses_post($_POST['stream_start_time']));
			}

			if (isset($_POST['lesson_lock_from_start'])) {
				update_post_meta($post_id, 'lesson_lock_from_start', sanitize_text_field($_POST['lesson_lock_from_start']));
			}

			if (isset($_POST['lesson_start_date'])) {
				update_post_meta($post_id, 'lesson_start_date', wp_kses_post($_POST['lesson_start_date']));
			}

			if (isset($_POST['lesson_start_time'])) {
				update_post_meta($post_id, 'lesson_start_time', wp_kses_post($_POST['lesson_start_time']));
			}

			if (isset($_POST['lesson_lock_start_days'])) {
				update_post_meta($post_id, 'lesson_lock_start_days', sanitize_text_field($_POST['lesson_lock_start_days']));
			}

			if (isset($_POST['stream_end_date'])) {
				update_post_meta($post_id, 'stream_end_date', wp_kses_post($_POST['stream_end_date']));
			}

			if (isset($_POST['stream_end_time'])) {
				update_post_meta($post_id, 'stream_end_time', wp_kses_post($_POST['stream_end_time']));
			}

			if (!empty($_POST['timezone'])) {
				update_post_meta($post_id, 'timezone', wp_kses_post($_POST['timezone']));
			}

			if (isset($_POST['preview'])) {
				$value = ($_POST['preview'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'preview', $value);
			}

			if (isset($_POST['zoom_password'])) {
				update_post_meta($post_id, 'zoom_password', sanitize_text_field($_POST['zoom_password']));
			}

			if (isset($_POST['join_before_host'])) {
				$value = ($_POST['join_before_host'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'join_before_host', $value);
			}

			if (isset($_POST['option_host_video'])) {
				$value = ($_POST['option_host_video'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'option_host_video', $value);
			}

			if (isset($_POST['option_participants_video'])) {
				$value = ($_POST['option_participants_video'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'option_participants_video', $value);
			}

			if (isset($_POST['option_mute_participants'])) {
				$value = ($_POST['option_mute_participants'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'option_mute_participants', $value);
			}

			if (isset($_POST['option_enforce_login'])) {
				$value = ($_POST['option_enforce_login'] === 'true') ? 'on' : '';
				update_post_meta($post_id, 'option_enforce_login', $value);
			}

			do_action('stm_lms_save_lesson_after_validation', $post_id, $_POST);

			wp_send_json('Saved');

		}
	}

	STM_LMS_Manage_Course_Child::init();
endif;