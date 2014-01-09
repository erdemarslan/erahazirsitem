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
  <a href="<?php echo base_url('admin/gallery/clear_cache'); ?>">Önbelleği Temizle</a> | <a href="<?php echo base_url('admin/gallery/auth_user'); ?>">Facebook İle Siteyi Yetkilendir</a> | <a href="<?php echo base_url('admin/gallery/clear_all'); ?>">Site Üzerindeki Facebook Yetkilendirmesini Sil</a>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td colspan="4" bgcolor="#58838b" class="tablehl">Facebook Üzerindeki Galeriler:</td>
  </tr>

    <tr> 
        <td width="3%" valign="top" bgcolor="#dee6e8" class="text"><strong>DB</strong></td>
        <td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>ID</strong></td>
        <td width="65%" valign="top" bgcolor="#dee6e8" class="text"><strong>Albüm Adı</strong></td>
        <td width="17%" valign="top" bgcolor="#dee6e8" class="text"><strong>İşlemler</strong></td>
    </tr>
    <?php foreach ($albums as $id=>$data)
	{
		if (count($db_albums['album_ids']) > 0)
		{
			if (array_key_exists($id,$db_albums['album_ids']))
			{
				$db = '<img src="' . admin('tick.png','image',true) . '" alt="Veritabanında kayıtlı" title="Veritabanında kayıtlı" width="16" height=16" />';
				$is_saved = '[<a href="' . base_url('admin/gallery/add/' . $id) . '">Düzenle</a>] [<a onclick="return confirm(\'Albüm ve tüm resimler veritabanından silincektir. Onaylıyor musunuz?\')" href="' . base_url('admin/gallery/delete/' . $id) . '">Sil</a>]';
			} else {
				$db = '<img src="' . admin('cross.png','image',true) . '" width="16" height=16" alt="Veritabanında kayıtlı değil!" title="Veritabanında kayıtlı değil!" />';
				$is_saved = '[<a href="' . base_url('admin/gallery/add/' . $id) . '">Ekle</a>]';
			}
		} else {
			$db = '<img src="' . admin('cross.png','image',true) . '" width="16" height=16" alt="Veritabanında kayıtlı değil!" title="Veritabanında kayıtlı değil!" />';
			$is_saved = '[<a href="' . base_url('admin/gallery/add/' . $id) . '">Ekle</a>]';
		}
		$tarih = strtotime($data['date']);
		echo '<tr> 
		<td valign="top" bgcolor="#dee6e8" class="text">' . $db . '</td>
        <td valign="top" bgcolor="#dee6e8" class="text">' . $id . '</td>
        <td valign="top" bgcolor="#dee6e8" class="text">[' . date('d.m.Y H:i:s',$tarih) . '] &nbsp; &nbsp;&nbsp;' . $data['name'] . '</td>
        <td valign="top" bgcolor="#dee6e8" class="text">' . $is_saved . '</td>
    </tr>';
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