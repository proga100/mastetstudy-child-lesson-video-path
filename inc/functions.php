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
