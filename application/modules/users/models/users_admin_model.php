<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Users_admin_model Extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getUsers()
	{
		$sorgu = $this->db->get('users');
		if ($sorgu->num_rows() > 0)
		{
			return array(
				'status' => 'ok',
				'info'	=> $sorgu->result_array()
			);
		} else {
			return array(
				'status'	=> 'error',
				'info'		=> 'Facebook ile siteye giriş yapmış üye bulunamadı!'
			);
		}
	}
	
	public function getStats($p=1,$order='id',$by='asc')
	{
		$toplam = $this->db->get('stat_users')->num_rows();
		switch($order)
		{
			default:
			case ('id') :
				$o = 'id';
			break;
			
			case ('ip') :
				$o = 'ip';
			break;
			
			case ('time') :
				$o = 'time';
			break;
			
			case ('country') :
				$o = 'country';
			break;
			
			case ('isp') :
				$o = 'isp';
			break;
			
			case ('platform') :
				$o = 'platform';
			break;
			
			case ('browser') :
				$o = 'browser';
			break;
		}
		
		$by == 'asc' ? $b = 'asc' : $b = 'desc';
		
		$this->db->order_by($o,$b);
		$this->db->limit(50,($p-1)*50);
		$sorgu = $this->db->get('stat_users');
		$sonuc = $sorgu->result_array();
		return array(
			'total'	=> $toplam,
			'result'	=> $sonuc
		);
	}
	
	public function getLinks($total,$order,$by)
	{
		$config['base_url'] = base_url('admin/users/stats');
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $total;
		$config['first_url'] = base_url('admin/users/stats/1/' . $order . '/' . $by);
		
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
		
		$config['suffix'] = '/' . $order . '/' . $by;
		$config['use_page_numbers'] = TRUE;

		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function getCrawlers()
	{
		$this->db->distinct();
		$this->db->select('name');
		//$this->db->group_by(array('name'));
		$this->db->order_by('name','asc');
		$sorgu = $this->db->get('stat_crawlers');
		$botlar = $sorgu->result_array();
		
		if (count($botlar) > 0)
		{
			$r = array();
			foreach ($botlar as $b)
			{
				$this->db->where('name',$b['name']);
				$this->db->order_by('time','desc');
				$sor = $this->db->get('stat_crawlers');
				$kac = $sor->num_rows();
				$r[] = array(
					'data' => $sor->row_array(),
					'num_rows' => $kac
					);
			}
			
			return $r;
			
		} else {
			return array();
		}
	}
	
	public function getBlacklist()
	{
		return $this->db->get('stat_blacklist')->result_array();
	}
}