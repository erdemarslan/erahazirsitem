<?php
if (!defined('START')) die('Hacking attempt! Please close this page.');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/admin2.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function kategori_kontrol()
	{
		if (document.kategori.deger.value == '')
		{
			alert('Form değeri boş bırakılamaz!');
			return false;
		} else {
			return true;
		}
	}
</script>
</head>

<body bgcolor="#efefef"><table width="96%" align="center" border="0" cellpadding="5" cellspacing="0">
<tbody>
<tr>
<td class="text" valign="top" width="150" nowrap="nowrap"><table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">
<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody>
	<tr>
		<td class="text"><b>Yönetim Merkezi</b><br><br>
            <table border="0" cellpadding="0" cellspacing="0">
                <tbody>
                	<?php
					foreach ($menuler as $key => $value)
					{
					?>
                    <tr>
                        <td valign="top" width="14"><img src="images/arrow.gif" alt="" width="8" height="14"></td>
                        <td class="text"><a href="<?php echo $value; ?>"><?php echo $key; ?></a></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <tr>
                		<td valign="top" width="14"><img src="<?php echo admin('arrow.gif','image',true); ?>" alt="" width="8" height="14"></td>
                		<td class="text"><a href="<?php echo base_url('home'); ?>" target="_blank">Site Anasayfasına Git</td>
               		</tr>   
                    
                    </table>
				</td>
			</tr>
		
	</table>
</td>
</tr>
</table>
</td><td valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">
<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody><tr>
<td class="text">
<span class="text"><b>Sayın <?php echo $kisi; ?> Hoşgeldiniz!</b></span><br>
<br>

  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tbody>
    
    <tr> 
      <td class="tablehl" colspan="2" bgcolor="#58838b">Kategori Ekle:</td>
    </tr>
    
    <form name="kategori" method="post" onsubmit="return kategori_kontrol()" action="<?php echo $kategori_ekle; ?>">
    <tr> 
      <td class="text" width="28%" bgcolor="#dee6e8"> 
        Kategori Ekle:<br> </td>
      <td class="text" width="72%" bgcolor="#dee6e8">
      	<input name="deger" type="text" id="kategori">
      	<input class="button" name="submit" value="Ekle" type="submit"> 
      </td>
    </tr>
    </form>
  </table>  <br>
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tbody>
    
    <tr> 
      <td class="tablehl" colspan="3" bgcolor="#58838b">Kategoriler</td>
    </tr>
    
    <tr> 
      <td width="9%" bgcolor="#dee6e8" class="text"><div align="center"><strong> 
        Kategori ID<br> 
      </strong></div></td>
      <td width="55%" bgcolor="#dee6e8" class="text"><strong>Kategori Adı</strong></td>
      <td width="36%" bgcolor="#dee6e8" class="text"><strong>İşlemler</strong></td>
    </tr>
    <?php
	foreach ($kategoriler as $k)
	{
	?>
    <tr>
      <td class="text" bgcolor="#dee6e8"><div align="center"><?php echo $k->c_id; ?></div></td>
      <td class="text" bgcolor="#dee6e8"><?php echo $k->c_name; ?></td>
      <td class="text" bgcolor="#dee6e8">[<a href="<?php echo $sil_url . $k->c_id; ?>" onclick="return confirm('Bu kategori silinecek onaylıyor musunuz?')">Sil</a>]</td>
    </tr>
    <?php
	}
	?>

  </table>
  <br />
  
  </td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
<img src="images/blank.gif" alt="" width="10" border="0" height="8"><br>
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">
<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody><tr>
<td class="text">

<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr>
    <td class="text" width="33%" align="center" nowrap="nowrap">This version: <?php echo VERSION; ?></td>
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
  <span class="copyright">Era Smile :) 2011</span><br>
</center></td></tr></tbody></table><p>&nbsp;</p></body></html>