<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('lightbox.css','css',true); ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.8.21/themes/ui-lightness/jquery-ui.css" />
<style type="text/css">
.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
<script type="text/javascript" src="<?php echo theme('jQuery.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo theme('lightbox.js','js',true); ?>"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo theme('jquery-ui-timepicker-addon.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo theme('jquery-ui-sliderAccess.js','js',true); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('tinymce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">
/* Turkish translation for the jQuery Timepicker Addon */
/* Written by Fehmi Can Saglam, Edited by Goktug Ozturk */
(function($) {
	$.timepicker.regional['tr'] = {
		timeOnlyTitle: 'Zaman Seçiniz',
		timeText: 'Zaman',
		hourText: 'Saat',
		minuteText: 'Dakika',
		secondText: 'Saniye',
		millisecText: 'Milisaniye',
		timezoneText: 'Zaman Dilimi',
		currentText: 'Şu an',
		closeText: 'Tamam',
		timeFormat: 'hh:mm',
		amNames: ['ÖÖ', 'Ö'],
		pmNames: ['ÖS', 'S'],
		ampm: false
	};
	$.timepicker.setDefaults($.timepicker.regional['tr']);
})(jQuery);


tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
		language : "tr",
		width : "800",
		relative_urls : false,
		height : "500",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,jbimages",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|	,formatselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,jbimages,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,|,ltr,rtl,|,fullscreen,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,

        // Skin options
        skin : "default",
        //skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        //content_css : "css/tinymce.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Erdem Arslan",
                staffid : "1232344"
        }
});

$(document).ready(function(){
	
	$('#fotoyuklemealani').hide();
	$('#fotobilgi').hide();
	$('#tarih').datetimepicker({
		monthNames: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralıık"],
		monthNamesShort: ["Oca","Şub","Mar","Nis","May","Haz","Tem","Ağu","Eyl","Eki","Kas","Ara"],
		dayNames: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
		dayNamesMin: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
		dayNamesShort: ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cts"],
		showSecond: true,
		timeFormat: 'hh:mm:ss',
		dateFormat: 'dd.mm.yy',
		addSliderAccess: true,
		sliderAccessArgs: { touchonly: false },
		changeMonth: true,
		changeYear: true
		});
	
	$('#foto').change(function(){
		deger = $(this).val();
		if (deger == 'default_image')
		{
			$('#fotoyuklemealani').hide();
			$('#fotobilgi').hide();
		}
		else if (deger == 'upload_image')
		{
			$('#fotobilgi').hide();
			$('#fotoyuklemealani').show();
		}
		else
		{
			$('#fotoyuklemealani').hide();
			$('#fotobilgi').show();
			$('#fotobilgi').html('<a href="<?php echo base_url(); ?>' + deger + '" rel="lightbox" title="Ön İzleme [Gerçek Boyut]">fotoğrafa bak</a>');
		}
	});
});

function form_kontrol()
{
	var kategori = $('#kategori').val();
	var baslik = $('#baslik').val();	
	tinyMCE.triggerSave();
	var icerik = $('#icerik').val();
	
	if (kategori == 0)
	{
		alert('Lütfen bir kategori seçiniz!');
		return false;
	} else if (baslik == '')
	{
		alert('Lütfen haber başlığını yazınız!');
		return false;
	} else if (icerik == '')
	{
		alert('Lütfen haber içeriğini yazınız!');
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
<tbody>
<tr>
<td class="text">
  <p><span class="text"><b>Yönetim Paneline Hoşgeldiniz!</b></span><br></p>
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
    <form action="/admin/news/save" method="post" enctype="multipart/form-data" onsubmit="return form_kontrol()" id="addnews" name="addnews">
    <table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td width="12%">ID</td>
        <td width="2%">:</td>
        <td width="86%"><input name="news_id" id="news_id" type="hidden" value="0" /></td>
      </tr>
      <tr>
        <td width="12%">Kategori</td>
        <td width="2%">:</td>
        <td width="86%"><select name="kategori" id="kategori">
        	<option value="0">Seçiniz</option>
            <?php
			foreach ($categories as $c)
			{
				echo '<option value="' . $c['c_id'] . '">' . $c['category_name'] . '</option>';
			}
			?>
        </select></td>
      </tr>
      <tr>
        <td>Başlık</td>
        <td>:</td>
        <td><input name="baslik" id="baslik" style="width:500px;" type="text" /></td>
      </tr>
      <tr>
        <td>Tarih</td>
        <td>:</td>
        <td><input type="text" name="tarih" id="tarih" style="width:500px;" value="<?php echo date('d.m.Y H:i:s',time()); ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Fotoğraf</td>
        <td>:</td>
        <td><select name="foto" id="foto">
        	<option value="default_image">Varsayılan Fotoğrafı Kullanmak İstiyorum</option>
            <option value="upload_image">Fotoğraf Yüklemek İstiyorum</option>
            <?php
            foreach($images as $i)
			{
				echo '<option value="' . $i . '">' . $i . '</option>';
			}
			?>
        </select> <span id="fotobilgi"></span>
		</td>
      </tr>
      <tr id="fotoyuklemealani">
      	<td>Fotoğraf Yükle</td>
        <td>:</td>
        <td><input type="file" name="fotoyukle" id="fotoyukle" size="80" /></td>
      </tr>
      <tr>
        <td valign="top">İçerik</td>
        <td valign="top">:</td>
        <td><textarea name="icerik" cols="" rows=""></textarea></td>
      </tr>
      <tr>
        <td>Hit</td>
        <td>:</td>
        <td><input name="hit" id="hit" style="width:500px;" value="1" type="text" /></td>
      </tr>
      <tr>
        <td>Hemen Yayınlansın</td>
        <td>:</td>
        <td><select name="aktif" id="aktif">
        	<option value="1">Evet</option>
            <option value="0">Hayır</option>
        </select></td>
      </tr>
      <tr>
        <td>Yazar</td>
        <td>:</td>
        <td><input name="facebook_name" id="facebook_name" value="admin" type="text" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Facebook ID</td>
        <td>:</td>
        <td><input name="facebook_id" id="facebook_id" value="0" type="text" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Facebook Email</td>
        <td>:</td>
        <td><input name="facebook_email" id="facebook_email" type="text" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input name="button" type="submit" value="Kaydet" /></td>
      </tr>
    </table>
    </form>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>


<br />


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