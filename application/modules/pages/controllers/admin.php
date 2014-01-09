<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Admin Extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		# Veritabanından ayarları al
		$this->system_model->getSettings();
		# Kendi modelini yükle
		$this->load->model('pages_admin_model');
		# Ana admin modelini yükle
		$this->load->model('admin/admin_model');
		# Giriş yoksa postala
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
	}
	
	public function index()
	{
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['pages'] = $this->pages_admin_model->getPage();
		$this->load->view(admin('pages_index'),$data);
	}
	
	public function edit($id)
	{
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['page'] = $this->pages_admin_model->getPage(false,$id);
		$this->load->view(admin('pages_edit'),$data);
	}
	
	public function new_page()
	{
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('pages_new'),$data);
	}
	
	public function delete($id)
	{
		if (is_numeric($id))
		{
			$sorgu = $this->db->get_where('pages',array('id'=>$id));
			$sonuc = $sorgu->row_array();
			
			
			
			$this->db->delete('pages',array('id'=>$id));
			$this->db->delete('menus',array('name'=>$sonuc['page_title']));
			js_alert('Sayfa başarıyla silindi! Yönlendiriliyorsunuz!');
		}
		js_timeout(base_url('admin/pages'),500);
	}
	
	public function save($id=0)
	{
		if ($id == 0)
		{
			$veri = $this->input->post();
			//print_r($veri);
			if ($veri['title'] == '' OR $veri['content'] == '' OR is_numeric($veri['hit']) === FALSE)
			{
				js_alert('Formu boş gönderemezsiniz. Lütfen tüm alanları doldurunuz! Yönlendiriliyorsunuz!');
				js_timeout(base_url('admin/pages/new_page'),500);
			} else {
				$array = array(
					'page_title' => $veri['title'],
					'page_content'	=> editTinyMceChars($veri['content']),
					'page_hit'	=> $veri['hit']
				);
				$this->db->insert('pages',$array);
				$i_id = $this->db->insert_id();
				$menu = array(
					'name'	=> $veri['title'],
					'url'	=> 'page/' . $i_id . '/' . no_tr($veri['title']) . '.html',
					'target'	=> '_self',
					'align'	=> 99
				);
				$this->db->insert('menus',$menu);
				js_alert('Kayıt başarıyla yapıldı. Yönlendiriliyorsunuz!');
				js_timeout(base_url('admin/pages'),500);
			}
		} else {
			
			$data = $this->input->post();
			if (!is_numeric($id) OR $id != $data['page_id'])
			{
				js_alert('Bu sayfaya gönderilen bilgilerde tutarsızlık var. Kayıt işlemi devam etmeyecek. Yönlendiriliyorsunuz!');
				js_timeout(base_url('admin/pages'),500);
			} else {
				$this->db->where('id',$id);
				$this->db->from('pages');
				$sayi = $this->db->count_all_results();
				if ($sayi != 1)
				{
					js_alert('Düzenlenecek kayıt bulunamadı. Kayıt işlemi devam etmeyecek. Yönlendiriliyorsunuz!');
					js_timeout(base_url('admin/pages'),500);
				} else {
					
					# verileri düzenle!					
					$veri = array(
						'page_title' => $data['title'],
						'page_content'	=> editTinyMceChars($data['content']),
						'page_hit'	=> $data['hit']
					);
					$this->db->where('id',$id);
					$this->db->update('pages',$veri);
					
					$men = array(
						'name'	=> $data['title'],
						'url'	=> 'page/' . $id . '/' . no_tr($data['title']) . '.html',
					);
					
					$this->db->where('name',$data['page_title']);
					$this->db->update('menus',$men);
					
					js_alert('Kayıt başarıyla yapıldı. Yönlendiriliyorsunuz!');
					js_timeout(base_url('admin/pages'),500);
				}
			}
		}
	}
	
	
	
	
}