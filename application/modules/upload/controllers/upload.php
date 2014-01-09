<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Upload Extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
	}
	
	private function _lang_set($lang)
	{
		$this->config->set_item('language', $lang);
		$this->lang->load('jbstrings', $lang);
	}
	
	/* Default upload routine */
		
	public function doUpload($lang='turkish')
	{
		
		$this->_lang_set($lang);
		
		$conf['img_path'] = $this->config->item('img_path');
		$conf['allow_resize'] = $this->config->item('allow_resize');		
		$config['allowed_types'] = $this->config->item('allowed_types');
		$config['max_size'] = $this->config->item('max_size');
		$config['encrypt_name'] = $this->config->item('encrypt_name');
		$config['overwrite'] = $this->config->item('overwrite');
		$config['upload_path'] = $this->config->item('upload_path');
		$config['datetime_name'] = $this->config->item('datetime_name'); 
		
		if (!$conf['allow_resize'])
		{
			$config['max_width'] = $this->config->item('max_width');
			$config['max_height'] = $this->config->item('max_height');
		}
		else
		{
			$conf['max_width'] = $this->config->item('max_width');
			$conf['max_height'] = $this->config->item('max_height');
			
			if ($conf['max_width'] == 0 and $conf['max_height'] == 0)
			{
				$conf['allow_resize'] = FALSE;
			}
		}
		
		$this->load->library('upload', $config);
		
		//die(print_r($this->upload->do_upload()));
		
		if ($this->upload->do_upload())
		{
			$result = $this->upload->data();
			//die(print_r($result));
			
			if ($conf['allow_resize'] and $conf['max_width'] > 0 and $conf['max_height'] > 0 and (($result['image_width'] > $conf['max_width']) or ($result['image_height'] > $conf['max_height'])))
			{				
				$resizeParams = array
				(
					'source_image'=>$result['full_path'],
					'new_image'=>$result['full_path'],
					'width'=>$conf['max_width'],
					'height'=>$conf['max_height']
				);
				
				$this->load->library('image_lib', $resizeParams);
				$this->image_lib->resize();
			}
			
			$result['result'] = "file_uploaded";
			$result['resultcode'] = 'ok';
			$result['file_name'] = base_url(UPLOADPATH . $result['file_name']);
			$this->load->view('ajax_upload_result', $result);
		}
		else
		{
			$result['result'] = $this->upload->display_errors(' ', '<br />');
			$result['resultcode'] = 'failed';
			$this->load->view('ajax_upload_result', $result);
		}
	}
	
	/* Blank Page (default source for iframe) */
	
	public function blank($lang='turkish')
	{
		$this->_lang_set($lang);
		$this->load->view('blank');
	}
	
	public function index($lang='turkish')
	{
		$this->blank($lang);
	}
}

/* End of file editor.php */
/* Location: ./application/controllers/editor.php */
