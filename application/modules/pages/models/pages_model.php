<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Pages_model Extends CI_Model
{	
	public function getPage($id,$url)
	{
		if ($id == '' || ! is_numeric($id) || $id == 0)
		{
			$s = array(
				'status' => 'error',
				'hata'	 => 'URL maksatlı olarak değiştirilmiş!'
			);
		} else {
			$this->update_hit($id);
			$sorgu = $this->db->get_where('pages',array('id'=>$id));
			if ($sorgu->num_rows() != 1)
			{
				$s = array(
					'status' => 'error',
					'hata'	 => 'Belirtilen öğe veritabanında bulunamadı.'
				);
			} else {
				$sonuc = $sorgu->row();				
				$s = array(
					'status' => 'success',
					'baslik' => $sonuc->page_title,
					'icerik' => $sonuc->page_content,
					'hit'	 => $sonuc->page_hit
				);
			}
		}
		return $s;
	}
	
	public function update_hit($id)
	{
		if($this->input->cookie('era_page_read_' . $id) == 'okundu')
		{
			return true;
		} else {
			$sorgu = $this->db->query('update pages set page_hit = page_hit + 1 where id = ' . $id);
			$array = array(
				'name'   => 'era_page_read_' . $id,
				'value'  => 'okundu',
				'expire' => '864000',
			);
			$this->input->set_cookie($array);
		}
	}
	
	public function getSitemapData()
	{
		$r = array();
		
		# Önce anasayfa ve sabit sayfalar
		$r[] = array(
			'loc' => base_url(),
			'changefreq' => 'weekly',
			'priority'	=> '1.0'
		);
		$r[] = array(
			'loc' => base_url('sitemap/html'),
			'changefreq' => 'always',
			'priority'	=> '0.9'
		);
		$r[] = array(
			'loc' => base_url('sitemap/xml'),
			'changefreq' => 'always',
			'priority'	=> '0.9'
		);
		$r[] = array(
			'loc' => base_url('contact'),
			'changefreq' => 'yearly',
			'priority'	=> '0.4'
		);
		
		# Sayfalar ---
		$sayfalar = $this->db->get('pages')->result_array();
		if (count($sayfalar) > 0)
		{
			foreach ($sayfalar as $s)
			{
				$r[] = array(
					'loc' => base_url('page/' . $s['id'] . '/' . no_tr($s['page_title']) . '.html'),
					'changefreq' => 'monthly',
					'priority'	=> '0.6'
				);
			}
		}
		
		# Ziyaretçi Defteri
		$r[] = array(
			'loc' => base_url('guestbook/write'),
			'changefreq' => 'yearly',
			'priority'	=> '0.7'
		);
		$zd = $this->db->get_where('guestbook',array('active'=>1))->num_rows();
		if ($zd > 0)
		{
			$zsayi = ceil($zd/10);
			for ($i=1; $i <= $zsayi; $i++)
			{
				$r[] = array(
					'loc' => base_url('guestbook/read/' . $i . '-page.html'),
					'changefreq' => 'weekly',
					'priority'	=> '0.7'
				);
			}
		}
		
		# Fotoğraf galerisi
		$r[] = array(
			'loc' => base_url('gallery/albums'),
			'changefreq' => 'monthly',
			'priority'	=> '0.6'
		);
		$gal = $this->db->get('galleries')->result_array();
		if (count($gal) > 0)
		{
			foreach ($gal as $g)
			{
				$r[] = array(
					'loc' => base_url('gallery/album/' . $g['id'] . '/1/' . no_tr($g['album_name']) . '.html'),
					'changefreq' => 'monthly',
					'priority'	=> '0.6'
				);
			}
		}
		
		# Videolar
		$video = $this->db->get('videos')->result_array();
		$vsayi = count($video);
		if ($vsayi > 0)
		{
			for ($w = 1; $w <= ceil($vsayi/10); $w++)
			{
				$r[] = array(
					'loc' => base_url('video/page/' . $w),
					'changefreq' => 'monthly',
					'priority'	=> '0.6'
				);
			}
			
			foreach ($video as $v)
			{
				$r[] = array(
					'loc' => base_url('video/watch/' . $v['id'] . '/' . no_tr($v['video_title']) . '.html'),
					'changefreq' => 'monthly',
					'priority'	=> '0.6'
				);
			}
		}
		
		# Haberler ------------------
		$kategoriler = $this->db->get('news_category')->result_array();
		$kat = array();
		$r[] = array(
			'loc' => base_url('news/category/0/0-Tum-Haberler.html'),
			'changefreq' => 'weekly',
			'priority'	=> '0.8'
		);
			# önce kategorileri halledelim. aslında bunlar sayfalı ama, diğer sayfalara gerek yok! onu da arama motorları bulsun :)
		foreach($kategoriler as $kate)
		{
			$kat[$kate['c_id']] = $kate;
			$r[] = array(
				'loc' => base_url('news/category/0/' . $kate['c_id'] . '-' . no_tr($kate['category_name']) . '.html'),
				'changefreq' => 'weekly',
				'priority'	=> '0.8'
			);
		}
		
			# gelelim haberlere ....
		
		$haberler = $this->db->get_where('news',array('active'=>1))->result_array();
		if (count($haberler) > 0)
		{
			foreach ($haberler as $h)
			{
				$r[] = array(
					'loc' => base_url('news/read/' . $h['category'] . '-' . no_tr($kat[$h['category']]['category_name']) . '/' . $h['id'] . '-' . no_tr($h['title']) . '.html'),
					'changefreq' => 'monthly',
					'priority'	=> '0.8'
				);
			}
		}
		
		
		return $r;
	}
}