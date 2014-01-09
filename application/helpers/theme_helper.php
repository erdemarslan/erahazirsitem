<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Tema Seçici
function theme($file='',$type='load',$url=false)
{
	$CI =& get_instance();
	
	switch($type)
	{
		case ('base') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_main_folder'));
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . $CI->config->item('theme_main_folder');
			}
			elseif ($file !='' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_main_folder') . $file);
			}
			else
			{
				return THEMEPATH . $CI->config->item('theme_main_folder') . $file;
			}
		break;
		
		case ('css') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_css_folder'));
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . $CI->config->item('theme_css_folder');
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_css_folder') . $file);
			}
			else
			{
				return THEMEPATH . $CI->config->item('theme_css_folder') . $file;
			}
		break;
		
		case ('image') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_img_folder'));
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . $CI->config->item('theme_img_folder');
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_img_folder') . $file);
			}
			else
			{
				return THEMEPATH . $CI->config->item('theme_img_folder') . $file;
			}
		break;
		
		case ('js') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_js_folder'));
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . $CI->config->item('theme_js_folder');
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . $CI->config->item('theme_js_folder') . $file);
			}
			else
			{
				return THEMEPATH . $CI->config->item('theme_js_folder') . $file;
			}
		break;
		
		case ('load') :
			return $CI->config->item('theme_main_folder') . $file;
		break;
		
	}
}// Tema seçici sonu =)

function uploaded($file='',$url=true)
{
    $CI =& get_instance();
    
    if ($file == '')
    {
        if ($url)
        {
            return base_url(UPLOADPATH);
        } else {
            return UPLOADPATH;
        }
    } else {
        if ($url)
        {
            return base_url(UPLOADPATH . $file);
        } else {
            return UPLOADPATH . $file;
        }
    }
}

# Admin fonksiyonu aynı theme() gibi
function admin($file='',$type='load',$url=false)
{
	$CI =& get_instance();
	
	switch($type)
	{
		case ('base') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . 'admin/');
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . 'admin/';
			}
			elseif ($file !='' && $url)
			{
				return base_url(THEMEPATH . 'admin/' . $file);
			}
			else
			{
				return THEMEPATH . 'admin/' . $file;
			}
		break;
		
		case ('css') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . 'admin/css/');
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . 'admin/css/';
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . 'admin/css/' . $file);
			}
			else
			{
				return THEMEPATH . 'admin/css/' . $file;
			}
		break;
		
		case ('image') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . 'admin/images/');
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . 'admin/images/';
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . 'admin/images/' . $file);
			}
			else
			{
				return THEMEPATH . 'admin/images/' . $file;
			}
		break;
		
		case ('js') :
			if ($file == '' && $url)
			{
				return base_url(THEMEPATH . 'admin/js/');
			}
			elseif ($file == '' && !$url)
			{
				return THEMEPATH . 'admin/js/';
			}
			elseif ($file != '' && $url)
			{
				return base_url(THEMEPATH . 'admin/js/' . $file);
			}
			else
			{
				return THEMEPATH . 'admin/js/' . $file;
			}
		break;
		
		case ('load') :
			return 'admin/' . $file;
		break;
		
	}
}// admin sonu =)

function getThemes($current)
{
	$CI =& get_instance();
	$dizin = THEMEPATH;
	$islem = @opendir($dizin) or die('Tema klasörü okunamıyor!');
	$olasi_dosyalar = array();
	while ($klasor = readdir($islem))
	{
		if (is_dir($dizin . '/' . $klasor) AND ($klasor != "..") AND ($klasor != ".") AND ($klasor != "admin"))
		{
			$olasi_dosyalar[] = $klasor;
		}
	}
	closedir($islem);
	
	$r = '<select name="current_theme" id="current_theme">';
	
	foreach ($olasi_dosyalar as $od)
	{
		if (is_file($dizin . '/' . $od . '/' . $od . '.xml') AND is_readable($dizin . '/' . $od . '/' . $od . '.xml'))
		{
			if ($od == $current)
			{
				$r .= '<option value="' . $od . '" selected="selected">' . $od .  '</option>';
			} else {
				$r .= '<option value="' . $od . '">' . $od .  '</option>';
			}
		}
	}
	
	$r .= '</select>';
	
	return $r;
	//print_r($olasi_dosyalar);
}

function version()
{
	return 'v.2';
}

function prep_meta_desc($data)
{
	$CI =& get_instance();
	preg_match_all('/<img(.*)\/>/i', $data, $matches);
	foreach ($matches as $m)
	{
		$data = str_replace($m,'',$data);
	} 
	
	$search = array('<p>','</p>','<br>', '<br />', '<img', 'src=', 'width=', 'height=','"','px', 'rel=', 'lightbox', '<strong>','</strong>', 'alt=', '/>', '<', '>', '.', ',', ':', ';', '-', '  ', '(', ')', '[', ']',"\r\n","\n\r");
	$replace = array('','','','','','','','','','','','','','','','','','','','','','','',' ',"\n\r","\n\r",'','',"\n\r",'');
	$data = str_replace($search,$replace,$data);
	
	$veri = explode('. ',$data);
	return $veri[0] . '.';
}

function prep_meta_keyword($data)
{
	$CI =& get_instance();
	preg_match_all('/<img(.*)\/>/i', $data, $matches);
	foreach ($matches as $m)
	{
		$data = str_replace($m,'',$data);
	} 
	
	$search = array('<p>','</p>','<br>', '<br />', '<img', 'src=', 'width=', 'height=','"','px', 'rel=', 'lightbox', '<strong>','</strong>', 'alt=', '/>', '<', '>', '.', ',', ':', ';', '-', '  ', '(', ')', '[', ']',"\r\n","\n\r");
	$replace = array('','','','','','','','','','','','','','','','','','','','','','','',' ',"\n\r","\n\r",'','',"\n\r",'');
	$data = str_replace($search,$replace,$data);
	
	$r = array();
	$veri = explode(' ',$data);
	foreach ($veri as $v)
	{
		if (count($r) < 100)
		{
			$r[low_all($v)] = low_all($v);
		}
	}
	
	$return = '';
	foreach ($r as $t)
	{
		$return .= $t . ', ';
	}
	
	return $return;
}


function calc_time($int)
{
	/*
	 * 60 saniyeden büyükse -> dakika
	 * 3600 saniyeden büyükse -> saat olacak
	 * öncesi saniye
	 *
	 */
	 
	 if ($int < 60)
	 {
		 $r = $int . ' saniye';
	 }
	 elseif ($int > 59 && $int < 3600)
	 {
		$a = floor($int/60);
		$b = ($int - ($a*60));
		$r = $a . ' dakika ' . $b . ' saniye';
	 } else {
		 $c = floor($int/3600);
		 $d = ($int - ($c*3600));
		 $e = floor($d/60);
		 $f = ($d - ($e*60));
		 $r = $c . ' saat ' . $e . ' dakika ' . $f . ' saniye';
	 }
	 
	 return $r;
}