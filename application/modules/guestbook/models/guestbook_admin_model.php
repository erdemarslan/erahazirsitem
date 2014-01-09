<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Guestbook_admin_model Extends CI_Model
{
	public function getEntrys($start=0)
	{
		$toplam = $this->db->count_all('guestbook');
		
		$sorgu = $this->db->query('select * from guestbook order by date desc limit ' . $start . ',20');
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = array(
				'entrys' => $sorgu->result_array(),
				'total'	 => $toplam
			);
		} else {
			$sonuc = array();
		}
		return $sonuc;
	}
	
	public function getLinks($total)
	{
		$config['base_url'] = base_url() .'admin/guestbook/index';
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $total;
				
		$config['full_tag_open'] = '<ul id="pagination-digg">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = 'İlk Sayfa';
		$config['first_tag_open'] = '<li class="previous">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Son Sayfa';
		$config['last_tag_open'] = '<li class="next">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Sonraki';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Önceki';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function getEntry($id)
	{
		$sorgu = $this->db->get_where('guestbook',array('id'=>$id));
		if ($sorgu->num_rows() > 0)
		{
			return $sorgu->row_array();
		} else {
			return array();
		}
	}
	
}