<?php
Class Error Extends MX_Controller
{
	# Sınıf içi değişkenler :)
	private $user_stats;
	private $fb_data;
	private $menuler;
	private $gb_last_entry;
	private $prayer;
	private $hava;
	
	# Yapılandırıcı fonksiyon
	public function __construct()
	{
		parent::__construct();
		# Veritabanından ayarları al
		$this->system_model->getSettings();
	}
	
	public function index()
	{
		self::not_found();
	}
	
	public function not_found($neden='Belirtilmemiş Hata!')
	{
		# Tarayıcıyı kontrol et!
		$this->system_model->check_browser();
		# İstatistikleri tut
		$this->user_stats = $this->system_model->getStats();
		# Facebook Modelini yükle
		$this->load->model('facebook_model');
		$this->fb_data = $this->session->userdata('fb_data');
		# Menüler
		$this->menuler = $this->system_model->getMenu();
		# Ziyaretçi Defteri için
		$this->load->model('guestbook/guestbook_model');
		$this->gb_last_entry = $this->guestbook_model->getLastEntry();
		# Namaz Vakitleri ve havadurumunun gösterilmesini kapatıyoruz
		$this->config->set_item('prayer_active',0);
		$this->config->set_item('weather_active',0);
		
		$this->session->set_userdata('last_page',$this->uri->uri_string());
		
		$this->load->library('user_agent');
		$adres = base_url($this->uri->uri_string());
		if ($adres == base_url('error/not_found'))
		{
			$data['url'] = $this->input->server('HTTP_REFERER');
		} else {
			$data['url'] = $adres;
		}
		
		$data['neden'] = $neden;
		
		# Sidebar için verileri çekelim
		# Facebook için session değerini al ve tanımla
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
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Sayfa Bulunamadı';
		$data['meta']['description'] = 'Böyle bir sayfa bulunamamıştır.';
		$data['meta']['keywords'] = 'page, 404, not, found, sayfa, bulunamadı';
		
		
		# Temayi yükle ve ekrana bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('error_notfound'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function browser()
	{
		$this->load->library('user_agent');
		$a = $this->agent->getBrowser();
		//print_r($a);
		//die();
		$data['version'] = $a['Version'];
		
		$this->load->view(theme('error_browser'),$data);
	}
	
	public function ip_ban()
	{
		$this->load->view(theme('error_ipban'));
	}
}