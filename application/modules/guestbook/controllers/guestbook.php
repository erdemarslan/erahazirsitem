<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Guestbook Extends MX_Controller
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
		$this->load->model('guestbook_model');
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
	
	public function read($p='1-page.html')
	{
		# gelen veriyi limit için tekrar düzenleyelim
		$p = explode('-',$p);
		$p = $p[0];
		# gelen veride hata varsa düzenle!
		if (!is_numeric($p) OR $p < 1) $p = 1;
		#verileri çek
		$entrys = $this->guestbook_model->getEntrys($p);
		if (count($entrys) == 0)
		{
			$data['guestbook'] = 'Veri bulunamadi!';
		} else {
			$data['guestbook'] = $entrys['entrys'];
			$data['page_list'] = $this->guestbook_model->getLinks($entrys['total']);
		}
		
		# Sidebar için verileri çekelim
		# Facebook için session değerini al ve tanımla
		//die(print_r($this->fb_data));
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
		$data['meta']['title'] = 'Ziyaretçi Defterini Oku - Sayfa : ' . $p;
		$data['meta']['description'] = 'Ziyaretçilerimizin yazdığı görüşlerini bulunduran sayfamızdır.';
		$data['meta']['keywords'] = 'ziyaretçi, defteri, guestbook, oku, read';
		
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('guestbook_read'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function write()
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
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Ziyaretçi Defterine Yaz';
		$data['meta']['description'] = 'Ziyaretçilerimizin görüşlerini yazabileceği sayfadır.';
		$data['meta']['keywords'] = 'ziyaretçi, defteri, guestbook, yaz, write';
				
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('guestbook_write'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function save()
	{
		//die(print_r($this->input->post()));
		//die(print_r($this->session->all_userdata()));
		$form = $this->input->post();
		$this->load->helper('email');		
		if ($form['captcha'] == '')
		{
			echo 'HATA: Güvenlik kodunu boş bırakamazsınız!';
		}
		elseif ($form['captcha'] != $this->session->userdata($this->config->item('captcha_session_name')) )
		{
			echo 'HATA: Güvenlik kodunuz resim ile uyuşmuyor!';
		}
		elseif ($form['isim'] == '')
		{
			echo 'HATA: İsim alanı boş bırakılamaz!';
		}
		elseif ($form['email'] == '')
		{
			echo 'HATA: Email alanı boş bırakılamaz!';
		}
		elseif (!valid_email($form['email']))
		{
			echo 'HATA: Email geçersiz gözüküyor!';
		}
		elseif ($form['mesaj'] == '')
		{
			echo 'HATA: Mesaj alanı boş bırakılamaz!';
		}
		else
		{
			# kayıda başlamadan önce son kontroller ve güncellemeleler
			if ($form['face_id'] != 'empty')
			{
				$foto = 'https://graph.facebook.com/' . $form['face_id'] . '/picture';
				$aktif = 1;
				$isim = trim($form['isim']);
				$tarih = time();
				
				
			} else {
				$foto = 'empty';
				$aktif = 0;
				$isim = big_one(trim($form['isim']));
				$tarih = time();
			}
			
			$email = $form['email'];
			
			if (isURL($form['website']))
			{
				$web = $form['website'];
			} else {
				$web = 'empty';
			}
			
			$mesaj = editTinyMceChars($form['mesaj']);
			$this->load->library('user_agent');
			$stat = $this->user_stats;
			//$ip = explode('.',$stat['user']['ip']);
			//$ip = $ip[0] . '.' . $ip[1] . '.' . $ip[2] . '.xxx';
			$ip = $stat['user']['ip'];
			$u_agent = $this->agent->platform() . ' | ' . $this->agent->browser() . ' ' . $this->agent->version() . ' | ' . $ip . ' | ' . $stat['user']['country'] . ' <img src="' . $stat['user']['flag'] . '" border="none" />';
			
			if ($this->guestbook_model->saveEntry($isim,$tarih,$web,$email,$foto,$mesaj,$u_agent,$aktif) > 0)
			{
				echo 'ok';
			} else {
				echo 'HATA: İletinizi kaydederken, bir hata meydana geldi. Lütfen tekrar deneyiniz.';
			}
		}
	}
	
	public function index()
	{
		$this->read();
	}
	
	public function aktarsasdasdasdasgasgbhsdfashfgsdas($adasdas)
	{
		$sorgu = $this->db->get('abx');
		$eski = $sorgu->result_array();
		$ems = array();
		foreach ($eski as $e)
		{
			$saat = explode(' ',$e['saat']);
			$date = strtotime($e['tarih'] . ' ' . $saat[1]);
			//echo $t . ' - ' . date('d.m.Y H:i:s',$t) . '<br />';
			$name = big_one($e['yazan']);
			//echo $name . '<br>';
			$web = 'empty';
			$this->load->helper('email');
			if (valid_email($e['email']))
			{
				$email = $e['email'];
			} else {
				$email = 'muhtarlik@derenti.com';
			}
			
			//echo $email . '<br>';
			
			$photo = 'empty';
			
			$search = array('<img src="resimler/gu/01.gif">','<img src="resimler/gu/02.gif">','<img src="resimler/gu/03.gif">','<img src="resimler/gu/04.gif">','<img src="resimler/gu/05.gif">','<img src="resimler/gu/06.gif">','<img src="resimler/gu/07.gif">','<img src="resimler/gu/08.gif">');
			$replace = array('','','','','','','','');
			
			$message = big_one(str_replace($search,$replace,$e['mesaj']),true,'.');
			
			$user_agent = 'Bilinmeyen İşletim Sistemi | Bilinmeyen Tarayıcı | 10.0.0.1 | Türkiye <img src="http://whatsmyip.erdemarslan.com/images/tr.gif" border="none" />';
						
			$array = array(
				'name'	=> $name,
				'date'	=> $date,
				'webpage'=> $web,
				'email' => $email,
				'photo'	=> $photo,
				'message' => $message,
				'user_agent' => $user_agent,
				'active' => 1
			);
			
			$this->db->insert('guestbook',$array);
			
			$ems[$email] = $email;
			
			echo 'ok <br />';
		}
		
		foreach ($ems as $em)
		{
			$this->db->insert('newsletter',array('emails'=> $em));
		}
	}
}