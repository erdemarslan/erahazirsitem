<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript">

function save_admin_password()
{
	var k = $('#admin_password_user').val();
	var s = $('#admin_password_pass_cur').val();
	var ys = $('#admin_password_pass_new').val();
	var yst = $('#admin_password_pass_re').val();
	
	if (k == '')
	{
		alert('Kullanıcı adı boş bırakılamaz!');
	}
	else if (s == '')
	{
		alert('Geçerli şifrenizi yazmadan kayıt yapamazsınız!');
	}
	else if (ys == '')
	{
		alert('Lütfen yeni şifrenizi yazınız!');
	}
	else if (yst == '')
	{
		alert('Lütfen yeni şifrenizi tekrar yazınız!');
	}
	else if (ys != yst)
	{
		alert('Şifre ile şifre tekrarı birbirinle uyuşmuyor. Lütfen düzeltiniz!');
	} else {
		var form_data = $('form#admin_password').serialize();
		$.ajax({
			type: "POST",
			url: "/admin/save_settings",
			data: form_data,
			success: function(msg)
			{
				if (msg=="ok")
				{
					alert('Bilgileriniz başarıyla değiştirildi. Güvenlik amacıyla çıkışa yönlendiriliyorsunuz. Lütfen tekrar giriş yapınız!');
					setTimeout(window.location="/admin/logout",300);
				}
				else
				{
					alert(msg);
				}
			}
		}); // ajax bitti
	}
}

function save_general_settings()
{
	var s = $('#admin_password_pass_cur').val();
	if (s != '')
	{
		var form_data = $('form#general_setting').serialize();
		$.ajax({
			type: "POST",
			url: "/admin/save_settings",
			data: form_data + '&pass=' + s,
			success: function(msg)
			{
				if (msg=="ok")
				{
					alert('Bilgileriniz başarıyla değiştirildi. Sayfa yenileniyor. Lütfen bekleyiniz!');
					setTimeout("location.reload(true);",500);
				}
				else
				{
					alert(msg);
				}
			}
		}); // ajax bitti
	} else {
		alert('Geçerli şifrenizi yazmadan kayıt yapamazsınız!');
	}
}

function save_other_settings()
{
	var s = $('#admin_password_pass_cur').val();
	if (s != '')
	{
		var form_data = $('form#other_setting').serialize();
		$.ajax({
			type: "POST",
			url: "/admin/save_settings",
			data: form_data + '&pass=' + s,
			success: function(msg)
			{
				if (msg=="ok")
				{
					alert('Bilgileriniz başarıyla değiştirildi. Sayfa yenileniyor. Lütfen bekleyiniz!');
					setTimeout("location.reload(true);",500);
				}
				else
				{
					alert(msg);
				}
			}
		}); // ajax bitti
	} else {
		alert('Geçerli şifrenizi yazmadan kayıt yapamazsınız!');
	}
}


</script>
</head>

<body bgcolor="#efefef"><table width="96%" align="center" border="0" cellpadding="5" cellspacing="0">
<tbody>
<tr>
<td class="text" valign="top" width="179" nowrap="nowrap"><table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">
<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody>
	<tr>
		<td class="text"><b>Yönetim Merkezi</b><br><br>
            <table border="0" cellpadding="0" cellspacing="0">
                <tbody>
                
                <?php
				foreach ($menuler as $k=>$v)
				{
					echo '<tr>
                        <td valign="top" width="14"><img src="' . admin('arrow.gif','image',true) . '" alt="" width="8" height="14"></td>
                        <td class="text"><a href="' . base_url($v) . '">' . $k . '</td>
                    </tr>';
				}
				?>
                	
                    

             </table>
				</td>
			</tr>
		
	</table>
</td>
</tr>
</table>
</td><td width="759" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">

<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody><tr>
<td class="text">
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br></p>
  
  <br />

<form name="admin_password" id="admin_password">
<input type="hidden" name="what_i_do" id="what_i_do" value="user_pass" />
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="4" bgcolor="#58838b">Kullanıcı Adı ve Şifre Ayarları</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Kullanıcı Adınız</td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><input name="admin_password_user" id="admin_password_user" type="text" size="60" value="<?php echo $this->config->item('admin_username'); ?>" /></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Şuanki Şifreniz</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="admin_password_pass_cur" id="admin_password_pass_cur" type="password" size="60" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* herhangi bir ayarı kaydederken mutlaka yazmanız gerekir.</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Yeni Şifreniz</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="admin_password_pass_new" id="admin_password_pass_new" type="password" size="60" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Yeni Şifreniz Tekrar</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="admin_password_pass_re" id="admin_password_pass_re" type="password" size="60" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input onclick="save_admin_password()" name="admin_password_button" id="admin_password_button" type="button" value="Kaydet" /></td>
  </tr>
  
</tbody></table>
</form>
  <br />

