<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Mobile Extends MX_Controller {
	
	public function __construct()
	{
		
	}
	
	public function index()
	{
		parent::home();
	}
	
	public function home()
	{
		echo 'mobil anasayfa';
	}
	
	public function goRealSite()
	{
		$cookie = array(
			'name'   => 'skip_mobile',
			'value'  => 'ok',
			'expire' => '86500',
			//'domain' => '.some-domain.com',
			//'path'   => '/',
			//'prefix' => 'myprefix_',
			//'secure' => TRUE
		);
		$this->input->set_cookie($cookie);
		redirect(base_url());
	}
}