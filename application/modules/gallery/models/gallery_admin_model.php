<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Gallery_admin_model Extends CI_Model
{
	public function getAlbums()
	{
		$sorgu = $this->db->get('galleries');
		$album_ids = array();
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->result_array();
			foreach ($sonuc as $s)
			{
				$album_ids[$s['album_id']] = 'ok';
			}
			
		} else {
			$sonuc = array();
		}
		
		return array(
			'album_ids' => $album_ids,
			'albums'	=> $sonuc
		);
	}
	
	public function isGallerySaved($id)
	{
		$sorgu = $this->db->get_where('galleries',array('album_id'=>$id));
		if ($sorgu->num_rows() > 0)
		{
			$yeni_sorgu = $this->db->get_where('gallery_photos',array('album_id'=>$id));
			$sonuc = array();
			
			if ($yeni_sorgu->num_rows() > 0)
			{
				foreach  ($yeni_sorgu->result_array() as $r)
				{
					$sonuc[$r['photo_id']] = $r['album_id'];
				}
			}
						
			return array(
				'status'	=> true,
				'data'		=> $sonuc
			);
		} else {
			return array(
				'status' => false,
				'data'	 => array()
			);
		}
	}
	
	public function getAlbum($id)
	{
		$sorgu = $this->db->get_where('galleries',array('album_id'=>$id));
		return $sorgu->row_array();
	}
	
	public function deleteAlbumFromDB($id)
	{
		$this->db->delete('galleries',array('album_id'=>$id));
		$this->db->delete('gallery_photos',array('album_id'=>$id));
		$fotolar = glob(UPLOADPATH . 'gallery/' . $id . '_*.*');
		foreach ($fotolar as $f)
		{
			unlink($f);
		}
	}
}