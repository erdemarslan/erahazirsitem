<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class News_model Extends CI_Model
{
	public function getNews($notice=false,$cat_id=0,$how=10)
	{
		$id = $this->noticeInfo();
		//$say_duyuru = count($id);
		
		$this->db->select('*');
		$this->db->from('news');
		$this->db->join('news_category', 'news.category = news_category.c_id');
		$this->db->where('active',1);
		$this->db->order_by('date','desc');
		$this->db->limit($how);
		
		if ($notice)
		{
			if ($id === false)
			{
				return array();
			} else {
				$this->db->where('category',$id['c_id']);
				$sorgu = $this->db->get();
				if ($sorgu->num_rows() == 0) { return array(); } else { return $sorgu->result_array(); }
			}
		} else {
		
			if ($cat_id == 0)
			{
				if ($id === false)
				{
					$sorgu = $this->db->get();
					if ($sorgu->num_rows() == 0) { return array(); } else { return $sorgu->result_array(); }
				} else {
					$this->db->where('category !=',$id['c_id']);
					$sorgu = $this->db->get();
					if ($sorgu->num_rows() == 0) { return array(); } else { return $sorgu->result_array(); }
				}
			} else {
				$this->db->where('category', $cat_id);
				$sorgu = $this->db->get();
				if ($sorgu->num_rows() == 0) { return array(); } else { return $sorgu->result_array(); }
			}
		}
	} // getNotice sonu
	
	public function save_user_news($veriler)
	{
		if (is_array($veriler))
		{
			$this->db->insert('news',$veriler);
		}
		return true;
	}
	
	public function noticeInfo()
	{
		
		//$this->db->from('news_category');
		//$this->db->where('is_notice',1);
		//$this->db->limit(1);
		$sor = $this->db->query('select * from news_category where is_notice = 1 limit 1');
		if ($sor->num_rows() > 0)
		{
			return $sor->row_array();
		} else {
			return false;
		}
	}
	
	public function getCategories()
	{
		$this->db->order_by('category_name','asc');
		$sorgu = $this->db->get('news_category');
		return $sorgu->result_array();
	}
	
	public function getCategoryItems($id,$s)
	{
		if ($id == 0)
		{
			$this->db->where('active',1);
			$toplam = $this->db->count_all_results('news');
		} else {
			$this->db->where('active',1);
			$this->db->where('category',$id);
			$toplam = $this->db->count_all_results('news');
		}
		
		$id == 0 ? $sql = "select * from news join news_category on news.category = news_category.c_id where active = 1 order by date desc limit $s,20" : $sql = "select * from news join news_category on news.category = news_category.c_id where active = 1 and category = $id order by date desc limit $s,20";
		
		
		
		$sorgu = $this->db->query($sql);
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = array(
				'news' => $sorgu->result_array(),
				'total'	 => $toplam
			);
		} else {
			$sonuc = array();
		}
		return $sonuc;
		//$sorgu->free_result();
	}
	
	
	public function getLinks($total,$title)
	{
		$config['base_url'] = base_url('news/category/');
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
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
		$config['suffix'] = '/' . $title;

		$this->load->library('pagination');     
		$this->pagination->initialize($config);                 
        return $this->pagination->create_links();
	}
	
	public function getNewsItem($id)
	{
		# Okundu mu?
		$this->updateHit($id);
		
		$this->db->select('*');
		$this->db->from('news');
		$this->db->join('news_category', 'news.category = news_category.c_id');
		$this->db->where('active',1);
		$this->db->where('id',$id);
		$sorgu = $this->db->get();
		
		if ($sorgu->num_rows() == 0)
		{
			return array();
		} else {
			$sonuc = $sorgu->row_array();
			$benzer = $this->getRelatedPosts($sonuc['category'],$id);
			return array(
				'post' => $sonuc,
				'related' => $benzer
			);
		}		
	}
	
	public function getRelatedPosts($cat,$id)
	{
		$this->db->select('news.id,news.category,news.title,news.active,news_category.c_id,news_category.category_name');
		$this->db->from('news');
		$this->db->join('news_category', 'news.category = news_category.c_id');
		$this->db->where('category',$cat);
		$this->db->where('id !=', $id);
		$this->db->where('active',1);
		$this->db->order_by('id','random');
		$this->db->limit(5);
		$sorgu = $this->db->get();
		return $sorgu->result_array();
	}
	
	public function updateHit($id)
	{
		// cookielere bak :)
		if($this->input->cookie('era_news_read_' . $id) == 'okundu')
		{
			return true;
		} else {
			$this->db->query('update news set hit = hit+1 where id = ' . $id);
			$array = array(
				'name'   => 'era_news_read_' . $id,
				'value'  => 'okundu',
				'expire' => '864000',
			);
			$this->input->set_cookie($array);
		}
	}
}