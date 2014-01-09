<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller']		= "pages";
$route['(home|contact|sitemap)']	= 'pages/$1';
$route['page/(:num)/(:any)']		= 'pages/page/$1/$2';
$route['page/(:num)']				= 'pages/page/$1';
$route['(page)']					= 'pages/home';

$route['admin'] = "admin";  
$route['admin/(login|logout|home|update|menu|menu_save|menu_delete|settings|save_settings)'] = "admin/$1";
$route['admin/([a-zA-Z_-]+)/(:any)'] = "$1/admin/$2";
$route['admin/([a-zA-Z_-]+)'] = "$1/admin"; 

$route['404_override'] = 'error/not_found';


/* End of file routes.php */
/* Location: ./application/config/routes.php */