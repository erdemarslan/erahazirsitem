<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Users_model Extends CI_Model
{
	public function save_user($data)
	{
		if (!is_array($data))
		{
			return false;
		} else {
			if((!$data['me']))
			{
				return false;
			} else {
				$face_id = $data['me']['id'];
				$adi = $data['me']['name'];
				$email = $data['me']['email'];
				$dt = explode('/',$data['me']['birthday']);
				$dogumtarihi = mktime(0,0,0,$dt[0],$dt[1],$dt[2]);
				$cins = $data['me']['gender'];
				if ($cins == 'male') { $cinsiyet = 'Erkek'; }
				elseif ($cins == 'female') {$cinsiyet = 'Kadın'; }
				else { $cinsiyet = 'Belirtilmemiş'; }
				if (isset($data['me']['website']))
				{
					$web = explode ("\r\n",$data['me']['website']);
					$website = $web[0];
				} else {
					$website = '';
				}
				if (isset($data['me']['location']['name']))
				{
					$yer = $data['me']['location']['name'];
				} else {
					$yer = 'Belirtilmemiş';
				}
				
				$sorgu = $this->db->get_where('users',array('facebook_id'=>$face_id));
				if ($sorgu->num_rows() != 0)
				{
					$sonuc = $sorgu->row_array();
					if ($sonuc['visible'] == 1)
					{
						return false;
					} else {
						$this->db->where('facebook_id',$face_id);
						$this->db->update('users',array('visible'=>1));
						return true;
					}
					
				} else {
					$veri = array(
							'facebook_id'	=> $face_id,
							'name'			=> $adi,
							'email'			=> $email,
							'birtday'		=> $dogumtarihi,
							'sex'			=> $cinsiyet,
							'website'		=> $website,
							'location'		=> $yer,
							'visible'		=> 1
						);
					$this->db->insert('users',$veri);
					return true;
				}
			}
		}
	} // save_user sonu
	
	public function getUserInfo($fb_uid)
	{
		$sorgu = $this->db->get_where('users',array('facebook_id'=>$fb_uid));
		if ($sorgu->num_rows() == 0) { return array(); } else { return $sorgu->row_array(); }
	}
	
	public function updateUser($data)
	{
		if (!is_array($data))
		{
			return 'Geçersiz veri gönderildi!';
		} else {
			$face_id = $data['id'];
			$adi = $data['name'];
			$email = $data['email'];
			$dt = explode('/',$data['birthday']);
			$dogumtarihi = mktime(0,0,0,$dt[0],$dt[1],$dt[2]);
			$cins = $data['gender'];
			if ($cins == 'male') { $cinsiyet = 'Erkek'; }
			elseif ($cins == 'female') {$cinsiyet = 'Kadın'; }
			else { $cinsiyet = 'Belirtilmemiş'; }
			if (isset($data['website']))
			{
				$web = explode ("\r\n",$data['website']);
				$website = $web[0];
			} else {
				$website = '';
			}
			$yer = $data['location']['name'];
			
			$array = array(
				'name' => $adi,
				'email' => $email,
				'birtday' => $dogumtarihi,
				'sex' => $cinsiyet,
				'website' => $website,
				'location' => $yer,
				'visible' => 1
			);
			
			$this->db->where('facebook_id',$face_id);
			$this->db->update('users',$array);
			return 'Bilgileriniz başarıyla güncellendi.';
		}
	}
	
	public function unvisibleUser($data)
	{
		$array = array(
			'visible' => 0
		);
			
		$this->db->where('facebook_id',$data['id']);
		$this->db->update('users',$array);
		return 'Kaydınız başarıyla silindi. Facebook üzerinden verdiğiniz izinleri kaldırabilirsiniz.';
	}
}