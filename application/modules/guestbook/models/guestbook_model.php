<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Guestbook_model Extends CI_Model
{
	public function getLastEntry($how=5)
	{
		is_numeric($how) ? $how = $how : $how = 5;
		$how < 1 ? $how = 5 : $how = $how;
		
		$this->db->select('name, date, email, photo, message, active');
		$this->db->where('active',1);
		$this->db->order_by('date','desc');
		$this->db->limit($how);
		$sorgu = $this->db->get('guestbook');
		return $sorgu->result_array();
	}
	
	public function getEntrys($start=0)
	{
		$this->db->where('active',1);
		$toplam = $this->db->count_all('guestbook');
		
		$sorgu = $this->db->query('select * from guestbook where active = 1 order by date desc limit ' . ($start-1)*10 . ',10');
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
		$config['base_url'] = base_url('guestbook/read/');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $total;
		$config['first_url'] = base_url('guestbook/read/1-page.html');
		
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
		
		$config['suffix'] = '-page.html';
		$config['use_page_numbers'] = TRUE;

		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function saveEntry($name,$date,$webpage,$email,$photo,$message,$user_agent,$active)
	{
		$array = array(
			'name'	=> $name,
			'date'	=> $date,
			'webpage'	=> $webpage,
			'email'		=> $email,
			'photo'		=> $photo,
			'message'	=> $message,
			'user_agent'=> $user_agent,
			'active'	=> $active
		);
		$this->db->insert('guestbook',$array);
		return $this->db->insert_id();
	}
}