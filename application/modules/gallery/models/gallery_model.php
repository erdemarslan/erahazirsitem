<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Gallery_model Extends CI_Model
{
	public function getAlbums()
	{
		$sorgu = $this->db->order_by('album_id','desc')->get('galleries');
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->result_array();
			$return = array();
			
			foreach ($sonuc as $s)
			{
				$kac = $this->db->get_where('gallery_photos',array('album_id'=>$s['album_id']));
				$s['numPhotos'] = $kac->num_rows();
				$return[] = $s;
			}
		} else {
			$return = array();
		}
		//die(print_r($return));
		return $return;
	}
	
	
	public function getAlbum($id,$p=1)
	{
		
		$sorgu = $this->db->get_where('galleries',array('id'=>$id));
		if ($sorgu->num_rows() > 0)
		{
			$album_info = $sorgu->row_array();
			$this->db->where('album_id',$album_info['album_id']);
			$toplam = $this->db->count_all_results('gallery_photos');
			
			$this->db->select('*');
			$this->db->from('gallery_photos');
			$this->db->where('album_id',$album_info['album_id']);
			$this->db->order_by('id','asc');
			$this->db->limit(15,($p-1)*15);
			$sorgu = $this->db->get();
			//$sorgu = $this->db->query('select * from guestbook where active = 1 order by date desc limit ' . $start . ',10');
			if ($sorgu->num_rows() > 0)
			{
				$sonuc = array(
					'album'	 => $album_info,
					'photos' => $sorgu->result_array(),
					'total'	 => $toplam
				);
			} else {
				$sonuc = array(
					'album'	 => $album_info,
					'photos' => array(),
					'total'	 => 0
				);
			}
		} else {
			$sonuc = array(
				'album'	 => array(),
				'photos' => array(),
				'total'	 => 0
			);
		}
		return $sonuc;
	}
	
	
	public function getLinks($id,$total,$title)
	{
		$config['base_url'] = base_url('gallery/album/' . $id . '/');
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $total;
		$config['first_url'] = base_url('gallery/album/' . $id . '/1/'. $title);
		
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
		
		$config['prefix'] = '/';
		$config['suffix'] = '/' . $title;
		$config['use_page_numbers'] = TRUE;
		

		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function getPhoto($id)
	{
		$sorgu = $this->db->get_where('gallery_photos',array('id'=>$id));
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->row_array();
			
			//$next = 'empty';
			$next = $this->__getNextPhoto($sonuc['album_id'],$id);
			$prev = $this->__getPrevPhoto($sonuc['album_id'],$id);
			
			$img_info = getimagesize($sonuc['photo_url']);
			
			return array(
				'photo' => array(
							'url'		=> $sonuc['photo_url'],
							'width'		=> $img_info[0],
							'height'	=> $img_info[1],
							'album'		=> $sonuc['album_id'],
							'photoID'	=> $sonuc['photo_id'],
							'id'		=> $id
						),
				'next'	=> $next,
				'prev'	=> $prev
			);
		} else {
			return array();
		}
	}
	
	private function __getNextPhoto($album,$photo)
	{
		$sorgu = $this->db->query('select * from gallery_photos where album_id = ' . $album . ' AND id > ' . intval($photo) . ' order by id asc LIMIT 1');
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->row_array();
			return base_url('gallery/photo/' . $sonuc['id'] . '/view.html');
		} else {
			return 'empty';
		}
	}
	
	private function __getPrevPhoto($album,$photo)
	{
		$sorgu = $this->db->query('select * from gallery_photos where album_id = ' . $album . ' AND id < ' . intval($photo) . ' order by id desc LIMIT 1');
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->row_array();
			return base_url('gallery/photo/' . $sonuc['id'] . '/view.html');
		} else {
			return 'empty';
		}
	}
	
}