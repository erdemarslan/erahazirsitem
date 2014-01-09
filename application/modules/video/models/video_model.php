<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Video_model Extends CI_Model
{
	
	public function getVideos($p)
	{
		$toplam = $this->db->get('videos')->num_rows();
		
		$this->db->select('*');
		$this->db->from('videos');
		$this->db->order_by('id','desc');
		$this->db->limit(10,($p-1)*10);
		$sorgu = $this->db->get();
		
		return array(
			'videos' => $sorgu->result_array(),
			'total'	 => $toplam
		);
	}
	
	public function getLinks($total)
	{
		$config['base_url'] = base_url('video/page/');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $total;
		$config['first_url'] = base_url('video/page/1');
		
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
		
		//$config['prefix'] = '/';
		//$config['suffix'] = '/' . $title;
		$config['use_page_numbers'] = TRUE;
		

		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function getVideo($id)
	{
		return $this->db->get_where('videos',array('id'=>$id))->row_array();
	}
}