<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Javascript alert verdirmek için :)
function js_alert($msg)
{
	echo '
	<script type="text/javascript">
	alert("' . $msg . '");
	</script>
	';
}

// Javasccript timeout ile sayfa yönlendirmek için :)
function js_timeout($sayfa,$saniye=3)
{
	$milisaniye = $saniye * 1000;
	echo '
	<script type="text/javascript">
		setTimeout(window.location="' . $sayfa . '",' . $milisaniye .');
	</script>
	';
}

#### -------------------------------------------------------------------------------- ####

# Rasgele Karakterler - Herşey için lazım
function random_chars($how=5)
{
	$chr = 'abcdefghjkmnprstuxvyz23456789ABCDEFGHJKLMNPRSTUWXYZ';
	$key = '';
	for($i = 0 ; $i < $how; $i++)
	{
		$key .= $chr[rand(0,strlen($chr)-1)];
	}
	return $key;
}

// hepsini küçült
function low_all($data)
{
	mb_internal_encoding("UTF-8");
	
	$find 		= array("Q","W","E","R","T","Y","U","I","O","P","Ğ","Ü","A","S","D","F","G","H","J","K","L","Ş","İ","Z","X","C","V","B","N","M","Ö","Ç");
	$replace	= array("q","w","e","r","t","y","u","ı","o","p","ğ","ü","a","s","d","f","g","h","j","k","l","ş","i","z","x","c","v","b","n","m","ö","ç");
	return str_replace($find,$replace,$data);
}

// hepsini büyüt
function big_all($data)
{
	mb_internal_encoding("UTF-8");
	
	$replace	= array("Q","W","E","R","T","Y","U","I","O","P","Ğ","Ü","A","S","D","F","G","H","J","K","L","Ş","İ","Z","X","C","V","B","N","M","Ö","Ç");
	$find		= array("q","w","e","r","t","y","u","ı","o","p","ğ","ü","a","s","d","f","g","h","j","k","l","ş","i","z","x","c","v","b","n","m","ö","ç");
	return str_replace($find,$replace,$data);
}

// ilk harfi büyüt
// iki çalışma türü var
// bir cümledeki sadece ilk harfi ki o zaman $all=false olması gerekir
// bir cümledeki bütün kelimeleri $all=true olması gerekir
// cümledeki ayıraç değiştirilebilir standart olarak " " var. istenilirse değiştirilebilir :)
function big_one($data,$all=true,$separator=' ')
{
	mb_internal_encoding("UTF-8");
	
	if ($all) {
		$newdatas	= explode($separator,$data);
		$howword	= count($newdatas);
		$words		= '';
		
		foreach ($newdatas as $nd)
		{
			$number = 1;
			$nd = trim($nd);
			$first	= mb_substr($nd,0,1);
			$others	= mb_substr($nd,1);
			if ($number == $howword)
			{
				$separator = '';
			} else {
				$separator = $separator;
			}
			$number++;
			$words	.= big_all($first).low_all($others).$separator;		
		}
		
		return $words;
	} else {
		$first	= mb_substr($data,0,1);
		$others	= mb_substr($data,1);
		$newword = big_all($first).low_all($others);
		return $newword;
	}
}

function no_tr($tr1)
{ 
$turkce=array("ş","Ş","ı","(",")","'","ü","Ü","ö","Ö","ç","Ç"," ","/","*","?","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü"); 
$duzgun=array("s","S","i","","","","u","U","o","O","c","C","-","-","-","","s","S","i","g","G","I","o","O","C","c","u","U"); 
$tr1=str_replace($turkce,$duzgun,$tr1); 
$tr1 = preg_replace("@[^A-Za-z0-9-_.#]+@i","",$tr1); 
return $tr1; 
}

function gravatar($photo='empty',$email='any_email@email.com')
{
	if ($photo == 'empty')
	{
		return $resim = 'http://www.gravatar.com/avatar/' . md5($email) . '?s=50&r=g&d=mm';
	} else {
		return $photo;
	}
	
}

function guestbook_date_webpage($date,$webpage)
{
	$d = date('d.m.Y H:i:s',$date);
	if ($webpage != 'empty')
	{
		$w = ' | Web Sitesi: <a href="http://' . $webpage . '" target="_blank" rel="nofollow">' . $webpage . '</a>';
	} else {
		$w = '';
	}
	return $d . $w;
}

function isURL($url)
{
	return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) ? FALSE : TRUE;
}


function guestbookAgent($data)
{
	$d = explode('|',$data);
	$ip = explode('.',trim($d[2]));
	$ip = $ip[0] . '.' . $ip[1] . '.' . $ip[2] . '.xxx';
	return $d[0] . ' | ' . $d[1] . ' | ' . $ip . ' | ' . $d[3];
}

function newsDate($date=0,$saat=true,$saniye=false)
{
	$gun = date('d',$date);
	$ay = date('n',$date);
	$yil = date('Y',$date);
	$haftanin_gunu = date('w', $date);
	$saatli = date('H:i',$date);
	$saniyeli = date('H:i:s', $date);
	
	switch($ay)
	{
		case 1: $ay_e = 'Ocak'; break;
		case 2: $ay_e = 'Şubat'; break;
		case 3: $ay_e = 'Mart'; break;
		case 4: $ay_e = 'Nisan'; break;
		case 5: $ay_e = 'Mayıs'; break;
		case 6: $ay_e = 'Haziran'; break;
		case 7: $ay_e = 'Temmuz'; break;
		case 8: $ay_e = 'Ağustos'; break;
		case 9: $ay_e = 'Eylül'; break;
		case 10: $ay_e = 'Ekim'; break;
		case 11: $ay_e = 'Kasım'; break;
		case 12: $ay_e = 'Aralık'; break;
	}
	
	switch($haftanin_gunu)
	{
		case 0: $hg = 'Pazar'; break;
		case 1: $hg = 'Pazartesi'; break;
		case 2: $hg = 'Salı'; break;
		case 3: $hg = 'Çarşamba'; break;
		case 4: $hg = 'Perşembe'; break;
		case 5: $hg = 'Cuma'; break;
		case 6: $hg = 'Cumartesi'; break;
	}
	
	if ($saat)
	{
		if ($saniye)
		{
			return "$gun $ay_e $yil $hg $saniyeli";
		} else {
			return "$gun $ay_e $yil $hg $saatli";
		}
	} else {
		return "$gun $ay_e $yil $hg";
	}
	
	
}

function editTinyMceChars($data)
{
	$s = array('&uuml;','&ouml;','&ccedil;','&Uuml;','&Ouml;','&Ccedil;');
	$r = array('ü','ö','ç','Ü','Ö','Ç');
	$data = str_replace($s,$r,$data);
	return $data;
}