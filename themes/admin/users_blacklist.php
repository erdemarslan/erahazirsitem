<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript">

function ban_ip()
{
	var ip = $('#ipban_ip').val();
	var p = $('#ipban_time').val();
	$.ajax({
		type: "POST",
		url: "/admin/users/ban",
		data: 'ip=' + ip + '&v=' + p,
		success: function(msg)
		{
			alert(msg);
			setTimeout("location.reload(true);",500);
		}
	}); // ajax bitti
}

function edit_ban(ip)
{
	$('#ipban_ip').val(ip);
	$('#ipban_time').val(0);
	$('#ipban_button').val('Düzenle');
	alert('Bilgiler yukarıdaki forma aktarılmıştır. Lütfen form üzerinden devam ediniz!');
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
</td><td width="759" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="0">
<tbody><tr>
<td bgcolor="#bccdd1">

<table width="100%" align="center" bgcolor="#ffffff" border="0" cellpadding="15" cellspacing="0">
<tbody><tr>
<td class="text">
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br></p>
  
  <form name="ipban" id="ipban">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="4" bgcolor="#58838b">IP Engelle:</td>
  </tr>
  
  <tr>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8">IP Adresi</td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8"><input name="ipban_ip" id="ipban_ip" type="text" /></td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8">Ne kadar engellensin? <select name="ipban_time" id="ipban_time">
    	<option value="0">Sonsuza Kadar</option>
        <option value="1">1 Gün</option>
        <option value="3">3 Gün</option>
        <option value="7">1 Hafta</option>
        <option value="30">1 Ay</option>
        <option value="90">3 AY</option>
        <option value="180">6 Ay</option>
        <option value="365">1 Yıl</option>
    </select></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><input name="ipban_button" onclick="ban_ip()" id="ipban_button" type="button" value="Ekle" /></td>
  </tr>
  </tbody>
</table>
</form>  
  <br />
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="4" bgcolor="#58838b">Kategoriler:</td>
  </tr>
  <tr>
    <td class="text" valign="top" width="5%" bgcolor="#dee6e8"><strong>ID</strong></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><strong>IP Adresi</strong></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><strong>Engellenme Süresi</strong></td>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8"><strong>İşlemler</strong></td>
  </tr>
  <?php
  	if (count($blacklist) > 0)
	{
		foreach ($blacklist as $b)
		{
			$b['time'] == 0 ? $z = 'Sonsuza kadar' : $z = date('d.m.Y H:i:s', $b['time']) . ' tarihine kadar'; 
			echo '<tr>
    <td class="text" valign="top" width="5%" bgcolor="#dee6e8">' . $b['id'] . '</td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8">' . $b['ip'] . '</td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8">' . $z . '</td>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8">[<a style="cursor:pointer;" onclick="edit_ban(\'' . $b['ip'] . '\')">Düzenle</a>] [<a href="' . base_url('admin/users/blacklist_delete/' . $b['id']) . '" onclick="return confirm(\'Bu kaydı silmek istediğinizden emin misiniz?\')">Sil</a>]</td>
  </tr>';
		}
	}
  ?>
  
</tbody></table>

  
  </td>
</tr>
</table>
</td>
</tr>
</table>
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