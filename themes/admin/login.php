<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Era System Admin Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function do_control()
	{
		var isim = document.login.username.value;
		var sifre = document.login.password.value;
		var guvenlik = document.login.security.value;
		
		if (isim == '')
		{
			alert('Kullanıcı adınızı boş bırakamazsınız!');
			return false;
		} else if (sifre == '') {
			alert('Şifrenizi boş bırakamazsınız!');
			return false;
		} else if (guvenlik == '') {
			alert('Güvenlik kodunu boş bırakamazsınız!');
			return false;
		} else {
			return true;
		}
	}
</script>
</head>
<body bgcolor="#efefef">

<br>
<table align="center" border="0" cellpadding="0" cellspacing="1" width="1%">
<tbody><tr>
<td bgcolor="#bccdd1">
<table border="0" cellpadding="15" cellspacing="1" width="100%">
<tbody><tr>
<td class="text" bgcolor="#ffffff">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
         <td class="headline">Hoşgeldiniz!</td>
         <td class="text" align="right"></td>
    </tr>
    </tbody></table>
<br>
<div>
<img src="<?php echo admin('login.png','image',true); ?>" alt="Login" style="float: left; padding: 4px 5px;" height="48" width="48">
Lütfen bilgilerinizi eksiksiz ve tam doldurunuz.<br /><br /></div>
<br>
<?php echo validation_errors(); ?>
<br />

<span class="headline"><b>Giriş Bilgileri</b></span><br>
<form name="login" id="login" action="" onsubmit="return do_control()" method="post">

<table border="0" cellpadding="2" cellspacing="1">
<tbody><tr>
<td class="text" bgcolor="#efefef">Kullanıcı Adı:</td>
<td bgcolor="#efefef"><input name="username" id="username" type="text"></td>
</tr>
<tr>
<td class="text" bgcolor="#efefef">Şifre:</td>
<td bgcolor="#efefef"><input name="password" id="password" type="password"></td>
</tr>
<tr>
<td class="text" colspan="2" bgcolor="#efefef"><div align="center"><img src="<?php echo base_url('captcha/draw_captcha'); ?>"  /></div></td>
</tr>
<tr>
<td colspan="2"><br>
  <span class="text">Yukarıdaki güvenlik kodu:</span><br>
<input style="text-align:center" name="security" size="50" type="text" id="security"></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input name="Submit" value="Giriş Yap" type="submit"></div></td>
</tr>
</tbody></table>
</form>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>

<center>
<span class="copyright">
Era System <?php echo date('Y'); ?> | Erdem ARSLAN</span>
<br>
</center>
<p>&nbsp;</p>
</body></html>