<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript">
function delete_cat(id,name)
{
	var slct = '<?php
	if (count($cats) > 0)
	{
		echo 'İçeriği <select name="news_cat_select" id="news_cat_select">';
		echo '<option value="0">İçerik de silinsin</option>';
		foreach ($cats as $s)
		{
			echo '<option value="' . $s['c_id'] . '">' . $s['category_name'] . '</option>';
		}
		echo '</select> adlı kategoriye aktar.';
	}
	?>';
	
	$('#news_cat_do').val('delete');
	$('#news_cat_id').val(id);
	$('#news_cat_name').val(name);
	$('#form_select').html(slct);
	$('#news_cat_select option[value="' + id + '"]').remove();
	$('#news_cat_button').val('Sil');
	alert('Bilgiler yukarıdaki forma aktarılmıştır! Silme işleminizi onaylayınız!');
}

function edit_cat(id,name)
{
	$('#news_cat_do').val('edit');
	$('#news_cat_id').val(id);
	$('#news_cat_name').val(name);
	$('#form_select').html('');
	$('#news_cat_button').val('Düzenle');
	alert('Bilgiler düzenlenmek üzere yukarıdaki forma aktarılmıştır! Lütfen işlemi gerçekleştiriniz!');
}

function save_form()
{
	var islem = $('#news_cat_button').val();
	if (islem == 'Sil')
	{
		var c = confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');
		if (c)
		{
			//var form_data = $('form#news_cat').serialize();
			var id = $('#news_cat_id').val();
			var slct = $('#news_cat_select').val();
			var do_it = $('#news_cat_do').val();
			// Verileri gönderelim ve verileri alalım :)
			$.ajax({
				type: "POST",
				url: "/admin/news/category",
				data: 'id=' + id + '&slct=' + slct + '&news_cat_do=' + do_it,
				success: function(msg)
				{
					alert(msg);
					setTimeout("location.reload(true);",500);
				}
			}); // ajax bitti
		
		} else {
			alert('İsteğiniz üzerine silme işlemi iptal edilmiştir!');
		}
	}
	else if (islem == 'Ekle')
	{
		var ad = $('#news_cat_name').val();
		if (ad == '')
		{
			alert('Kategori adını mutlaka yazmalısınız!');
		} else {
			var form_data = $('form#news_cat').serialize();
			// Verileri gönderelim ve verileri alalım :)
			$.ajax({
				type: "POST",
				url: "/admin/news/category",
				data: form_data,
				success: function(msg)
				{
					alert(msg);
					setTimeout("location.reload(true);",500);
				}
			}); // ajax bitti
		}
	}
	else {
		var form_data = $('form#news_cat').serialize();
		// Verileri gönderelim ve verileri alalım :)
		$.ajax({
			type: "POST",
			url: "/admin/news/category",
			data: form_data,
			success: function(msg)
			{
				alert(msg);
				setTimeout("location.reload(true);",500);
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
  <a href="<?php echo base_url('admin/news/add_new'); ?>">Yeni Haber Ekle</a><br />
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="4" bgcolor="#58838b">Haber Kategorisi Ekle:</td>
  </tr>
  <form name="news_cat" id="news_cat">
  <tr>
    <input name="news_cat_do" id="news_cat_do" type="hidden" value="add" />
    <input name="news_cat_id" id="news_cat_id" type="hidden" value="0" />
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8">Kategori İsmi</td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8"><input name="news_cat_name" id="news_cat_name" type="text" /></td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8"><span id="form_select"></span></td>
    <td class="text" valign="top" width="40%" bgcolor="#dee6e8"><input name="news_cat_button" onclick="save_form()" id="news_cat_button" type="button" value="Ekle" /></td>
  </tr>
  </form>
</tbody></table>
  
  <br />
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="3" bgcolor="#58838b">Kategoriler:</td>
  </tr>
  <tr>
    <td class="text" valign="top" width="5%" bgcolor="#dee6e8"><strong>ID</strong></td>
    <td class="text" valign="top" width="60%" bgcolor="#dee6e8"><strong>Kategori Adı</strong></td>
    <td class="text" valign="top" width="35%" bgcolor="#dee6e8"><strong>İşlemler</strong></td>
  </tr>
  <?php
  	if (count($cats) > 0)
	{		
		foreach ($cats as $c)
		{
			if ($c['is_notice'] == 1)
			{
				$sil = '[<a style="cursor:pointer;" onclick="alert(\'Bu bir duyuru kategorisi olduğundan silinemez! Sadece düzenleyebilirsiniz.\')">Sil</a>]';
			} else {
				$sil = '[<a style="cursor:pointer;" onclick="delete_cat(\'' . $c['c_id'] . '\',\'' . $c['category_name'] . '\')">Sil</a>]';
			}
			echo '<tr>
    <td class="text" valign="top" bgcolor="#dee6e8">' . $c['c_id'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">' . $c['category_name'] . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">[<a style="cursor:pointer;" onclick="edit_cat(\'' . $c['c_id'] . '\',\'' . $c['category_name'] . '\')">Düzenle</a>] ' . $sil . '</td>
  </tr>';
		}
	}
  ?>
  
</tbody></table>
<br />
  
  
  
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td colspan="6" bgcolor="#58838b" class="tablehl">Haberler:</td>
  </tr>
  <?php
  	if ($news['status'] == 'error')
	{
		echo '<tr> 
    <td colspan="6" bgcolor="#F86262" class="tablehl">' . $news['info'] . '</td>
  </tr>';
	} else {
		foreach ($news['info'] as $p)
		{
			$p['news_writer'] == 'admin' ? $w = '[a]' : $w = '[k]';
			$p['active'] == 1 ? $act = array('do'=>'n','text'=>'onayı kaldır') : $act = array('do'=>'y','text'=>'onayla');
			
			echo '<tr> 
					<td width="4%" valign="top" bgcolor="#dee6e8" class="text">' . $p['id'] . '</td>
					<td width="10%" valign="top" bgcolor="#dee6e8" class="text">' . $p['category_name'] . '</td>
					<td width="40%" valign="top" bgcolor="#dee6e8" class="text">' . $w . ' <a href="' . base_url('admin/news/edit/' . $p['id']) . '">' . $p['title'] . '</a></td>
					<td width="13%" valign="top" bgcolor="#dee6e8" class="text">' . date('d.m.Y H:i:s', $p['date']) . '</td>
					<td width="10%" valign="top" bgcolor="#dee6e8" class="text">' . $p['hit'] . ' okunma</td>
					<td width="23%" valign="top" bgcolor="#dee6e8" class="text">[<a href="' . base_url('admin/news/edit/' . $p['id']) . '">düzenle</a>] [<a href="' . base_url('admin/news/delete/' . $p['id']) . '" onclick="return confirm(\'Bu haberi silmek istiyor musunuz?\');">sil</a>] [<a href="' . base_url('admin/news/activate/' . $p['id'] . '/' . $act['do']) . '">' . $act['text'] . '</a>]</td>
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