<?php

add_filter('stm_wpcfto_fields', function ($fields) {

	$data_fields = array(
		'stm_lesson_settings' => array(
			'section_lesson_settings' => array(
				'name' => esc_html__('Lesson Settings', 'masterstudy-lms-learning-management-system'),
				'fields' => array(
					'type' => array(
						'type' => 'select',
						'label' => esc_html__('Lesson type', 'masterstudy-lms-learning-management-system'),
						'options' => array(
							'text' => esc_html__('Text', 'masterstudy-lms-learning-management-system'),
							'video' => esc_html__('Video', 'masterstudy-lms-learning-management-system'),
							'slide' => esc_html__('Slide', 'masterstudy-lms-learning-management-system'),
						),
						'value' => 'text'
					),
					'duration' => array(
						'type' => 'text',
						'label' => esc_html__('Lesson duration', 'masterstudy-lms-learning-management-system'),
					),
					'preview' => array(
						'type' => 'checkbox',
						'label' => esc_html__('Lesson preview (Lesson will be available to everyone)', 'masterstudy-lms-learning-management-system'),
					),
					'lesson_excerpt' => array(
						'type' => 'editor',
						'label' => esc_html__('Lesson Frontend description', 'masterstudy-lms-learning-management-system'),
					),
					'lesson_video_poster' => array(
						'type' => 'image',
						'label' => esc_html__('Lesson video poster', 'masterstudy-lms-learning-management-system'),
					),
					'lesson_video_url' => array(
						'type' => 'text',
						'label' => esc_html__('Lesson video URL', 'masterstudy-lms-learning-management-system'),
					),
					'lesson_video' => array(
						'type' => 'video',
						'label' => esc_html__('Lesson video', 'masterstudy-lms-learning-management-system'),
						'dependency' => array(
							'key' => 'type',
							'value' => 'video'
						)
					),

					'lesson_video_width' => array(
						'type' => 'number',
						'label' => esc_html__('Lesson video width', 'masterstudy-lms-learning-management-system'),
						'dependency' => array(
							'key' => 'lesson_video',
							'value' => 'not_empty'
						)
					),
					'lesson_files_pack' => stm_lms_lesson_files_data()
				)
			)
		)
	);

	// $fields = array_merge($data_fields, $fields);
	show_data($fields);
	return $fields;
});