<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Era Smile Yönetim</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo admin('admin2.css','css',true); ?>" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo base_url('tinymce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">
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
        skin_variant : "silver",

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
    <form action="/admin/guestbook/save/<?php echo $gb['id']; ?>" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12%">ID</td>
        <td width="2%">:</td>
        <td width="86%"><?php echo $gb['id']; ?><input name="gb_id" type="hidden" value="<?php echo $gb['id']; ?>" /></td>
      </tr>
      <tr>
        <td>Ad Soyad</td>
        <td>:</td>
        <td><input name="name" id="name" style="width:500px;" value="<?php echo $gb['name']; ?>" type="text" />
      </tr>
      
      <tr>
        <td>Tarih</td>
        <td>:</td>
        <td><input name="date" id="date" style="width:500px;" value="<?php echo date('d.m.Y H:i:s',$gb['date']); ?>" readonly="readonly" type="text" />
      </tr>
      
      <tr>
        <td>Email</td>
        <td>:</td>
        <td><input name="email" id="email" style="width:500px;" value="<?php echo $gb['email']; ?>" readonly="readonly" type="text" />
      </tr>
      
      <tr>
        <td>Web Sitesi</td>
        <td>:</td>
        <td><input name="webpage" id="webpage" style="width:500px;" value="<?php echo $gb['webpage']; ?>" type="text" /> http:// şeklinde başlamalı
      </tr>
      
      <tr>
        <td>Resim</td>
        <td>:</td>
        <td><input name="photo" id="photo" style="width:500px;" value="<?php echo $gb['photo']; ?>" type="text" />
      </tr>
      
      <tr>
        <td valign="top">Mesaj</td>
        <td valign="top">:</td>
        <td><textarea name="message" cols="" rows=""><?php echo $gb['message']; ?></textarea></td>
      </tr>
      <tr>
        <td>User Agent</td>
        <td>:</td>
        <td><?php echo $gb['user_agent']; ?></td>
      </tr>
      <?php
	  	if ($gb['active'] == 1)
		{
			$o1 = '';
			$o2	= ' selected="selected"';
		} else {
			$o2 = '';
			$o1	= ' selected="selected"';
		}
	  ?>
      <tr>
        <td>Onayla</td>
        <td>:</td>
        <td><select name="active">
        	<option value="0" <?php echo $o1; ?>>Onaylama</option>
            <option value="1" <?php echo $o2; ?>>Onayla</option>
        </select></td>
      </tr>
      
      <tr>
        <td>Düzenlendi Yazısı</td>
        <td>:</td>
        <td><input name="edited" type="checkbox" value="ok" checked /></td>
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