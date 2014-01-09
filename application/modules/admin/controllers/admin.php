<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Admin Extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        # Veritabanından ayarları al ve sisteme uyarla!
        $this->system_model->getSettings();
		# Sınıfa ait modeli işleme alalım
		$this->load->model('admin_model');
    }
    
    public function index()
    {
        self::login();
    }
	
	public function home()
    {
        if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['info'] = $this->admin_model->getSiteInfo();
		$this->load->view(admin('home'),$data);
    }
	
	public function settings()
	{
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		
		$this->load->view(admin('settings'),$data);
	}
	
	public function save_settings()
	{
		if ($this->input->is_ajax_request())
		{
			//print_r($this->input->post());
			//die();
			$form = $this->input->post();
			switch ($form['what_i_do'])
			{
				default:
					echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
				break;
				
				case ('user_pass') :
					if ($form['admin_password_user'] == '' OR $form['admin_password_pass_cur'] == '' OR $form['admin_password_pass_new'] == '' OR $form['admin_password_pass_re'] == '')
					{
						echo 'Formdan gelen bilgilerde eksik var! Güncelleme işlemi başarısız!';
					}
					elseif (sha1(md5($form['admin_password_pass_cur'])) != $this->config->item('admin_password'))
					{
						echo 'Geçerli şifrenizi yanlış girdiniz! Güncelleme işlemi başarısız!';
					}
					elseif ($form['admin_password_pass_new'] != $form['admin_password_pass_re'])
					{
						echo 'Yeni şifre ile tekrar uyuşmuyor! Güncelleme başarısız!';
					}
					else
					{
						$this->db->where('setting_name','admin_username')->update('settings',array('setting_value'=>$form['admin_password_user']));
						$this->db->where('setting_name','admin_password')->update('settings',array('setting_value'=>sha1(md5($form['admin_password_pass_new']))));
						echo 'ok';
					}
				break;
				
				case ('general_setting') :
					if (sha1(md5($form['pass'])) != $this->config->item('admin_password'))
					{
						echo 'Geçerli şifrenizi yanlış girdiniz! Güncelleme işlemi başarısız!';
					} else {
						foreach ($form as $k=>$v)
						{
							if ($k == 'site_title' OR $k == 'site_desc' OR $k == 'site_keywords' OR $k == 'site_slogan' OR $k == 'site_copyright' OR $k == 'site_contact_mail' OR $k == 'current_theme' OR $k == 'theme_logo')
							{
								$this->db->where('setting_name',$k)->update('settings',array('setting_value'=>$v));
							}
						}
						echo 'ok';
					}
				break;
				
				case ('other_setting') :
					if (sha1(md5($form['pass'])) != $this->config->item('admin_password'))
					{
						echo 'Geçerli şifrenizi yanlış girdiniz! Güncelleme işlemi başarısız!';
					} else {
						
						/**/
						foreach ($form as $k=>$v)
						{
							if ($k == 'gmail_smtp_user' OR $k == 'gmail_smtp_pass' OR $k == 'site_facebook_appid' OR $k == 'site_facebook_secret' OR $k == 'gallery_facebook_appid' OR $k == 'gallery_facebook_secret' OR $k == 'prayer_active' OR $k == 'prayer_country' OR $k == 'prayer_location' OR $k == 'weather_active' OR $k == 'weather_location')
							{
								$this->db->where('setting_name',$k)->update('settings',array('setting_value'=>$v));
							}
						}
						echo 'ok';
						
					}
				break;
				
				
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
		}
	}
    
    public function login()
    {
        if ($this->session->userdata('admin'))
        {
            redirect('admin/home');
        }
		
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		$this->form_validation->set_rules('security', 'Güvenlik Kodu', 'trim|required|strip_tags|callback_check_security');
		$this->form_validation->set_rules('username', 'Kullanıcı Adı', 'trim|required|strip_tags');
		$this->form_validation->set_rules('password', 'Şifre', 'trim|required|strip_tags');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view(admin('login'));
		}
		else
		{
			if ($this->input->post('username') == $this->config->item('admin_username') && sha1(md5($this->input->post('password'))) == $this->config->item('admin_password'))
			{
				$this->session->set_userdata('admin',true);
				redirect('admin/home');
			} else {
				$this->load->view(admin('login'));
			}
			
			
		}
	}
	
	public function check_username($str)
	{
		
		if ($str != $this->config->item('admin_username'))
		{
			$this->form_validation->set_message('check_username', '%s geçerli değil!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function check_password($str)
	{
		
		if (sha1(md5($str)) != $this->config->item('admin_password'))
		{
			$this->form_validation->set_message('check_password', '%s geçerli değil!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	 
	public function check_security($str)
	{
		//return TRUE;
		if ( $str != $this->session->userdata($this->config->item('captcha_session_name')) )
		{
			$this->form_validation->set_message('check_security', '%s resim ile uyuşmuyor!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
    
    public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect('admin/login');
    }
	
	public function menu()
	{
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		$site_menus = $this->admin_model->getMenus();
		//die(print_r($site_menus));
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['site_menus'] = $site_menus;
		$this->load->view(admin('admin_menu'),$data);
	}
	
	public function menu_save()
	{
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		if ($this->input->is_ajax_request())
		{
			$form = $this->input->post();
			//die(print_r($form));
			if ($form['add_menu_id'] == 0)
			{
				/* kayıt */
				$dizi = array(
					'name'	=> $form['add_menu_name'],
					'url'	=> $form['add_menu_url'],
					'target' => $form['add_menu_target'],
					'align'	=> $form['add_menu_align']
				);
				
				$this->db->insert('menus',$dizi);
				echo 'ok';
			} else {
				$dizi = array(
					'name'	=> $form['add_menu_name'],
					'url'	=> $form['add_menu_url'],
					'target' => $form['add_menu_target'],
					'align'	=> $form['add_menu_align']
				);
				$this->db->where('id',$form['add_menu_id']);
				$this->db->update('menus',$dizi);
				echo 'ok';
				// güncelleme
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here!';
		}
	}
	
	public function menu_delete()
	{
		if (!$this->session->userdata('admin'))
        {
            redirect('admin/login');
        }
		
		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('m_id') == '')
			{
				echo 'Silinecek öğe bulunamadı!';
			} else {
				$this->db->delete('menus',array('id'=>$this->input->post('m_id')));
				echo 'ok';
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here!';
		}
	}
    
}