<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['site_name'] = 'Sapricami CMS';

if ($_SERVER['HTTP_HOST']=='localhost') {
	$config['main_url'] = 'http://localhost/github/cms/';
}else{
	$config['main_url'] = 'http://cms.sapricami.com/';
}

$config['folder'] = 'admin';
$config['theme'] = 'admin';


$config['default_permissions'] = array(
		'siteoptions' => 'Site Options',
		'users' => 'Users',
		'groups' => 'User Groups',
		'permissions' => 'User Permissions',
		'seo' => 'Seo',
		'pages' => 'Pages',
		'menu' => 'Menu',
		'footer' => 'Footer',
		'slider' => 'Slider',
		'blog' => 'Blog',
		'portfolio' => 'Portfolio',
		'photos' => 'Photos',
		'videos' => 'Videos',
		'team' => 'Team',
		'visitors' => 'Visitors',
	);