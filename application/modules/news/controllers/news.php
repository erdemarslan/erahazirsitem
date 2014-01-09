<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class News Extends MX_Controller
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
		# İstatistikleri tut
	    $this->user_stats = $this->system_model->getStats();
		# Facebook Modelini yükle
		$this->load->model('facebook_model');
		$this->fb_data = $this->session->userdata('fb_data');
		# Sayfanın kendi modelini yükle
		$this->load->model('news_model');
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
	
	public function category($s=0,$id=0)
	{
		/*
		
		*/
		if (!is_numeric($s))
		{
			$s = 0;
		}
		
		$str = $id;
		
		if  (strstr($id,'-')) {
			$p1 = explode('-',$id);
			$p2 = $p1[0];
			is_numeric($p2) ? $id =  $p2 : $id = 0;
		} else {
			is_numeric($id) ? $id = $id : $id = 0;
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
		
		#category verilerini tanımla
		$cat_items = $this->news_model->getCategoryItems($id,$s);
		if (count($cat_items) == 0)
		{
			$data['news'] = array();
		} else {
			$data['news'] = $cat_items['news'];
			$data['page_list'] = $this->news_model->getLinks($cat_items['total'],$str);
		}		
		
		$data['categories'] = $this->news_model->getCategories();
		
		//die(print_r($data['categories']));
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Haber Kategorileri';
		$data['meta']['description'] = 'Haber kategorilerini barındırır.';
		$data['meta']['keywords'] = 'haber, haberler, haber kategorileri, kategoriler';
		
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('news_category'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
		
	}
	
	public function read($c='0-Hepsi',$ids=0)
	{
		// Önce URL'den gelen bilgilere bi bakalım :)
		if (strstr($ids,'-'))
		{
			$id = explode('-',$ids);
			$id = $id[0];
			if (!is_numeric($id) OR $id == 0)
			{
				redirect(base_url());
			}
		} else {
			if (!is_numeric($ids) OR $ids == 0)
			{
				redirect(base_url());
			} else {
				$id = $ids;
			}
		}
		
		$news_self = $this->news_model->getNewsItem($id);
		if (count($news_self) == 0)
		{
			echo modules::run('error/not_found','Öğe veritabanında bulunamadı!');
		} else {
			
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
			
			# İçerik :)
			$data['post'] = $news_self['post'];
			$data['related'] = $news_self['related'];
			
			# SEO Çalışmaları
			$data['meta']['title'] = $news_self['post']['title'];
			$data['meta']['description'] = prep_meta_desc($news_self['post']['news_intro']);
			$data['meta']['keywords'] = prep_meta_keyword($news_self['post']['news_intro']) . 'haberler, haber';
			
			#Sayfayi bas
			$this->load->view(theme('header'),$data);
			$this->load->view(theme('news_read'));
			$this->load->view(theme('sidebar'));
			$this->load->view(theme('footer'));
		}
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
		
		# kategorileri çek
		$data['categories'] = $this->news_model->getCategories();
		
		# SEO Çalışmaları
		$data['meta']['title'] = 'Haber Yaz';
		$data['meta']['description'] = 'Kullanıcılar kendi haberlerini bu sayfadan yazabilirler.';
		$data['meta']['keywords'] = 'haberler, haber, yaz, news, write';
		
		#Sayfayi bas
		$this->load->view(theme('header'),$data);
		$this->load->view(theme('news_write'));
		$this->load->view(theme('sidebar'));
		$this->load->view(theme('footer'));
	}
	
	public function save_form()
    {
		
		//die('die');
		$form = $this->input->post();
		$form['file'] = $_FILES['file'];
		//die(print_r($form));
		
		$uploaded_file = '';
		# facebook ile giriş var mı yok mu? varsa devam! yoksa hata!
		if ($form['face_id'] == 0 OR $form['face_id'] == '' OR !isset($form['face_id']) OR $this->fb_data['uid'] != $form['face_id'])
		{
			js_alert('Facebook ile giriş değerlerinizi bulamadık!');
			js_timeout(base_url('news/write'),300);
		} else {
			# formun geri kalan önemlileri boş mu değil mi?
			if ($form['captcha'] != $this->session->userdata('era_captcha'))
			{
				js_alert('Güvenlik kodunuz resim ile uyuşmuyor! Lütfen düzeltiniz!');
				js_timeout(base_url('news/write'),300);	
			}
			elseif ($form['baslik'] == '' OR $form['mesaj'] == '' OR $form['kategori'] == 0 OR $form['kategori'] == '')
			{
				js_alert('Formu tam olarak doldurmamışsınız! Lütfen düzeltiniz!');
				js_timeout(base_url('news/write'),300);	
			} else {
				# File boş mu değil mi? boşsa default değeri vereceğiz!
				
				if (!isset($form['file']) OR $form['file']['name'] == '')
				{
					$uploaded_file = 'news_image_' . $form['kategori'] . '.jpg';
				} else {
					
					
					
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = 'news_' . $form['file']['name'];
					$config['max_size']	= '0';
					$config['max_width']  = '2560';
					$config['max_height']  = '1920';
					# Resim yüklemeyi aktifleştir!
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('file'))
					{
						js_alert($this->upload->display_errors('- ',' -'));
						js_alert('Resim yüklenemediğinden varsayılan resim seçildi!');
						$uploaded_file = 'news_image_' . $form['kategori'] . '.jpg';
					}
					else
					{
						//js_alert('resim yüklendi!');
						$file_data = $this->upload->data();
						
						if ($file_data['image_width'] > 600 AND $file_data['image_height'] > 300)
						{
							$crop['image_library'] = 'gd2';
							$crop['source_image'] = $file_data['full_path'];
							$crop['new_image'] = $file_data['full_path'];
							$crop['maintain_ratio'] = false;
							
							$a = $file_data['image_width']%600;
							$b = $file_data['image_height']%300;
							
							$crop['width'] = $file_data['image_width']-$a;
							$crop['height'] = $file_data['image_height']-$b;
							$crop['quality'] = 100;
							$crop['x_axis'] = (int)($a/2);
							$crop['y_axis'] = (int)($b/2);
							
							$this->load->library('image_lib');
							$this->image_lib->initialize($crop);
							$this->image_lib->crop();
							$this->image_lib->clear();
							// kesildi şimdi küçült
							
							$resize['image_library'] = 'gd2';
							$resize['source_image'] = $file_data['full_path'];
							$resize['new_image'] = $file_data['full_path'];
							$resize['maintain_ratio'] = false;
							$resize['width'] = 600;
							$resize['height'] = 300;
							$resize['quality'] = 100;
							$this->image_lib->initialize($resize);
							$this->image_lib->resize();
							$this->image_lib->clear();
							//js_alert('resim küçültüldü');
						}
						
						$uploaded_file = $file_data['file_name'];
					}
				}	
					$ara = stripos($form['mesaj'],'<!-- pagebreak -->');
					if ($ara === false)
					{
						$haber = explode('</p>',$form['mesaj']);
					} else {
						$haber = explode('<!-- pagebreak -->',$form['mesaj']);	
					}
					
					
					
					$veriler = array(
						'category'					=> $form['kategori'],
						'title'						=> $form['baslik'],
						'date'						=> time(),
						'picture'					=> $uploaded_file,
						'news_intro'				=> editTinyMceChars(str_replace(array('<p>','</p>'),array('','<br /><br />'),$haber[0])),
						'news_content' 				=> editTinyMceChars(str_replace(array('<p>','</p>'),array('','<br /><br />'),$form['mesaj'])),
						'hit'						=> 1,
						'active'					=> 0,
						'news_writer'				=> $form['face_name'],
						'news_writer_facebookid'	=> $form['face_id'],
						'news_writer_email'			=> $form['face_email']
					);
					$this->news_model->save_user_news($veriler);
					# resim yüklendi veya seçildi. kayıt yap!
					js_alert('Haberiniz başarıyla gönderildi. Onaylandıktan sonra yayınlanacaktır. Teşekkürler');
					js_timeout(base_url(),300);
				
			}
		}
    }
	
	
	public function index($s=0,$id=0)
	{
		$this->category($s=0,$id=0);
	}
}