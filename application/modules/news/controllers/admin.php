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
		$this->load->model('news_admin_model');
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
		$data['news'] = $this->news_admin_model->getNews();
		$data['cats'] = $this->news_admin_model->getCategories();
		
		$this->load->view('admin/news_index',$data);	
	}
	
	public function delete($id)
	{
		if (is_numeric($id))
		{
			$this->db->delete('news',array('id'=>$id));
			js_alert('Haber başarıyla silindi! Yönlendiriliyorsunuz!');
		}
		js_timeout(base_url('admin/news'),500);
	}
	
	public function activate($id=0,$ac='e')
	{
		if ($id != 0 AND is_numeric($id))
		{
			$this->db->where('id', $id);
			$ac == 'y' ? $this->db->update('news',array('active'=>1)) : $this->db->update('news',array('active'=>0));
			$ac == 'y' ? js_alert('Haber başarıyla onaylandı!') : js_alert('Haberin onayı başarıyla kaldırıldı!');
		}
		js_timeout(base_url('admin/news'),500);
	}
	
	public function add_new()
	{
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		
		// site gösterim modelini de yükle
		$this->load->model('news_model');
		
		$data['categories'] = $this->news_model->getCategories();
		$data['images'] = $this->news_admin_model->getImageNames();
		
		$this->load->view('admin/news_add',$data);
	}
	
	public function edit($id=0)
	{
		if ($id == '' OR $id == 0)
		{
			redirect(base_url('admin'));
		}
		
		$veri = $this->news_admin_model->getNews(false,$id);
		if ($veri['status'] === 'error')
		{
			redirect(base_url('admin'));
		} else {
			$data['haber'] = $veri['info'];
		}
		
		$data['menuler'] = $this->admin_model->admin_menu();
        $data['update'] = $this->admin_model->getUpdate();
		
		// site gösterim modelini de yükle
		$this->load->model('news_model');
		
		$data['categories'] = $this->news_model->getCategories();
		$data['images'] = $this->news_admin_model->getImageNames();
		
		$this->load->view('admin/news_edit',$data);
	}
	
	public function save()
	{
		$form = $this->input->post();
		// önce kontroller yapılsın kısace !
		if ($form['news_id'] == '' OR $form['kategori'] == 0 OR $form['baslik'] == '' OR $form['tarih'] == '' OR $form['foto'] == '' OR $form['icerik'] == '' OR $form['hit'] == '')
		{
			js_alert('Formdan gelen değerler hatalı!');
			js_timeout(base_url('admin/news'));
		} else {
			// verileri hazırla!
			# önce fotoğraf işini hallet!
			if ($form['foto'] == 'default_image')
			{
				$ft = 'news_image_' . $form['kategori'] . '.jpg';
			}
			elseif ($form['foto'] == 'upload_image')
			{
				$form['fotoyukle'] = $_FILES['fotoyukle'];
				if (!isset($form['fotoyukle']) OR $form['fotoyukle']['name'] == '')
				{
					$ft = 'news_image_' . $form['kategori'] . '.jpg';
				} else {
					# fotoğrafı yükle, düzenle ve tanımla!
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = 'news_' . $form['fotoyukle']['name'];
					$config['max_size']	= '0';
					$config['max_width']  = '2560';
					$config['max_height']  = '1920';
					# Resim yüklemeyi aktifleştir!
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('fotoyukle'))
					{
						js_alert($this->upload->display_errors('- ',' -'));
						js_alert('Resim yüklenemediğinden varsayılan resim seçildi!');
						$ft = 'news_image_' . $form['kategori'] . '.jpg';
					}
					else
					{
						//js_alert('resim yüklendi!');
						$file_data = $this->upload->data();
						
						if ($file_data['image_width'] > 600 AND $file_data['image_height'] > 300)
						{
							$crop['image_library'] = 'gd2';
							$crop['source_image'] = $file_data['full_path'];
							$crop['new_image'] = $file_data['full_path'];
							$crop['maintain_ratio'] = false;
							
							$a = $file_data['image_width']%600;
							$b = $file_data['image_height']%300;
							
							$crop['width'] = $file_data['image_width']-$a;
							$crop['height'] = $file_data['image_height']-$b;
							$crop['quality'] = 100;
							$crop['x_axis'] = (int)($a/2);
							$crop['y_axis'] = (int)($b/2);
							
							$this->load->library('image_lib');
							$this->image_lib->initialize($crop);
							$this->image_lib->crop();
							$this->image_lib->clear();
							// kesildi şimdi küçült
							
							$resize['image_library'] = 'gd2';
							$resize['source_image'] = $file_data['full_path'];
							$resize['new_image'] = $file_data['full_path'];
							$resize['maintain_ratio'] = false;
							$resize['width'] = 600;
							$resize['height'] = 300;
							$resize['quality'] = 100;
							$this->image_lib->initialize($resize);
							$this->image_lib->resize();
							$this->image_lib->clear();
							//js_alert('resim küçültüldü');
						}
						
						$ft = $file_data['file_name'];
					}
				}
			} else {
				//js_alert($form['foto']);
				$ft = explode('/',$form['foto']);
				$ft = $ft[1];
			}
			# foto tanımlama bitti!
			#tarihi ayarla
			$tarih = strtotime($form['tarih']);
			
			# başı sonu ayarlar
			$ara = stripos($form['icerik'],'<!-- pagebreak -->');
			if ($ara === false)
			{
				$haber = explode('</p>',$form['icerik']);
			} else {
				$haber = explode('<!-- pagebreak -->',$form['icerik']);	
			}
			
			is_numeric($form['hit']) ? $hit = $form['hit'] : $hit = 1;
			
			
			// verileri ayarlayalım :)
			$veriler = array(
				'category'		=> $form['kategori'],
				'title'			=> $form['baslik'],
				'date'			=> $tarih,
				'picture'		=> $ft,
				'news_intro'	=> editTinyMceChars(str_replace(array('<p>','</p>','<!-- pagebreak -->'),array('','',''),$haber[0])),
				'news_content' 	=> editTinyMceChars(str_replace(array('<p>','</p>','<!-- pagebreak -->'),array('','<br /><br />','<br /><br />'),$form['icerik'])),
				'hit'			=> $hit,
				'active'		=> $form['aktif'],
				'news_writer'	=> $form['facebook_name'],
				'news_writer_facebookid'	=> $form['facebook_id'],
				'news_writer_email'			=> $form['facebook_email']
			);
			
			// news_id == 0 ise kayıt, değil ise güncelleme yapılsın!
			if ($form['news_id'] == 0)
			{
				$sonuc = $this->news_admin_model->save_news($veriler);
			} else {
				$sonuc = $this->news_admin_model->update_news($form['news_id'],$veriler);
			}
			// kayıt veya güncelleme sonu !
			if ($sonuc)
			{
				js_alert('Kayıt/Güncelleme işlemi başarıyla gerçekleştirildi! Yönlendiriliyorsunuz');
				js_timeout(base_url('admin/news'),300);
			} else {
				js_alert('Kayıt/Güncelleme işlemi sırasında bir hata meydana geldi! İşlem başarısız! Yönlendiriliyorsunuz');
				js_timeout(base_url('admin/news'),300);
			}
		}
	}
	
	public function category()
	{
		//print_r($this->input->post());
		$form = $this->input->post();
		if ($this->input->is_ajax_request())
		{
			switch($form['news_cat_do'])
			{
				default:
					echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
				break;
				
				case ('add') :
					$this->db->insert('news_category',array('category_name'=>$form['news_cat_name']));
					$i_id = $this->db->insert_id();
					echo 'Kategori başarıyla eklenmiştir. Lütfen uploads/ klasörünün içerisine news_image_' . $i_id . '.jpg adına 600x300 px boyutlarında bir resim koyunuz!';
				break;
				
				case 'delete' :
					if ($form['slct'] == 0)
					{
						$this->db->delete('news',array('category'=>$form['id']));
						$m = 'Bu kategoriye ait tüm haberler silindi.';
					} else {
						$this->db->where('category',$form['id']);
						$this->db->update('news',array('category'=>$form['slct']));
						$m = 'Bu kategoriye ait haberler belirttiğiniz kategoriye taşındı!';
					}
					
					$this->db->delete('news_category',array('c_id'=>$form['id']));
					echo 'Kategori başarıyla silinmiştir. ' . $m;
				break;
				
				case 'edit' :
					$this->db->where('c_id',$form['news_cat_id']);
					$this->db->update('news_category',array('category_name'=>$form['news_cat_name']));
					echo 'Kategori adı başarıyla düzenlendi!';
				break;
			}
		} else {
			echo 'HACKING ALERT! Fuck YOUR mom and get out here.';
		}
	}
}