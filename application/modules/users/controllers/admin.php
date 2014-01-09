<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Admin Extends MX_Controller
{
    public function __construct()
	{
		parent::__construct();
		# Veritabanından ayarları al
		$this->system_model->getSettings();
		# Kendi modelini yükle
		$this->load->model('users_admin_model');
		# Ana admin modelini yükle
		$this->load->model('admin/admin_model');
		# Giriş yoksa postala
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
	}
	
	public function index()
	{
		$data['users'] = $this->users_admin_model->getUsers();
		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('users_index'),$data);
	}
	
	public function stats($p=1,$order='id',$by='desc')
	{
		$stats = $this->users_admin_model->getStats($p,$order,$by);
		$data['stats'] = $stats['result'];
		if (count($stats['result']) > 0)
		{
			$data['links'] = $this->users_admin_model->getLinks($stats['total'],$order,$by);
		}
		
		$data['page_info'] = array( 'page' => $p, 'order' => $order, 'by'	=> $by );
		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('users_stats'),$data);
	}
	
	public function ban()
	{
		if ($this->input->is_ajax_request())
		{
			$ip = $this->input->post('ip');
			$val = $this->input->post('v');
			
			is_numeric($val) ? $v = $val : $v = 0;
			
			if ($v > 0)
			{
				$zaman = time();
				$zaman = $zaman + (86400*$v);
				$v = $zaman;
			}
			
			if ($this->input->valid_ip($ip))
			{
				if ($this->db->get_where('stat_blacklist',array('ip'=>$ip))->num_rows() > 0)
				{
					$this->db->where('ip',$ip);
					$this->db->update('stat_blacklist',array('time'=>$v));
					echo 'Engellenme Süresi güncellendi!';
				} else {
					$data = array(
						'ip'	=> $ip,
						'time'	=> $v
					);
					$this->db->insert('stat_blacklist',$data);
					echo 'IP Adresi başarıyla engellendi!';
				}
			} else {
				echo 'IP Adresi geçersiz gözküyor. İşlem iptal edildi!';
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom adn get out here.';
		}
	}
	
	public function crawlers()
	{
		$data['crawlers'] = $this->users_admin_model->getCrawlers();		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('users_crawlers'),$data);
	}
	
	public function delete_crawlers()
	{
		$this->db->query('TRUNCATE stat_crawlers;');
		js_alert('İstatistikler başarıyla sıfırlandı. Yönlendiriliyorsunuz...');
		js_timeout(base_url('admin/users/crawlers'),300);
	}
	
	public function blacklist()
	{
		$data['blacklist'] = $this->users_admin_model->getBlacklist();		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$this->load->view(admin('users_blacklist'),$data);
	}
	
	public function blacklist_delete($id)
	{
		if (is_numeric($id) && $id > 0)
		{
			$this->db->delete('stat_blacklist',array('id'=>$id));
		}
		
		js_alert('IP Engeli kaldırıldı. Yönlendiriliyorsunuz...');
		js_timeout(base_url('admin/users/blacklist'),300);
	}
}