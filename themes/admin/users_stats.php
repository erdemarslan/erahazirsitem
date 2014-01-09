<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript">
function listElements()
{
	var order = $('#list1').val();
	var by = $('#list2').val();
	
	setTimeout(window.location="<?php echo base_url('admin/users/stats/1'); ?>/" + order + "/" + by,100);
}

function ban_ip(ip)
{
	var c = confirm('Bu IP Adresini engellemek istediğinizden emin misiniz?');
	if (c)
	{
		var p = prompt('Bu IP adresini kaç gün engellemek istiyorsunuz? Sonsuz için 0 giriniz.',0);
		$.ajax({
			type: "POST",
			url: "/admin/users/ban",
			data: 'ip=' + ip + '&v=' + p,
			success: function(msg)
			{
				alert(msg);
			}
		}); // ajax bitti
		
	} else {
		alert('İsteğiniz üzerine engelleme işleminden vazgeçilmiştir!');
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
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br>
  <br />
  Kayıtları Listele 
  <select name="list1" id="list1">
  	<option value="id">ID</option>
    <option value="ip">IP</option>
    <option value="time">Tarih</option>
    <option value="country">Ülke</option>
    <option value="isp">ISP</option>
    <option value="platform">Platform</option>
    <option value="browser">Tarayıcı</option>
  </select>
  <select name="list2" id="list2">
  	<option value="asc">Artan</option>
    <option value="desc">Azalan</option>
  </select>
  <input type="button" name="button" id="button" value="Listele" onclick="listElements();" />
  </p>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td colspan="7" bgcolor="#58838b" class="tablehl">Siteye Giriş Yapmış Kişiler:</td>
  </tr>
  <?php
  	if (count($stats) < 0)
	{
		echo '<tr> 
    <td colspan="7" bgcolor="#F86262" class="tablehl">Kayıt yok!</td>
  </tr>';
	} else {
		
		echo '<tr> 
				<td width="5%" valign="top" bgcolor="#dee6e8" class="text"><strong>ID</strong></td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>SESSION ID</strong></td>
				<td width="10%" valign="top" bgcolor="#dee6e8" class="text"><strong>IP - Tarih</strong></td>
				<td width="25%" valign="top" bgcolor="#dee6e8" class="text"><strong>Ülke - ISP</strong></td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>Platform</strong></td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>Tarayıcı</strong></td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>İşlemler</strong></td>
			  </tr>';
		
		foreach ($stats as $s)
		{
			echo '<tr> 
				<td width="5%" valign="top" bgcolor="#dee6e8" class="text">' . $s['id'] . '</td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text">' . $s['sess_id'] . '</td>
				<td width="10%" valign="top" bgcolor="#dee6e8" class="text"><a href="http://whatsmyip.erdemarslan.com/api2/' . $s['ip'] . '" target="_blank">' . $s['ip'] . '</a><br />' . date('d.m.Y H:i:s',$s['time']) . '</td>
				<td width="25%" valign="top" bgcolor="#dee6e8" class="text">' . $s['country'] . ' <img src="' . $s['flag'] . '" /><br />' . $s['isp'] . '</td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text">' . $s['platform'] . ' [' . $s['pc_mobile'] . ']</td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text">' . $s['browser'] . ' ' . $s['version'] . '</td>
				<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>[<a style="cursor:pointer:" onclick="return ban_ip(\'' . $s['ip'] . '\')">Engelle</a>]</strong></td>
			  </tr>';
		}
	}
  ?>
  
  
  

  
  
</tbody></table>
<?php if (isset($links)) echo $links; ?>
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