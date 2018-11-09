<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('alert'))
{
	function alert($class,$content)
	{
		return '<div class="alert alert-'.$class.' alert-fill">'.$content.'</div>';
	}
}

if ( ! function_exists('main_url'))
{
	function main_url()
	{	
		$CI =& get_instance();
		return $CI->config->item('main_url');
	}
}

if ( ! function_exists('root_dir'))
{
	function root_dir()
	{	
		$CI =& get_instance();
		return $_SERVER['DOCUMENT_ROOT'].str_replace(array($_SERVER['DOCUMENT_ROOT'],'/'.$CI->config->item('folder')), '', dirname($_SERVER['SCRIPT_FILENAME']));
	}
}

