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
		$this->load->model('video_admin_model');
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
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		$data['videos'] = $this->video_admin_model->getVideos();
				
		$this->load->view('admin/video_index',$data);
	}
	
	public function delete($id)
	{
		$this->db->delete('videos',array('id'=>$id));
		js_alert('Video silindi! Yönlendiriliyorsunuz!');
		js_timeout(base_url('admin/video'),300);
	}
	
	public function getVideo()
	{
		if ($this->input->is_ajax_request())
		{
			echo json_encode($this->video_admin_model->getYoutubeVideo($this->input->get('url')));
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
		}
	}
	
	public function getVideoInfo()
	{
		if ($this->input->is_ajax_request())
		{
			echo json_encode($this->video_admin_model->getVideoDB($this->input->get('id')));
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
		}
	}
	
	public function save()
	{
		if ($this->input->is_ajax_request())
		{
			//print_r($this->input->post());
			$f = $this->input->post();
			if ($f['v_id'] == 0)
			{
				$array = $f;
				unset($array['v_id']);
				//print_r($array);
				$this->db->insert('videos',$array);
				echo 'ok';
			} else {
				$array = $f;
				unset($array['v_id']);
				//print_r($array);
				$this->db->where('id',$f['v_id']);
				$this->db->update('videos',$array);
				echo 'ok';
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
		}
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}