<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript">
function save_form()
{
	var f_name = $('#add_menu_name').val();
	var f_url = $('#add_menu_url').val();
	
	if (f_name == '')
	{
		alert('Menü ismini yazmamışsınız!');
	}
	else if (f_url == '')
	{
		alert('Menü adresini yazmamışsınız!');
	} else {
		
		var form_data = $('form#menu_add_edit').serialize();
		// Verileri gönderelim ve verileri alalım :)
		$.ajax({
			type: "POST",
			url: "/admin/menu_save",
			data: form_data,
			success: function(msg)
			{
				if (msg=="ok")
				{
					alert('Menü başarıyla eklendi/güncellendi. Sayfa yenileniyor!');
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


function delete_menu(id)
{
	var c = confirm('Bu menüyü silmek istiyor musunuz?');
	if (c)
	{
		$.ajax({
			type: "POST",
			url: '/admin/menu_delete/',
			data: 'm_id=' + id,
			success: function(msg)
			{
				if (msg=="ok")
				{
					alert('Menü başarıyla silindi. Sayfa yenileniyor!');
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

function duzenle(id)
{
	var d_id = $('#menu_edit_id_' + id).text();
	var d_name = $('#menu_edit_name_' + id).text();
	var d_url = $('#menu_edit_url_' + id).text();
	var d_target = $('#menu_edit_target_' + id).text();
	var d_align = $('#menu_edit_align_' + id).text();
	
	//alert(d_id + ' - ' +d_name + ' - ' + d_url + ' - ' + d_target + ' - ' + d_align);
	if (d_target == 'Aynı Sayfada')
	{
		var t = '_self';
	} else {
		var t = '_blank';
	}
	
	$('#add_menu_id').val(d_id);
	$('#add_menu_name').val(d_name);
	$('#add_menu_url').val(d_url);
	$('#add_menu_target').val(t);
	$('#add_menu_align').val(d_align);
	$('#add_menu_button').val('Kaydet');
	
	alert(d_name + ' adlı menü düzenlenmek üzere yukarıya eklenmiştir. Gerekli düzenlemeyi yaptıktan sonra kaydediniz!');
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
  <tbody><tr> 
    <td class="tablehl" colspan="5" bgcolor="#58838b">Menü Ekle:</td>
  </tr>
  <form name="menu_add_edit" id="menu_add_edit">
  <tr>
  <input name="add_menu_id" id="add_menu_id" type="hidden" value="0" />
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8">Menü İsmi <input name="add_menu_name" id="add_menu_name" type="text" /></td>
    <td class="text" valign="top" width="25%" bgcolor="#dee6e8">Adresi <input name="add_menu_url" id="add_menu_url" type="text" /></td>
    <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Hedef <select name="add_menu_target" id="add_menu_target">
    	<option value="_self">Aynı sayfada</option>
        <option value="_blank">Yeni sayfada</option>
    </select></td>
    <td class="text" valign="top" width="20%" bgcolor="#dee6e8">Sıra <select name="add_menu_align" id="add_menu_align">
    	<?php
			$i = 0;
			while($i < 101)
			{
				echo '<option value="' . $i . '">' . $i . '</option>';
				$i++;
			}
		?>
    </select></td>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8"><input name="add_menu_button" onclick="save_form()" id="add_menu_button" type="button" value="Ekle" /></td>
  </tr>
  </form>
</tbody></table>
  
  <br />
  
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tbody><tr> 
    <td class="tablehl" colspan="6" bgcolor="#58838b">Menüler:</td>
  </tr>
  
  <tr> 
    <td class="text" valign="top" width="5%" bgcolor="#dee6e8"><strong>ID</strong></td>
    <td class="text" valign="top" width="20%" bgcolor="#dee6e8"><strong>İsim</strong></td>
    <td class="text" valign="top" width="35%" bgcolor="#dee6e8"><strong>Adres</strong></td>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8"><strong>Hedef</strong></td>
    <td class="text" valign="top" width="10%" bgcolor="#dee6e8"><strong>Sıra</strong></td>
    <td class="text" valign="top" width="15%" bgcolor="#dee6e8"><strong>İşlem</strong></td>
  </tr>
  <?php
  	if (count($site_menus) > 0)
	{
		foreach ($site_menus as $sm)
		{
			$sm->target == '_self' ? $t = 'Aynı Sayfada' : $t = 'Yeni Sayfada';
			echo '<tr> 
    <td id="menu_edit_id_' . $sm->id . '" class="text" valign="top" bgcolor="#dee6e8">' . $sm->id . '</td>
    <td id="menu_edit_name_' . $sm->id . '" class="text" valign="top" bgcolor="#dee6e8">' . $sm->name . '</td>
    <td id="menu_edit_url_' . $sm->id . '" class="text" valign="top" bgcolor="#dee6e8">' . $sm->url . '</td>
    <td id="menu_edit_target_' . $sm->id . '" class="text" valign="top" bgcolor="#dee6e8">' . $t . '</td>
    <td id="menu_edit_align_' . $sm->id . '" class="text" valign="top" bgcolor="#dee6e8">' . $sm->align . '</td>
    <td class="text" valign="top" bgcolor="#dee6e8">[<a style="cursor:pointer;" onclick="duzenle(\'' . $sm->id . '\')">Düzenle</a>] [<a style="cursor:pointer;" onclick="return delete_menu(\'' . $sm->id . '\')">Sil</a>]</td>
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