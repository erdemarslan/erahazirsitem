<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Video Extends MX_Controller
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
		# Tarayıcıyı kontrol et!
		$this->system_model->check_browser();
		# İstatistikleri tut
		$this->user_stats = $this->system_model->getStats();
		# Facebook Modelini yükle
		$this->load->model('facebook_model');
		$this->fb_data = $this->session->userdata('fb_data');
		# Sayfanın kendi modelini yükle
		$this->load->model('video_model');
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
		$this->page();
	}
	
	public function page($p=1)
	{
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
		
		is_numeric($p) ? $p = $p : $p = 1;
		
		
		$videos = $this->video_model->getVideos($p);
		if ($videos['total'] > 0)
		{
			$data['videos'] = $videos['videos'];
			$data['lists'] = $this->video_model->getLinks($videos['total']);
		}
		
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Video Galerisi';
		$data['meta']['description'] = 'Derenti Köyüne ait videolar buradadır.';
		$data['meta']['keywords'] = 'albüm, galeri, video, vidyo, görüntü';
		
				
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('video_page'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function watch($id=0,$t='index.html')
	{
		if ($id == 0 OR !is_numeric($id))
		{
			redirect(base_url());
		}
		
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
				
		$video = $this->video_model->getVideo($id);
		
		if (count($video) < 1)
		{
			redirect(base_url('video/page/1'));
		}
		
		$data['video'] = $video;
		
		# SEO Çalışmaları
		$data['meta']['title'] = $video['video_title'];
		$data['meta']['description'] = $video['video_desc'];
		$data['meta']['keywords'] = 'video, izle, önizleme, slayt, film, filim';
		
		
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('video_watch'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	
}