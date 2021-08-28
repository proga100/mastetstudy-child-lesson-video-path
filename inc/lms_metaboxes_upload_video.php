<?php

class LmsUploadField
{
	function __construct()
	{
		add_action('add_meta_boxes', [$this, 'add_custom_meta_boxes']);
	}

	function add_custom_meta_boxes()
		{

			// Define the custom attachment for posts
			add_meta_box(
				'wp_custom_attachment',
				'Custom Attachment',
				array($this, 'wp_custom_attachment'),
				'stm-lessons',
				'normal'
			);

		}

	function wp_custom_attachment()
		{

			wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');

			$html = '<p class="description">';
			$html .= 'Upload your PDF here.';
			$html .= '</p>';
			$html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';

			echo $html;

		} // end wp_custom_attachment
}

new LmsUploadField;




