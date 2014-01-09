<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css"></head>
<link href="<?php echo theme('lightbox.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('notify.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo theme('lightbox.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo theme('notify.js','js',true); ?>"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	<?php
		if (!$album_saved)
		{
			echo '$(\'#photo_area\').hide();';
		}
	?>

});

function save_facebook_album()
{
	var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" /> Lütfen bekleyiniz!';
	$('#album_info_area').html(loading);
	
	var form_data = $('form#save_album').serialize();
	// Verileri gönderelim ve verileri alalım :)
	$.ajax({
		type: "POST",
		url: "/admin/gallery/save",
		data: form_data,
		success: function(msg)
		{
			if (msg=="ok")
			{
				$('#album_info_area').html("Lütfen sayfadan ayrılmadan önce, albüme resimleri eklemeyi unutmayınız!");
				$('#photo_area').show();
			}
			else
			{
				alert(msg);
				$('#album_info_area').html('<input type="button" name="album_button" id="album_button" onclick="javascript:save_facebook_album()" value="Kaydet" />');
			}
		}
	}); // ajax bitti
}

function notify_me(msg)
{
	$.notify({
        inline: true,
        html: '<span>' + msg + '</span>'
    }, 3000)
}

function save_album_image(id)
{
	var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" />';
	$('#photo_save_area_' + id).html(loading);
	
	// veriler
	var album_id = $('#a_id').val();
	var photo_id = id;
	var photo_url = $('#photo_' + id).val();
	
	$.ajax({
		type: "POST",
		url: "/admin/gallery/save_photo",
		data: 'album_id=' + album_id + '&photo_id=' + photo_id + '&photo_url=' + photo_url,
		success: function(msg)
		{
			if (msg=="ok")
			{
				//alert('Fotoğraf başarıyla veribanına eklendi!');
				notify_me(id + ' numaralı fotoğraf başarıyla eklendi.');
				$('#photo_save_area_' + id).html('<a style="cursor:pointer;" onclick="javascript:delete_album_image(\'' + id + '\')">Sil</a>');
				
			}
			else
			{
				//alert(msg);
				notify_me(msg);
				$('#photo_save_area_' + id).html('<a style="cursor:pointer;" onclick="javascript:save_album_image(\'' + id + '\')">Kaydet</a>');
			}
		}
	}); // ajax bitti
}


function delete_album_image(id)
{
	var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" />';
	$('#photo_save_area_' + id).html(loading);
	
	// veriler
	var album_id = $('#a_id').val();
	var photo_id = id;
	var photo_url = $('#photo_' + id).val();
	
	$.ajax({
		type: "POST",
		url: "/admin/gallery/delete_photo",
		data: 'album_id=' + album_id + '&photo_id=' + photo_id + '&photo_url=' + photo_url,
		success: function(msg)
		{
			if (msg=="ok")
			{
				//alert('Fotoğraf başarıyla veribanından kaldırıldı!');
				notify_me(id + ' numaralı fotoğraf veritabanından başarıyla silindi!');
				$('#photo_save_area_' + id).html('<a style="cursor:pointer;" onclick="javascript:save_album_image(\'' + id + '\')">Kaydet</a>');
				
			}
			else
			{
				//alert(msg);
				notify_me(msg);
				$('#photo_save_area_' + id).html('<a style="cursor:pointer;" onclick="javascript:delete_album_image(\'' + id + '\')">Sil</a>');
			}
		}
	}); // ajax bitti
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
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br></p><br />
  <form name="save_album" id="save_album">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="17%"><strong>Albüm ID</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="80%"><input type="text" name="a_id" id="a_id" value="<?php echo $album['id']; ?>" readonly="readonly" size="80" /></td>
  </tr>
  <tr>
    <td><strong>Albüm Adı</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="a_name" id="a_name" value="<?php echo $album['name']; ?>" size="80" /></td>
  </tr>
  <tr>
    <td><strong>Albüm Tarihi:</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="a_date" id="a_date" value="<?php echo date('d.m.Y H:i:s',strtotime($album['date'])); ?>" readonly="readonly" size="80" /></td>
  </tr>
  <tr>
    <td><strong>Albüm Açıklaması</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="a_desc" id="a_desc" value="<?php echo $album['description']; ?>" size="80" /></td>
  </tr>
  <tr>
    <td><strong>Albüm Kapak Resmi</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="a_cover" id="a_cover" value="<?php echo $album_cover; ?>" readonly="readonly" size="80" /> <a href="<?php echo $album_cover; ?>" rel="lightbox">fotoğrafa bak</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div id="album_info_area">
    <?php if (!$album_saved) { echo '<input type="button" name="album_button" id="album_button" onclick="javascript:save_facebook_album()" value="Kaydet" />'; } else { echo 'Bu albüm zaten kaydedilmiş. Lütfen aşağıdan fotoğraf ekleme çıkartma yapınız!'; } ?>
    </div></td>
  </tr>
  </table>
  </form>
  
  <br />
<br />

<div id="photo_area">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td colspan="3" bgcolor="#58838b" class="tablehl">Albümde bulunan fotoğraflar:</td>
  </tr>

    <tr> 
        <td width="15%" valign="top" bgcolor="#dee6e8" class="text"><strong>ID</strong></td>
        <td width="65%" valign="top" bgcolor="#dee6e8" class="text"><strong>Fotoğraf</strong></td>
        <td width="20%" valign="top" bgcolor="#dee6e8" class="text"><strong>İşlemler</strong></td>
    </tr>
    
    <?php
	
	foreach ($images as $key=>$img)
	{
    	if (array_key_exists($key,$album_images))
		{
			$islem = '<a style="cursor:pointer;" onclick="javascript:delete_album_image(\'' . $key . '\')">Sil</a>';
		} else {
			$islem = '<a style="cursor:pointer;" onclick="javascript:save_album_image(\'' . $key . '\')">Kaydet</a>';
		}
		
		
		
		echo '<tr id="tr_' . $key . '">
    		<td valign="top" bgcolor="#dee6e8" class="text">' . $key . '</td>
        	<td valign="top" bgcolor="#dee6e8" class="text"><input type="text" name="photo_' . $key . '" id="photo_' . $key . '" value="' . $img . '" size="80" /> <a href="' . $img . '" rel="lightbox[galeri]" title="Fotoğraf ID: ' . $key . '">fotoğrafa bak</a></td>
       		<td valign="top" bgcolor="#dee6e8" class="text"><div id="photo_save_area_' . $key . '">' . $islem . '</div></td>
    	</tr>';
	}
	
    // print_r($images); ?>
	    
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>
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