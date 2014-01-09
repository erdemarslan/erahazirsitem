<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Admin Extends MX_Controller
{
	private $gal;
	
	public function __construct()
	{
		parent::__construct();
		# Veritabanından ayarları al
		$this->system_model->getSettings();
		# Kendi modelini yükle
		$this->load->model('gallery_admin_model');
		# Ana admin modelini yükle
		$this->load->model('admin/admin_model');
		# Giriş yoksa postala
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		define('APP_ID', $this->config->item('gallery_facebook_appid'));
		define('SECRET_ID', $this->config->item('gallery_facebook_secret'));
		
		// *** The page to redirect to after a login
		define('REDIRECT_URL', base_url('admin/gallery/auth_user'));
		//   * need to set this constant manuallly
		define('REDIRECT_URL_AUTH', base_url('admin/gallery/auth_user')); 	
		
		define('AUTH_USER', 'primary');
	
		//define('PUBLIC_USER', '40796308305'); # depricated
		define('PAGE_ID', '40796308305');		# this is the id of Coke. It's good for testing. We could also use their name 'Coca-Cola'.
		define('USE_PAGE_ID', false);
	
		define('TRACE', true);
		define('CACHE_ENABLED', true);
		define('MEMORY_CACHE_ENABLED', true);
		define('CACHE_DELETABLE', true);
		define('CACHE_FOLDER', 'application/libraries/facebook_cached_data');
		define('CACHE_MINUTES', 300); # 300 = 5hours
		define('DATE_FORMAT', 'd F y \a\t g:i a');
		
		define('REPLY_AS_PAGE', false); # when posting to a "page", you can post as your user or post (impersonate) as the page.
		define('USE_CUSTOM_DATA_STORE', false); # define your own saving/reading token code (eg. want to use your DB)
		define('MULTI_USER', false); # set multi user mode
	
		define('USE_PREDEFINED', false);
		define('PREDEFINED_SIZE', 'medium'); # one of 'large', 'medium', 'small', or 'tiny'.
		
		require_once('./application/libraries/FacebookAlbum.php');
		$this->gal = new FacebookAlbum(APP_ID, SECRET_ID, REDIRECT_URL, AUTH_USER, PAGE_ID);
	}
	
	public function index()
	{
		//echo 'gallery admin';
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['albums'] = $this->gal->getAlbumInfo();
		$data['db_albums'] = $this->gallery_admin_model->getAlbums();
				
		$this->load->view('admin/gallery_index',$data);	
	}
	
	public function auth_user()
	{
		if ($this->gal->isLoggedIn()) {

		if ($this->gal->saveAccessToken()) {
			$this->gal->logout();
			
			if (@count($_GET) == 0) {
				
				js_alert('Facebooktan çıkış yapmamış gözüküyorsunuz! Ayrıca site üzerindeki yetkilendirmeyi de kaldırınız!');
				js_timeout(base_url('admin/gallery'),300);
				//echo 'I don\'t think you were logged out of Facebook? Log out and please try again.';
				
								
			} else {
				js_alert('Facebook üzerinde başarıyla eşleştirildiniz. Yönlendiriliyorsunuz!');
				js_timeout(base_url('admin/gallery'),300);
				//echo "User Authenticated.";
			}
		}
		
		
		} else {
			
			$this->gal->loginRedirect();
		}
	}
	
	
	public function add($id=0)
	{
		if ($id == 0)
		{
			js_alert('Hata! Buraya öylece erişemezsiniz!');
			js_timeout(base_url('admin/gallery'),300);
		} else {
			
			$data['menuler'] = $this->admin_model->admin_menu();
        	$data['update'] = $this->admin_model->getUpdate();
			$data['album'] = $this->gal->getAlbumInfo($id);
			$data['album']['id'] = $id;
			$data['album_cover'] = $this->gal->getAlbumCover($id);
			$data['images'] = $this->gal->getAlbum($id);
			
			$saved = $this->gallery_admin_model->isGallerySaved($id);
			$data['album_saved'] = $saved['status'];
			$data['album_images'] = $saved['data'];
				
			$this->load->view('admin/gallery_add',$data);
		}
	}
	
	public function save()
	{
		//print_r($this->input->post());
		//die();
		
		
		$file = UPLOADPATH . 'gallery/' . $this->input->post('a_id') . '_cover.jpg';
		copy($this->input->post('a_cover'), $file);
		
		
		$this->load->library('image_lib');
		$resize['image_library'] = 'gd2';
		$resize['source_image'] = $file;
		$resize['new_image'] = $file;
		$resize['maintain_ratio'] = false;
		$resize['width'] = 200;
		$resize['height'] = 150;
		$resize['quality'] = 100;
		$this->image_lib->initialize($resize);
		$this->image_lib->resize();
		$this->image_lib->clear();
		
		$array = array(
			'album_id' => $this->input->post('a_id'),
			'album_name' => $this->input->post('a_name'),
			'album_date' => strtotime($this->input->post('a_date')),
			'album_desc' => $this->input->post('a_desc'),
			'album_cover'=> $file
		);
		
		$this->db->insert('galleries',$array);
		if ($this->db->insert_id() > 0)
		{
			echo 'ok';
		} else {
			echo 'Kayıt işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyiniz!';
		}
		
	}
	
	public function save_photo()
	{
		//print_r($this->input->post());
		$file = UPLOADPATH . 'gallery/' . $this->input->post('album_id') . '_' . $this->input->post('photo_id') . '.jpg';
		copy($this->input->post('photo_url'),$file);
		
		$this->load->library('image_lib');
		$resize['image_library'] = 'gd2';
		$resize['source_image'] = $file;
		$resize['new_image'] = $file;
		$resize['maintain_ratio'] = false;
		$resize['width'] = 200;
		$resize['height'] = 150;
		$resize['quality'] = 100;
		$this->image_lib->initialize($resize);
		$this->image_lib->resize();
		$this->image_lib->clear();
		
		$array = array(
			'album_id'	=> $this->input->post('album_id'),
			'photo_id'	=> $this->input->post('photo_id'),
			'photo_url' => $this->input->post('photo_url'),
			'photo_thumb' => $file
		);
		
		$this->db->insert('gallery_photos',$array);
		if ($this->db->insert_id() > 0)
		{
			echo 'ok';
		} else {
			echo 'Kayıt işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyiniz!';
		}
	}
	
	public function delete_photo()
	{
		//print_r($this->input->post());
		$this->db->delete('gallery_photos',array('album_id'=>$this->input->post('album_id'),'photo_id'=>$this->input->post('photo_id')));
		unlink(UPLOADPATH . 'gallery/' . $this->input->post('album_id') . '_' . $this->input->post('photo_id') . '.jpg');
		echo 'ok';
	}
	
	
	public function delete($id=0)
	{
		if ($id == 0)
		{
			js_alert('Hata! Buraya öylece erişemezsiniz!');
		} else {
			$this->gallery_admin_model->deleteAlbumFromDB($id);
			js_alert('Belirtilen albüme ait herşey veritabanından silindi. İsterseniz tekrar ekleyebilirsiniz!');
			//unlink(UPLOADPATH . 'gallery/' . $this->input->post('album_id') . '_cover.jpg');
		}
		js_timeout(base_url('admin/gallery'),300);
	}
	
	
	public function clear_cache()
	{
		$yol = APPPATH . 'libraries/facebook_cached_data';
		$this->deleteContents($yol);
		js_alert('Önbellek temizlendi. Galeriye döndüğünüzde, veriler Facebook üzerinden tekrar çekilecektir.');
		js_timeout(base_url('admin/gallery'),300);
	}
	
	public function clear_all()
	{
		$yol = APPPATH . 'libraries/facebook_cached_data';
		$this->deleteContents($yol);
		$yol2 = APPPATH . 'libraries/signatures';
		$this->deleteContents($yol2);
		
		// *** Remove the cookie
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
		js_alert('Facebook ile ilgili ilişkilendirme kaldırıldı. Galeriye geri döndüğünüzde, yeniden yetkilendirme yapınız!...');
		js_timeout(base_url('admin/gallery'),300);
	}
	
	############### Reset.php deki fonksiyon
	private function deleteContents($path)
	{
		$files = glob($path . '/*.txt');
		if (count($files) > 0)
		{
			foreach ($files as $f)
			{
				@unlink($f);
			}
		}
	}
	################################################################
	
	
}