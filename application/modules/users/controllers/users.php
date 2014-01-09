<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Users Extends MX_Controller
{
	# Sınıf içi değişkenler :)
	private $user_stats;
	private $fb_data;
	private $menuler;
	private $gb_last_entry;
	private $prayer;
	private $hava;
	
	public function __construct()
	{
		parent::__construct();
		# Veritabanından ayarları al
		$this->system_model->getSettings();
		# Tarayıcıyı kontrol et!
		$this->system_model->check_browser();
		# Facebook Modelini yükle
		$this->load->model('facebook_model');
		$this->fb_data = $this->session->userdata('fb_data');
		# Sınıfın kendi modelini yükle
		$this->load->model('users_model');
	}
	
	private function __prep()
	{
		
		# İstatistikleri tut
		$this->user_stats = $this->system_model->getStats();
		# Menüler
		$this->menuler = $this->system_model->getMenu();
		# Ziyaretçi Defteri için
		$this->load->model('guestbook/guestbook_model');
		$this->gb_last_entry = $this->guestbook_model->getLastEntry();
		# Namaz Vakitleri
		if ($this->config->item('prayer_active') == 1)
		{
			$cache_klasoru = './cache/';
			$this->load->library('namazvakti', $cache_klasoru);
			$this->prayer = $this->namazvakti->vakit( $this->config->item('prayer_location'), $this->config->item('prayer_country') );
		}
		# hava durumu
		if ($this->config->item('weather_active') == 1)
		{
			$this->load->library('weather');
			$this->hava = $this->weather->GetWeather($this->config->item('weather_location'));
		}
		# uriyi belirle
		$this->session->set_userdata('last_page',$this->uri->uri_string());
	}
	
	public function index()
	{
		redirect();
	}
	
	# Facebook girişi yapıldıktan sonra kaydet
	public function login()
	{
		$return = $this->input->get();
		if (array_key_exists('code',$return))
		{
			$fb_data = $this->session->userdata('fb_data');
			if((!$fb_data['uid']) or (!$fb_data['me']))
			{
				redirect($this->session->userdata('last_page'));
			}
			else
			{
				$this->users_model->save_user($fb_data);
				redirect($this->session->userdata('last_page'));
			}
		} else {
			redirect($this->session->userdata('last_page'));
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect($this->session->userdata('last_page'));
	}
	
	public function dashboard()
	{
		# Öncelikle sayfayı hazırla!
		$this->__prep();
		
		# Sidebar için verileri çekelim
		# Facebook için session değerini al ve tanımla
		$fb = $this->fb_data;
		
		if (count($fb['me']) == 0 OR !$fb['me'] OR $fb['uid'] == 0)
		{
			redirect(base_url());
		} else {
			$data['fb_data'] = $this->fb_data;
			# Menüler
			$data['menu'] = $this->menuler;
			# İstatistikler
			$data['stats'] = $this->user_stats;
			# Ziyaretçi Defteri
			$data['last5guestbookentry'] = $this->gb_last_entry;
			# namaz vakitleri
			$data['namaz'] = $this->prayer;
			# Hava Durumu
			$data['havadurumu'] = $this->hava;
			# Üye Bilgileri
			$data['user'] = $this->users_model->getUserInfo($fb['uid']);
			
			
			$data['meta']['title'] = 'Kullanıcı Paneli';
			$data['meta']['description'] = 'Kullanıcı bilgilerinin görüntülendiği ve düzenlendiği alandır.';
			$data['meta']['keywords'] = 'kullanıcı, paneli, düzenleme';
			
			#Sayfayi bas
			$this->load->view(theme('header'),$data);
			$this->load->view(theme('users_dashboard'));
			$this->load->view(theme('sidebar'));
			$this->load->view(theme('footer'));
		}
	}
	
	public function update($uid)
	{
		$fb = $this->fb_data;
		
		if (count($fb['me']) == 0 OR !$fb['me'] OR $fb['uid'] == 0)
		{
			echo 'Facebook ile giriş yapılmamış!';
		} elseif ($fb['uid'] != $uid) {
			echo 'Bu sayfaya dışarıdan erişemezsiniz!';
		} else {
			echo $this->users_model->updateUser($fb['me']);
		}
	}
	
	public function delete($uid)
	{
		$fb = $this->fb_data;
		
		if (count($fb['me']) == 0 OR !$fb['me'] OR $fb['uid'] == 0)
		{
			echo 'Facebook ile giriş yapılmamış!';
		} elseif ($fb['uid'] != $uid) {
			echo 'Bu sayfaya dışarıdan erişemezsiniz!';
		} else {
			echo $this->users_model->unvisibleUser($fb['me']);
		}
	}
}