<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Pages Extends MX_Controller {
	
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
		$this->load->model('pages_model');
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

	# Anasayfa Fonksyonu
	public function home()
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
		
		# haberler ile ilgili kısım
		# önce duyuruları çekelim!
		$this->load->model('news/news_model');
		$data['notices'] = $this->news_model->getNews(true,0,5);
		$data['news']	= $this->news_model->getNews(false,0,14);
		
		# fotoğraf galerilerini çekelim :)
		$this->load->model('gallery/gallery_model');
		$data['galleries'] = $this->gallery_model->getAlbums();
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Anasayfa';
		$data['meta']['description'] = 'www.derenti.com - Derenti Köyü Websitesinin anasayfasıdır.';
		$data['meta']['keywords'] = 'anasayfa, home, derenti, derenti köyü';
		
		#Sayfayı bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('pages_home'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	
	# İletişim Bölümü
	public function contact()
	{
		//echo 'burası iletişim';
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
		$data['meta']['title'] = 'İletişim';
		$data['meta']['description'] = 'Derenti Köyü Websitesinin iletişim sayfasıdır.';
		$data['meta']['keywords'] = 'iletisim, iletişim, contact, derenti köyü';
		
		#Sayfayı bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('pages_contact'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function contact_save()
	{
		$form = $this->input->post();
		//print_r($form);
		
		if (!isset($form['isim']) OR $form['isim'] == '')
		{
			//redirect(base_url());
			echo 'HATA: İsminizi yazmamışsınız!';
		}
		elseif (!isset($form['email']) OR $form['email'] == '')
		{
			echo 'HATA: Email adresiniz boş!';
		}
		elseif (!isset($form['konu']) OR $form['konu'] == '0')
		{
			echo 'HATA: İletişim nedeni seçilmemiş!';
		}
		elseif (!isset($form['captcha']) OR $form['captcha'] == '')
		{
			echo 'HATA: Güvenlik kodunuz boş!';
		}
		elseif (!isset($form['mesaj']) OR $form['mesaj'] == '')
		{
			echo 'HATA: Mesajınızı yazmamışsınız!';
		}
		else {
			//die('buraya kadar ok!');
			$this->load->helper('email');
			
			if (!valid_email($form['email']))
			{
				echo 'HATA: Email adresiniz geçersiz!';
			}
			elseif ($form['captcha'] != $this->session->userdata($this->config->item('captcha_session_name')) )
			{
				echo 'HATA: Güvenlik kodunuz resim ile uyuşmuyor!';
			}
			else 
			{
				$mesaj = '';
				$mesaj .= '<strong>Gönderen:</strong> ' . $form['isim'] . '<br />';
				$mesaj .= '<strong>Email:</strong> ' . $form['email'] . '<br />';
				$mesaj .= '<strong>Konu:</strong> ' . $form['konu'] . '<br />';
				$mesaj .= '<strong>Mesaj:</strong> ' . $form['mesaj'] . '<br />';
				
				
				$this->load->library('email');
				$ayarlar = $this->config->item('gmail');
				$ayarlar['smtp_user'] = $this->config->item('gmail_smtp_user');
				$ayarlar['smtp_pass'] = $this->config->item('gmail_smtp_pass');
				$this->email->initialize($ayarlar);
				$this->email->from($form['email'], $form['isim']);
				$this->email->reply_to($form['email'], $form['isim']);
				$this->email->to($this->config->item('site_contact_mail')); 
				$this->email->subject('İletişim Nedeni: ' . $form['konu']);
				$this->email->message($mesaj);  
				if ( $this->email->send() )
				{
					echo 'ok';
				} else {
					echo 'Mail gönderilirken, bir hata meydana geldi!';
				}
				//echo $this->email->print_debugger();
			}
		}
	}
	
	# Veritabanından çekilen sayfaların görüntüleneceği fonksiyon
	public function page($id=0,$t='index.html')
	{
		# id değerini kontrol et !
		if ($id == 0 OR !is_numeric($id)) { redirect('home'); }
		
		#sayfa değişkenlerini çek!
		$page = $this->pages_model->getPage($id,base_url($this->uri->uri_string()));
		
		
		if ($page['status'] == 'error')
		{
			echo modules::run('error/not_found',$page['hata']);
		} else {
			# gelen değişkeni döndür ve verileri tema için hazırla
			foreach ($page as $key => $value)
			{
				$data[$key] = $value;
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
			
			# SEO Çalışmaları
			$data['meta']['title'] = $data['baslik'];
			$data['meta']['description'] = prep_meta_desc($data['icerik']);
			$data['meta']['keywords'] = prep_meta_keyword($data['icerik']);
						
			# Temayı yükle ve ekrana bas
			$this->load->view(theme('header'),$data);
			$this->load->view(theme('pages_page'));
			$this->load->view(theme('sidebar'));
			$this->load->view(theme('footer'));
		}
		
	}
	
	
	# site haritası oluşturulup, yayınlanacak!
	public function sitemap()
	{
		$data = $this->pages_model->getSitemapData();
			
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		foreach ($data as $d)
		{
			echo '	<url>';
			echo '		<loc>' . $d['loc'] . '</loc>';
			echo '		<changefreq>' . $d['changefreq'] . '</changefreq>';
			echo '		<priority>' . $d['priority'] . '</priority>';
			echo '	</url>';
		}
		
		echo '</urlset>';
	}
	
	
	# Bu fonksiyon anasayfayı belirler
	public function index()
	{
		self::home();
	}

}