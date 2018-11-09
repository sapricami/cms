<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('bootstrap_alert'))
{
	function bootstrap_alert($class,$content)
	{
		return '<div class="alert alert-'.$class.'">'.$content.'</div>';
	}
}