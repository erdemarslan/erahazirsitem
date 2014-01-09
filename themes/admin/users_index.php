<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css"></head>

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
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td colspan="6" bgcolor="#58838b" class="tablehl">Facebook ile Giriş Yapmış Üyeler:</td>
  </tr>
  <?php
  	if ($users['status'] == 'error')
	{
		echo '<tr> 
    <td colspan="6" bgcolor="#F86262" class="tablehl">' . $users['info'] . '</td>
  </tr>';
	} else {
		foreach ($users['info'] as $p)
		{
			$p['visible'] == 1 ? $v = 'Aktif' : $v = 'Pasif';
			echo '<tr> 
					<td width="5%" valign="top" bgcolor="#dee6e8" class="text">' . $p['id'] . '</td>
					<td width="15%" valign="top" bgcolor="#dee6e8" class="text"><a href="https://www.facebook.com/' . $p['facebook_id'] . '" target="_blank">' . $p['facebook_id'] . '</a></td>
					<td width="20%" valign="top" bgcolor="#dee6e8" class="text">' . $p['name'] . '<br />' . $p['email'] . '</td>
					<td width="20%" valign="top" bgcolor="#dee6e8" class="text">' . date('d.m.Y', $p['birtday']) . '<br />' . $p['sex'] . '</td>
					<td width="25%" valign="top" bgcolor="#dee6e8" class="text">' . $p['website'] . '<br />' . $p['location'] . '</td>
					<td width="15%" valign="top" bgcolor="#dee6e8" class="text">' . $v . '</td>
				  </tr>';
		}
	}
  ?>
  
  
  

  
  
</tbody></table>
  
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