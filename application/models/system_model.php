<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class System_model Extends CI_Model
{
	public function getSettings()
	{
		$query = $this->db->get('settings');
		$result = $query->result_array();
		foreach ($result as $s)
		{
			if ($s['is_array'] == 1)
			{
				$this->config->set_item($s['setting_name'],json_decode($s['setting_value']));
			} else {
				$this->config->set_item($s['setting_name'],$s['setting_value']);
			}
		}
		$xml = simplexml_load_file(THEMEPATH . $this->config->item('current_theme') . '/' . $this->config->item('current_theme') . '.xml');
		foreach($xml as $k=>$v)
		{
			$this->config->set_item($k,$v);
		}
	} // getir_ayarlar() sonu
        
	// Tarayıcınının internet explorer 5.5 ve 6 olup olmadığını kontrol eder! Eğer öyleyse yönlendirir.
	public function check_browser()
	{
		$this->check_blacklist();
		
		$this->load->library('user_agent');
		$agent = $this->agent->getBrowser();
		
		if ($agent['Browser'] == 'IE')
		{
			if($agent['MajorVer'] == '5' OR $agent['MajorVer'] == '6')
			{
				redirect('error/browser');
			}
		}
		
	}
	
	// Menüleri çek
	public function getMenu()
	{
		$this->db->order_by('align asc');
		$sorgu = $this->db->get('menus');
		$sonuc = $sorgu->result_array();
		return $sonuc;
	}
	
	
	# İstatistik ve sayaçları oluştur ve uygula!
	# Versiyon 1.1 -> yeniden düzenleme
	# yenilikler -> botlarla ziyaretçileri ayırır. 5 dakika aralıklarla kaydetmeyi kapatır!
	# Gerçek sayım işlemi yani :)
	// Gerekli veritabanları -> stat_user, stat_crawler, stat_online
	public function getStats()
	{
		# verilerimizi hazırlayalım
		$ip = $this->input->ip_address();
		$now = time();
		$today = mktime(0,0,0,date('m',$now),date('d',$now),date('Y',$now));
		$fiveminago = ($now - (60*5));
		$sess_id = $this->session->userdata('session_id');
		# online da 5 dakikadan daha fazla olanları sil
		$this->db->delete('stat_online',array('time <' => $fiveminago));
		# User agent sınıfını yükleyelim :)
		$this->load->library('user_agent');
		# gelen kişinin agent bilgilerini alalım? :)
		$agent = $this->agent->getBrowser();
		# Bot mu değil mi kontrol edelim. Botsa ona göre, değilse buna göre işlem yapalım.
		if ($agent['Crawler'] == '1' OR $agent['isSyndicationReader'] == '1')
		{
			$crawler_data = array(
				'sess_id'	=> $sess_id,
				'ip'		=> $ip,
				'time'		=> $now,
				'name'		=> $agent['Browser'],
				'version'	=> $agent['Version']
			);
			$this->db->insert('stat_crawlers',$crawler_data);
			$kisisel = array(
				'ip'		=> $ip,
				'country'	=> $agent['Browser'],
				'isp'		=> $agent['Browser'] . ' ' . $agent['Version'],
				'flag'		=> 'None'
			);
		} else {
			# IP Bilgilerini al
			$ipinfo = $this->getIPInfo($ip);
			
			// Bugün girilmiş mi? - session değeriyle bakılırsa, aynı gün içerisinde farklı tarayıcı ve girişlerde sayaç artar.
			// bunu istemiyoruz :)
			$bugun_ara = array(
				//'sess_id'	=> $sess_id,
				'ip'		=> $ip,
				'time >='	=> $today
			);
			$bugun = $this->db->get_where('stat_users',$bugun_ara);
			if ($bugun->num_rows() > 0)
			{
				// online ı kontrol et! varsa düzenle yoksa ekle!
				$online_ara = array(
					'sess_id'	=> $sess_id,
					'ip'		=> $ip
				);
				if ($this->db->get_where('stat_online',$online_ara)->num_rows() > 0)
				{
					$this->db->where($online_ara);
					$this->db->update('stat_online',array('time'=>$now));
				} else {
					$online_data = array(
						'sess_id'	=> $sess_id,
						'ip'		=> $ip,
						'time'		=> $now
					);
					$this->db->insert('stat_online',$online_data);
				}
				
			} else {
				// bugün girilmemiş!
				// bugüne ve online a kaydet
				$agent['isMobileDevice'] == '1' ? $pm = 'Mobile' : $pm = 'PC';
				$agent['Win64'] == '1' ? $x64 = ' 64 Bit' : $x64 = '';
				$bugun_data = array(
					'sess_id'	=> $sess_id,
					'ip'		=> $ip,
					'time'		=> $now,
					'country'	=> $ipinfo['country'],
					'isp'		=> $ipinfo['isp'],
					'flag'		=> $ipinfo['flag'],
					'platform'	=> $agent['Platform'] . $x64,
					'browser'	=> $agent['Browser'],
					'version'	=> $agent['Version'],
					'pc_mobile'	=> $pm
				);
				$this->db->insert('stat_users',$bugun_data);
				$online_data = array(
					'sess_id'	=> $sess_id,
					'ip'		=> $ip,
					'time'		=> $now
				);
				$this->db->insert('stat_online',$online_data);
			}
			
			$kisisel = array(
				'ip'		=> $ip,
				'country'	=> $ipinfo['country'],
				'isp'		=> $ipinfo['isp'],
				'flag'		=> $ipinfo['flag']
			);
		}
		
		$online = $this->db->get('stat_online')->num_rows();
		$todays = $this->db->where('time >',$today)->get('stat_users')->num_rows();
		$total = $this->db->get('stat_users')->num_rows();
		
		
		return array(
			'user'	=> $kisisel,
			'online'=> $online,
			'today'	=> $todays,
			'total'	=> $total
		);
	}
	
	
	# IP2Location için gerekli bir zımbırtı
	# işleri kolaylaştırıyor :)
	private function getIPInfo($ip)
	{
		//$c = json_decode(file_get_contents('http://whatsmyip.erdemarslan.com/api/' . $ip),TRUE);
		$c = array(
      'status'  => 'ok',
      'country' => 'Türkiye',
      'isp'     => 'Belirlenemedi',
      'flag'    => 'http://www.pekerinsaat.com.tr/components/com_joomfish/images/flags/tr.gif'
		);
		$r = array();
		if ($c['status'] == 'ok')
		{
			$r['country']	= $c['country'];
			$r['isp']		= $c['isp'];
			$r['flag']		= $c['flag'];
		} else {
			$r['country']	= 'Türkiye';
			$r['isp']		= 'Belirlenemedi';
			$r['flag']		= 'http://www.pekerinsaat.com.tr/components/com_joomfish/images/flags/tr.gif';
		}
		return $r;
	}
	
	# Bu fonksiyon, ip adresinin kara listede olup olmadığını kontrol eder. eğer öyleyse, ban sayfasına yönlendirir.
	# Spam botları, istenmeyen botlar, zararlı kullanıcılar için idealdir. :)
	# tarih saat ile kontrol yapılırsa daha da süper olur. bazı kullanıcıların banlanması için  de ideal olur.
	private function check_blacklist()
	{
		$ip = $this->input->ip_address();
		$time = time();
		$sorgu = $this->db->get_where('stat_blacklist',array('ip'=>$ip));
		if ($sorgu->num_rows() > 0)
		{
			$sonuc = $sorgu->row_array();
			
			if ($sonuc['time'] == 0 OR $sonuc['time'] > $time)
			{
				$this->session->set_userdata('ban_ip',$ip);
				$this->session->set_userdata('ban_time',$sonuc['time']);
				redirect(base_url('error/ip_ban'));
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
}