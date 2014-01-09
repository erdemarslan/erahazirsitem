<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class News_admin_model Extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getNews($all=true,$id=0)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->join('news_category', 'news.category = news_category.c_id');
		$this->db->order_by('date','desc');
		
		if ($all)
		{
			
			$sorgu = $this->db->get();
			if ($sorgu->num_rows == 0)
			{
				return array(
					'status' => 'error',
					'info'	 => 'Bu siteye hiç haber eklenmemiş!'
				);
			} else {
				return array(
					'status'	=> 'ok',
					'info'		=> $sorgu->result_array()
				);
			}
		} else {
			if ($id == 0)
			{
				return array(
					'status' => 'error',
					'info'	 => 'Lütfen ulaşmak istediğiniz haberin id numarasını belirtiniz!'
				);
			} else {
				$this->db->where('id',$id);
				$sorgu = $this->db->get();
				if ($sorgu->num_rows == 0)
				{
					return array(
						'status' => 'error',
						'info'	 => 'Belirtilen id numarasına göre içerik bulunamadı!'
					);
				} else {
					return array(
						'status' => 'ok',
						'info'	 => $sorgu->row_array()
					);
				}
			}
		}
	} # getNews sonu
	
	
	public function getImageNames()
	{
		$path = UPLOADPATH . 'news_*.*';
		return glob($path);
	}
	
	public function save_news($data)
	{
		if (is_array($data))
		{
			$this->db->insert('news',$data);
			if ($this->db->insert_id() > 0) { return true; } else { return false; }
		} else {
			return false;
		}
	}
	
	public function update_news($id,$data)
	{
		if (is_numeric($id) AND $id != 0 AND is_array($data))
		{
			$this->db->where('id',$id);
			$this->db->update('news',$data);
			if ($this->db->affected_rows() > 0) { return true; } else { return false; }
		} else {
			return false;
		}
	}
	
	public function getCategories()
	{
		return $this->db->get('news_category')->result_array();
	}
}