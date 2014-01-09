<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('lightbox.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo theme('lightbox.js','js',true); ?>"></script>
<script type="text/javascript">

$(document).ready(function(){
	$('#video_add_edit').hide();
});

function getYoutubeData()
{
	var url = $('#youtube_url').val();
	if (url == '')
	{
		alert('Lütfen bilgilerini almak istediğiniz Youtube adresini yazınız!');
	} else {
		$.getJSON('/admin/video/getVideo', {'url' :url}, function(json) {
			
			var k = eval(json);
			if (k.status == 'ok')
			{
				$('#video_add_edit').show();
				$('#video_id').val(k.id);
				$('#video_title').val(k.title);
				$('#video_desc').val(k.description);
				$('#video_thumb').val(k.thumbnail);
				$('#video_length').val(k.length);
				$('#v_button').val('Kaydet');
				$('#youtube_url').val('');
				
			} else {
				alert(k.info);
			}
		});
	}
}

function edit_video(id)
{
	$.getJSON('/admin/video/getVideoInfo', {'id' :id}, function(json) {
	var k = eval(json);
	if (k.status == 'ok')
	{
		$('#video_add_edit').show();
		$('#v_id').val(k.id);
		$('#video_id').val(k.video_id);
		$('#video_title').val(k.title);
		$('#video_desc').val(k.description);
		$('#video_thumb').val(k.thumbnail);
		$('#video_length').val(k.length);
		$('#v_button').val('Düzenle');
		$('#youtube_url').val('');
			
	} else {
		alert(k.info);
	}
	});
}

function save_form()
{
	var t = $('#video_title').val();
	var d = $('#video_desc').val();
	
	if (t == '')
	{
		alert('Lütfen video başlığı yazınız!');
	}
	else if (d == '')
	{
		alert('Lütfen videoya bir açıklama yazınız!');
	}
	else
	{
		var form_data = $('form#save_video').serialize();
		// Verileri gönderelim ve verileri alalım :)
		$.ajax({
			type: "POST",
			url: "/admin/video/save",
			data: form_data,
			success: function(msg)
			{
				if (msg=="ok")
				{
					$('#video_add_edit').hide();
					alert('Video başarıyla eklendi/düzenlendi! Sayfa yenileniyor...');
					setTimeout("location.reload(true);",500);
				}
				else
				{
					alert(msg);
				}
			}
		}); // ajax bitti
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
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br></p>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  
    <tbody>
      <tr>
        <td class="tablehl" colspan="3" bgcolor="#58838b">Youtube'dan video bilgilerini getir</td>
      </tr>
    </tbody>
      <tr>
        <td class="text" valign="top" width="10%" bgcolor="#dee6e8">Youtube Adresi</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="youtube_url" id="youtube_url" type="text" size="100" /></td>
        <td class="text" valign="top" width="10%" bgcolor="#dee6e8"><input type="button" name="y_b" id="y_b" value="Getir" onclick="getYoutubeData()" /></td>
      </tr>
</table>

<br />

<form name="save_video" id="save_video">
<table id="video_add_edit" width="100%" border="0" cellpadding="3" cellspacing="1">
  
    <tbody>
      <tr>
        <td class="tablehl" colspan="2" bgcolor="#58838b">Video Ekle:</td>
      </tr>
    </tbody>
    <input type="hidden" name="v_id" id="v_id" value="0" />
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Video ID</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="video_id" id="video_id" readonly="readonly" size="50" type="text" /></td>
      </tr>
      
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Başlık</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="video_title" id="video_title" size="50" type="text" /></td>
      </tr>
      
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Açıklama</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><textarea id="video_desc" name="video_desc" rows="5" cols="38"></textarea></td>
      </tr>
      
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Küçük Resim</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="video_thumb" id="video_thumb" readonly="readonly" size="50" type="text" /></td>
      </tr>
      
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Video Süresi</td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="video_length" id="video_length" readonly="readonly" size="50" type="text" /> saniye</td>
      </tr>
      
      <tr>
        <td class="text" valign="top" width="20%" bgcolor="#dee6e8"></td>
        <td class="text" valign="top" width="80%" bgcolor="#dee6e8"><input name="v_button" id="v_button" onclick="save_form()" type="button" value="Kaydet" /></td>
      </tr>
      
</table>
</form>
  <br />
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="6" bgcolor="#58838b">Videolar:</td>
  </tr>
  
  <tr> 
    <td class="text" valign="top" width="5%" bgcolor="#dee6e8"><strong>ID</strong></td>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8"><strong>Video ID</strong></td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8"><strong>Başlık</strong></td>
    <td class="text" valign="top" width="35%" bgcolor="#dee6e8"><strong>Açıklama</strong></td>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8"><strong>Küçük Resim</strong></td>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8"><strong>İşlem</strong></td>
  </tr>
  <?php
  	if (count($videos) > 0)
	{
		foreach ($videos as $v)
		{
			echo '<tr> 
    <td class="text" valign="top" bgcolor="#dee6e8">' . $v['id'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">' . $v['video_id'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">' . $v['video_title'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">' . $v['video_desc'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8"><a href="' . $v['video_thumb'] . '" rel="lightbox">Resme Bak</a></td>
    <td class="text" valign="top" bgcolor="#dee6e8"><strong>[<a style="cursor:pointer;" onclick="edit_video(\'' . $v['id'] . '\')">Düzenle</a>] [<a href="' . base_url('admin/video/delete/' . $v['id']) . '" onclick="return confirm(\'Bu videoyu silmek istediğinizden emin misiniz?\')">Sil</a>]</strong></td>
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