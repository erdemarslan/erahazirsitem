<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Gallery Extends MX_Controller
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
		$this->load->model('gallery_model');
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
		$this->albums();
	}
	
	public function albums()
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
		
		
		$data['albums'] = $this->gallery_model->getAlbums();
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Fotoğraf Albümleri';
		$data['meta']['description'] = 'Derenti Köyüne ait fotoğraf albümleri buradadır.';
		$data['meta']['keywords'] = 'albüm, galeri, fotoğraf, resim';
		
				
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('gallery_albums'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function album($id=0,$p=1,$title='index.html')
	{
		if ($id == 0)
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
		
		# gelen veride hata varsa düzenle!
		if (!is_numeric($p) OR $p < 1) $p = 1;
		#verileri çek
		$album_photos = $this->gallery_model->getAlbum($id,$p);
		
		if (count($album_photos['album']) == 0)
		{
			redirect(base_url('gallery'));
		}
		//die (print_r($album_photos));
		
		if ($album_photos['total'] == 0)
		{
			$data['album']	= $album_photos['album'];
			$data['numPhotos'] = $album_photos['total'];
			$data['photos'] = 'Bu albüme ait fotoğraflar daha eklenmemiş!';
		} else {
			$data['album']	= $album_photos['album'];
			$data['photos'] = $album_photos['photos'];
			$data['numPhotos'] = $album_photos['total'];
			$data['page_list'] = $this->gallery_model->getLinks($id,$album_photos['total'],$title);
		}
		
		# SEO Çalışmaları
		$data['meta']['title'] = $album_photos['album']['album_name'];
		$data['meta']['description'] = $album_photos['album']['album_name'] . ' adlı albümde yer alan fotoğraflar bulunmaktadır.';
		$data['meta']['keywords'] = prep_meta_keyword($album_photos['album']['album_name']) . ' era, era system';	
				
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('gallery_album'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function photo($id=0,$t='view.html')
	{
		if ($id == 0)
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
				
		$photo = $this->gallery_model->getPhoto($id);
		
		if (count($photo) > 0)
		{
			$data['photo']	= $photo['photo'];
			$data['prev']	= $photo['prev'];
			$data['next']	= $photo['next'];
		} else {
			redirect(base_url());
		}
		
		# SEO Çalışmaları
		$data['meta']['title'] = $photo['photo']['photoID'] . ' numaralı Fotoğrafın Önizlemesi';
		$data['meta']['description'] = $photo['photo']['photoID'] . ' numaralı Fotoğrafın Önizlemesidir';
		$data['meta']['keywords'] = 'fotoğraf, izle, önizleme, slayt';
		
		
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('gallery_photo'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
}