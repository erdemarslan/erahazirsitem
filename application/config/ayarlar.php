<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Captcha ayarları
$config['captcha_font_dir']			= './application/modules/captcha/fonts';
$config['captcha_bgcolor']			= array(255,255,255);
$config['captcha_colors']			= array("201,32,32","121,142,224","99,97,98","136,43,87","227,0,113","0,0,0");
$config['captcha_height']			= 30;
$config['captcha_level']			= 3;
$config['captcha_length']			= 7;
$config['captcha_session_name']		= 'era_captcha';
$config['captcha_word_in_question']	= true;
$config['captcha_width']			= 20;



// Gmail Ayarları
$config['gmail']['protocol']		= "smtp";
$config['gmail']['smtp_host']		= "smtp.gmail.com";
$config['gmail']['smtp_port']		= 587;
$config['gmail']['smtp_timeout']	= 30;
$config['gmail']['charset']			= "utf-8";
$config['gmail']['newline']			= "\r\n";
$config['gmail']['mailtype']		= "html";
$config['gmail']['validation']		= true;
$config['gmail']['smtp_crypto'] 	= "tls";




// Tinymce Resim Yükleme eklentisi için resim ayarları
$config['allowed_types'] = 'gif|jpg|png';
$config['max_size'] = 0;
$config['max_width'] = 0;
$config['max_height'] = 0;
$config['allow_resize'] = TRUE;
$config['encrypt_name'] = FALSE;
$config['overwrite'] = FALSE;
$config['upload_path'] = UPLOADPATH;
$config['datetime_name'] = TRUE;


?>