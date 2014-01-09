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
		$this->load->model('guestbook_admin_model');
		# Ana admin modelini yükle
		$this->load->model('admin/admin_model');
		# Giriş yoksa postala
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
	}
	
	
	public function index($limit=0)
	{
		if (!is_numeric($limit) OR $limit < 0) $limit = 0;
		
		$kayitlar = $this->guestbook_admin_model->getEntrys($limit);
		if (count($kayitlar) == 0)
		{
			$data['guestbook'] = 'Veri bulunamadi!';
		} else {
			$data['guestbook'] = $kayitlar['entrys'];
			$data['page_list'] = $this->guestbook_admin_model->getLinks($kayitlar['total']);
		}
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('guestbook_index'),$data);
	}
	
	public function delete($id)
	{
		if (is_numeric($id))
		{
			$this->db->delete('guestbook',array('id'=>$id));
			js_alert('İleti başarıyla silindi! Yönlendiriliyorsunuz!');
		}
		js_timeout(base_url('admin/guestbook'),500);
	}
	
	public function activate($id,$action)
	{
		if (is_numeric($id))
		{
			if ($action == 'a')
			{				
				$veri = array(
					'active' => 1
				);
				$this->db->where('id',$id);
				$this->db->update('guestbook',$veri);
				js_alert('İleti başarıyla aktifleştirildi! Yönlendiriliyorsunuz!');
			}
			
			if ($action == 'd')
			{
				$veri = array(
					'active' => 0
				);
				$this->db->where('id',$id);
				$this->db->update('guestbook',$veri);
				js_alert('İleti başarıyla deaktif hale getirildi! Yönlendiriliyorsunuz!');
			}
		}
		js_timeout(base_url('admin/guestbook'),500);
	}
	
	public function edit($id)
	{
		if(is_numeric($id))
		{
			$entry = $this->guestbook_admin_model->getEntry($id);
			if (count($entry) == 0)
			{
				redirect(base_url('admin/guestbook'));
			} else {
				$data['gb'] = $entry;
				$data['menuler'] = $this->admin_model->admin_menu();
        		$data['update'] = $this->admin_model->getUpdate();
				$this->load->view(admin('guestbook_edit'),$data);
			}
		} else {
			redirect(base_url('admin/guestbook'));
		}
	}
	
	public function save($id)
	{
		/*print_r($this->input->post());
		*/
		$form = $this->input->post();
		if ($id != $form['gb_id'])
		{
			redirect(base_url('admin/guestbook'));
		} else {
			if ($form['name'] == '')
			{
				$orjinal = $this->guestbook_admin_model->getEntry($id);
				$form['name'] = $orjinal['name'];
			}
			if (isset($form['edited']) AND $form['edited'] == 'ok')
			{
				$form['message'] = $form['message'] . '<p><strong>Bu ileti yönetim tarafından ' . date('d.m.Y H:i:s',time()) . ' tarihinde düzenlenmiştir.</strong></p>';
			}
			
			if ($form['webpage'] == '')
			{
				$form['webpage'] = 'empty';
			}
			
			if ($form['photo'] == '')
			{
				$form['photo'] = 'empty';
			}
			
			$data = array(
				'name'		=> $form['name'],
				'webpage'	=> $form['webpage'],
				'photo'		=> $form['photo'],
				'message'	=> editTinyMceChars($form['message']),
				'active'	=> $form['active']
			);
			
			$this->db->where('id',$id);
			$this->db->update('guestbook',$data);
			
			js_alert('İleti başarıyla düzenlendi! Yönlendiriliyorsunuz!');
			js_timeout(base_url('admin/guestbook'),500);
		}
		
	}
	
}