<form name="general_setting" id="general_setting">
<input type="hidden" name="what_i_do" id="what_i_do" value="general_setting" />
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="4" bgcolor="#58838b">Site Ayarları</td>
  </tr>
  <tr>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8">Site Başlığı</td>
    <td class="text" valign="top" width="45%" bgcolor="#dee6e8"><input name="site_title" id="site_title" type="text" size="60" value="<?php echo $this->config->item('site_title'); ?>" /></td>
    <td class="text" valign="top" width="30%" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Site Açıklaması</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_desc" id="site_desc" type="text" size="60" value="<?php echo $this->config->item('site_desc'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Anahtar Kelimeler</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_keywords" id="site_keywords" type="text" size="60" value="<?php echo $this->config->item('site_keywords'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* her bir kelimeyi virgülle ayırınız.</td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Site Sloganı</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_slogan" id="site_slogan" type="text" size="60" value="<?php echo $this->config->item('site_slogan'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Telif  Hakkı Yazısı</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_copyright" id="site_copyright" type="text" size="60" value="<?php echo $this->config->item('site_copyright'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Site İletişim Emaili</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_contact_mail" id="site_contact_mail" type="text" size="60" value="<?php echo $this->config->item('site_contact_mail'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Site Teması</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><?php echo getThemes($this->config->item('current_theme')); ?></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Tema Logos</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="theme_logo" id="theme_logo" type="text" size="60" value="<?php echo $this->config->item('theme_logo'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* mutlaka bir web adresi olmalıdır.</td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input onclick="save_general_settings()" name="g_set_button" id="g_set_button" type="button" value="Kaydet" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
</tbody></table>
</form>
  <br />


<form name="other_setting" id="other_setting">
<input type="hidden" name="what_i_do" id="what_i_do" value="other_setting" />
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="3" bgcolor="#58838b">Ek Ayarlar</td>
  </tr>
  <tr>
    <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Gmail SMTP Kullanıcı Adı</td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><input name="gmail_smtp_user" id="gmail_smtp_user" type="text" size="60" value="<?php echo $this->config->item('gmail_smtp_user'); ?>" /></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8">* gmail üzerinden sorunsuz mail göndermek için gerekli</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Gmail SMTP Şifre</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="gmail_smtp_pass" id="gmail_smtp_pass" type="text" size="60" value="<?php echo $this->config->item('gmail_smtp_pass'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Facebook API ID (Login)</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_facebook_appid" id="site_facebook_appid" type="text" size="60" value="<?php echo $this->config->item('site_facebook_appid'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* Üye giriş çıkışları için gerekli Facebook API ID numarası</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Facebook API SECRET (Login)</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="site_facebook_secret" id="site_facebook_secret" type="text" size="60" value="<?php echo $this->config->item('site_facebook_secret'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* Üyelik API'si için gerekli SECRET ID</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Facebook API ID (F. Galerisi)</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="gallery_facebook_appid" id="gallery_facebook_appid" type="text" size="60" value="<?php echo $this->config->item('gallery_facebook_appid'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* Fotoğraf galerisi için Facebook API ID</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Facebook API SECRET (F. Galerisi)</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="gallery_facebook_secret" id="gallery_facebook_secret" type="text" size="60" value="<?php echo $this->config->item('gallery_facebook_secret'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Namaz Vakitleri Gösterilsin mi?</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><select name="prayer_active" id="prayer_active"><?php
    	if ($this->config->item('prayer_active') == 1)
		{
			echo '<option value="1" selected="selected">Evet</option>';
			echo '<option value="0">Hayır</option>';
		} else {
			echo '<option value="1">Evet</option>';
			echo '<option value="0" selected="selected">Hayır</option>';
		}
		
		 ?></select></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Namaz Vakitleri Ülke</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="prayer_country" id="prayer_country" type="text" size="60" value="<?php echo $this->config->item('prayer_country'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* büyük harfle ve TR karakter içermeden.</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Namaz Vakitleri Şehir</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="prayer_location" id="prayer_location" type="text" size="60" value="<?php echo $this->config->item('prayer_location'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* büyük harfle ve TR karakter içermeden.</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Hava Durumu Gösterilsin mi?</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><select name="weather_active" id="weather_active"><?php
    	if ($this->config->item('weather_active') == 1)
		{
			echo '<option value="1" selected="selected">Evet</option>';
			echo '<option value="0">Hayır</option>';
		} else {
			echo '<option value="1">Evet</option>';
			echo '<option value="0" selected="selected">Hayır</option>';
		}
		
		 ?></select></td>
    <td class="text" valign="top" bgcolor="#dee6e8">&nbsp;</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8">Hava Durumu Şehir</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input name="weather_location" id="weather_location" type="text" size="60" value="<?php echo $this->config->item('weather_location'); ?>" /></td>
    <td class="text" valign="top" bgcolor="#dee6e8">* şehir kodları MSN.com dan alınmalıdır.</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"></td>
    <td class="text" valign="top" bgcolor="#dee6e8"><input onclick="save_other_settings()" name="other_setting_button" id="other_setting_button" type="button" value="Kaydet" /></td>
  </tr>
  
</tbody></table>
</form>
<br />
  
  

  
  </td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
<br>
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">
<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody><tr>
<td class="text">

<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr>
    <td class="text" width="33%" align="center" nowrap="nowrap">Era System <?php echo $update['version']; ?> | <?php
    if ($update['status'] == 'error')
	{
		echo '<font color="#FF1A00">' . $update['info'] . '</font> <strong>[<a href="' . base_url("yonetim/guncelle") . '">Güncellemeyi Uygula</a>]</strong>';
	} else {
		echo '<font color="#008C00">' . $update['info'] . '</font>';
	}
	?></td>
  </tr>
</tbody></table>

 </td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
<!-- Copyright Information -->

<br><center>
  <span class="copyright">Era System <?php echo $update['version']; ?> | Erdem Arslan</span><br>
</center></td></tr></tbody></table></body></html>