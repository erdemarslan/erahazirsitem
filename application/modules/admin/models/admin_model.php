<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Admin_model Extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function admin_menu()
	{
		return array(
			'Anasayfa'	=> 'admin/home',
			'Ayarlar'	=> 'admin/settings',
			'Menüler'	=> 'admin/menu',
			'Sayfalar'	=> 'admin/pages',
			'Haberler'	=> 'admin/news',
			'Ziyaretçi Defteri'	=> 'admin/guestbook',
			'Fotoğraf Galerisi' => 'admin/gallery',
			'Videolar'			=> 'admin/video',
			'Üyeler'			=> 'admin/users',
			'İstatistikler'		=> 'admin/users/stats',
			'Taranma İstatistikleri' => 'admin/users/crawlers',
			'Karaliste'		=> 'admin/users/blacklist',
			'Çıkış Yap'	=> 'admin/logout',
		);
	}
	
	public function getUpdate()
	{
		return array('version' => 'v.2', 'status' => 'success', 'info' => 'Son sürümü kullanıyorsunuz.');
	}
	
	public function getMenus()
	{
		return $this->db->order_by('align','asc')->get('menus')->result();
	}
	
	public function getSiteInfo()
	{
		$r = array();
		
		// Veritabanı boyutu
		$r['db_size'] = $this->db->query('SELECT SUM(ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024),4)) "MB"
FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "' . $this->db->database . '";')->row_array();
		
		// Kullanılan disk boyutu
		$dir = new RecursiveDirectoryIterator(HOMEPATH);
		$totalSize = 0;
		foreach (new RecursiveIteratorIterator($dir) as $file) {
			$totalSize += $file->getSize();
		}
		$r['used_disk_size'] = round(($totalSize / 1024 / 1024),3);
		$r['num_albums'] = $this->db->get('galleries')->num_rows();
		$r['num_photos'] = $this->db->get('gallery_photos')->num_rows();
		$r['num_p_gb'] = $this->db->get_where('guestbook',array('active'=>0))->num_rows();
		$r['num_gb'] = $this->db->get('guestbook')->num_rows();
		$r['num_pages'] = $this->db->get('pages')->num_rows();
		$r['num_categories'] = $this->db->get('news_category')->num_rows();
		$r['num_p_news'] = $this->db->get_where('news',array('active'=>0))->num_rows();
		$r['num_news'] = $this->db->get('news')->num_rows();
		$r['num_users'] = $this->db->get('users')->num_rows();
		$r['num_video'] = $this->db->get('videos')->num_rows();
		
		
		return $r;
	}
}