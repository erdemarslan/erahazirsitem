<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Pages_admin_model Extends CI_Model
{
	public function getPage($all=true,$id=0)
	{
		if ($all)
		{
			$sorgu = $this->db->get('pages');
			if ($sorgu->num_rows == 0)
			{
				return array(
					'status' => 'error',
					'info'	 => 'Bu siteye hiç sayfa eklenmemiş!'
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
					'info'	 => 'Lütfen ulaşmak istediğiniz sayfanın id numarasını belirtiniz!'
				);
			} else {
				$sorgu = $this->db->get_where('pages',array('id' => $id));
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
	} # getPage sonu
	
	
	
	
	
	
	
}