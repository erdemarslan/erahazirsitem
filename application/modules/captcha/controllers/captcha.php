<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Captcha Extends MX_Controller
{
	private $img;
	private $fonts;
	private $data;
	private $width = '20';
	
	public function __construct()
	{
		# parent::__construct();
		# Veritabanından ayarları al ve sisteme uyarla!
        //$this->system_model->getSettings();
		if (!function_exists('gd_info')) die('GD Library must load for this Class.');
	}
	
	public function draw()
	{
		$this->draw_captcha();
	}
	
	public function draw_captcha()
	{
		header('Content-Type:image/png');
		// Boyutları belirle :)
		switch ($this->config->item('captcha_level'))
		{
			case 0 :
				$this->data = $this->_word();
			break;
			case 1 :
				$this->data = $this->_math();
			break;
			case 2 :
				$this->data = $this->_book();
			break;
			case 3 :
				$cl = rand(0,2);
				if ($cl == 0)
				{
					$this->data = $this->_word();
				} elseif ($cl == 1)
				{
					$this->data = $this->_book();
				} else {
					$this->data = $this->_math();
				}
			break;
		}
		// Session oluşturalım
		$this->session->set_userdata($this->config->item('captcha_session_name'),$this->data['finish']);
		
		$genislik = ($this->width + (strlen($this->data['enter']) * 12));
		$this->img = imagecreatetruecolor($genislik,$this->config->item('captcha_height'));
		$bgcolor = $this->config->item('captcha_bgcolor');
		$bg = imagecolorallocate($this->img,$bgcolor[0],$bgcolor[1],$bgcolor[2]);
		imagefill($this->img,0,0,$bg);
		$this->write();
		imagepng($this->img);
		imagedestroy($this->img);
		ini_set('session.cache_limiter','private');
	}
	
	private function write()
	{
		$this->getfonts();
		$chars = $this->data['enter'];
		if($this->fonts !== FALSE):
			for($i = 0 ; $i < strlen($this->data['enter']) ; $i++)
			{
				$renkler = $this->config->item('captcha_colors');
				$font 	= rand(0,count($this->fonts)-1);
				$kac_renk  = rand(0,count($renkler)-1);
				$renk  = explode(',',$renkler[$kac_renk]);
				$color  = imagecolorallocate($this->img,$renk[0],$renk[1],$renk[2]);
				imagettftext($this->img, 12, 0, 10 + ($i * 12), 21, $color, $this->config->item('captcha_font_dir') . '/' . $this->fonts[$font] ,$chars[$i]);
			}
		endif;
	}
	
	private function _math()
	{
		$sayi[] = array(0 => 1, 1	=> 'bir');
		$sayi[] = array(0 => 2, 1	=> 'iki');
		$sayi[] = array(0 => 3, 1	=> 'uc');
		$sayi[] = array(0 => 4, 1	=> 'dort');
		$sayi[] = array(0 => 5, 1	=> 'bes');
		$sayi[] = array(0 => 6, 1	=> 'alti');
		$sayi[] = array(0 => 7, 1	=> 'yedi');
		$sayi[] = array(0 => 8, 1	=> 'sekiz');
		$sayi[] = array(0 => 9, 1	=> 'dokuz');
		$sayi[] = array(0 => 10, 1	=> 'on');
		$sayi[] = array(0 => 11, 1	=> 'onbir');
		$sayi[] = array(0 => 12, 1	=> 'oniki');
		$sayi[] = array(0 => 13, 1	=> 'onuc');
		$sayi[] = array(0 => 14, 1	=> 'ondort');
		$sayi[] = array(0 => 15, 1	=> 'onbes');
		$sayi[] = array(0 => 16, 1	=> 'onalti');
		$sayi[] = array(0 => 17, 1	=> 'onyedi');
		$sayi[] = array(0 => 18, 1	=> 'onsekiz');
		$sayi[] = array(0 => 19, 1	=> 'ondokuz');
		$sayi[] = array(0 => 20, 1	=> 'yirmi');
		
		$islem = array('+','-','*');
		
		// Rasgele 2 sayı
		$rand_nums = array_rand($sayi,2); // rasgele iki sayı seç
		$num_1 = $sayi[$rand_nums[0]]; // 1.ci sayı array olarak
		$num_2 = $sayi[$rand_nums[1]]; // 2. sayı array olarak
		// Rasgele işlem
		$rn = rand(0,count($islem)-1); // rasgele işlem seçmece
		if ($this->config->item('word_in_question'))
		{
			$rn1 = rand(0 ,1); // 1.ci sayı için
			$rn2 = rand(0 ,1); // ikinci sayı için
		} else  {
			$rn1 = 0;
			$rn2 = 0;	
		}
		// İşlemleri yap ve gönder :)		
		if ($islem[$rn] == '-')
		{
			if ($num_1[0] > $num_2[0])
			{
				$enter = $num_1[$rn1] . ' - ' . $num_2[$rn2] . ' = ?';
				$finish = $num_1[0] - $num_2[0];
				return array('enter' => $enter, 'finish' => $finish);
			}
			else
			{
				$enter = $num_2[$rn2] . ' - ' . $num_1[$rn1] . ' = ?';
				$finish = $num_2[0] - $num_1[0];
				return array('enter' => $enter, 'finish' => $finish);
			}
		}
		elseif ($islem[$rn] == '*')
		{
			if ($num_1[0] < 11 && $num_2[0] < 11)
			{
				$enter = $num_1[$rn1] . ' x ' . $num_2[$rn2] . ' = ?';
				$finish = $num_1[0] * $num_2[0];
				return array('enter' => $enter, 'finish' => $finish);
			} else {
				$enter = $num_1[$rn1] . ' + ' . $num_2[$rn2] . ' = ?';
				$finish = $num_1[0] + $num_2[0];
				return array('enter' => $enter, 'finish' => $finish);
			}
		}
		else
		{
			$enter = $num_1[$rn1] . ' + ' . $num_2[$rn2] . ' = ?';
			$finish = $num_1[0] + $num_2[0];
			return array('enter' => $enter, 'finish' => $finish);
		}
	}
	
	private function _word()
	{
		//$kac = $this->config->item('captcha_length');
		$key = '';
		$chr = 'abcdefghjkmnprstuxvyz23456789ABCDEFGHJKLPRSTUWXYZ';
		for ($i = 0; $i < $this->config->item('captcha_length'); $i++)
		{
			$key .= $chr[rand(0,(strlen($chr)-1))];
		}
		
		return array(
			'enter' => $key,
			'finish' => $key
			);
	}
	
	private function _book()
	{
		$words = array('you','going','believe','story','sit','writing','grew','morning','tomorrow','kind','loving','spent','most','animals','cats','gold','fish','large','small','wife','wolf','follow','behind','years','changing','horrible','stay','often','what','pain','mind','ugly','pocket','drink','ayran','pilav','suddenly','servant','burned','plaster','black','white','crowd','object','orient','suprised','machine','fear','cellar','calculator','axe','kill','life','love','line','oval','egaeus','berenice','have','child','chili','hot','papper','already','middle','cousin','thousand','billion','millionare','deep','small','big','near','talking','android','ill','heart','fall','slow','fast','burn','dark','light','modern','war','fare','call','duty','medal','honor','sixty','people','city','ghost','town','table','box','drop','purple','violet','negro','aqua','favour','mask','stop','anyone','plague','noone','moose','eagle','lion','leopard','fart','part','cart','house','party','liar','forest','tree','three','there','chose','mouse','red','death','outside','inside','quick','again','sound','voodoo','lag','fix','face','noise','mouth','laugh','sad','smile','familar','noun','verb','font','gets','function','class','read','list','while','each','random','woman','man','winston','churcill','interface','laser','plane','bus','car','taxi','airport','train','choco','jumbo','shark','elephant','square','pants','sponge','jill','puss','boots','jack','william','lopez','penguin','level','must','drive','cash','carry','array','fund', 'bitch', 'beach', 'party', 'paul', 'medical', 'park', 'istanbul', 'ankara', 'washington', 'portakal', 'frutti', 'lazer', 'laser', 'haber', 'samsung', 'philips', 'motorola', 'nikon', 'canon', 'display', 'cellphone,', 'carefull!', 'lira.');
		
		$hola = array_rand($words,2);
		return array(
			'enter' => $words[$hola[0]] . "  " . $words[$hola[1]],
			'finish' => $words[$hola[0]] . " " . $words[$hola[1]]
		);
	}
	
	private function getfonts()
	{
		$read = opendir($this->config->item('captcha_font_dir'));
		if($read)
		{
			while($list = readdir($read))
			{
				if($list != '.' && $list != '..' && preg_match('/(.ttf)$/',$list))
				{
					$this->fonts[] = $list;
				}
			}
			return $this->fonts;
		}
		else
		{
			return false;
		}
		
	}
}