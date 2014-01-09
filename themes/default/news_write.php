<script type="text/javascript" src="<?php echo base_url('tinymce/tiny_mce.js'); ?>"></script>
<script type="text/javascript" src="<?php echo theme('enhance.js','js',true); ?>"></script>	
<script type="text/javascript">
enhance({
	loadScripts: [
		'/themes/default/js/fileinput.js',
		'/themes/default/js/fileinputdo.js'
	]
});

tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
		language : "tr",
		width : "600",
		relative_urls : false,
		height : "200",
        plugins : "lists,pagebreak,style,layer,advhr,noneditable,nonbreaking,xhtmlxtras,emotions,insertdatetime,",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,hr,emotions,insertdate,inserttime,pagebreak",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "none",
        theme_advanced_resizing : true,
		plugin_insertdate_dateFormat : "%d.%m.%Y",
        plugin_insertdate_timeFormat : "%H:%M:%S",

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

function checkForm()
{
	$('#news_write_return').hide();
	var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" /> Lütfen bekleyiniz!';
	
	$('#news_write_return').show();
	$('#news_write_return').html(loading);
	
	var baslik = $('#baslik').val();
	var kategori = $('#kategori').val();
	var captcha = $('#captcha').val();
	tinyMCE.triggerSave();
	var mesaj = $('#mesaj').val();	
	
	var donut = '';
	
	if (baslik == '')
	{
		donut = donut + 'HATA: Habere başlık yazmamışsınız!<br />';
	}
	if (kategori == 0) 
	{
		donut = donut + 'HATA: Kategori seçmemişsiniz. Lütfen habere uygun bir kategori seçiniz!<br />';
	}
	if (captcha == '')
	{
		donut = donut + 'HATA: Güvenlik kodu alanı boş bırakılamaz!<br />';
	}
	if (mesaj == '')
	{
		donut = donut + 'HATA: Haber metnini yazmamışsınız!';
	}
	
	if (donut == '')
	{
		return true;
	} else {
		$('#news_write_return').html(donut);
		$('#news_write_return').delay(5000).hide(1000);
		return false;
	}
}
$(document).ready(function(){
	$('#news_write_return').hide();
});
</script>
<div id="sol">

<div id="navigasyon" style=" padding: 5px; border:1px solid #efefef;">
<strong>Önemli Hatırlatma</strong><br />
- Gönderdiğiniz haber, yönetim tarafından onaylandıktan sonra sitede görünecektir. <br />
- 
Gerçeği yansıtmayan, 3. şahıslar hakkında doğru bile olsa insan onuru ve kişiliğini rencide edecek yazılar asla yayınlanmayacaktır. <br />
- 
Gönderilen yazıların, toplumun genelini ifade etmesi, reklam amacı gütmemesi ve genel toplum ahlakına aykırı olmaması gerekmektedir.</div>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;">

<div style="clear:both;"></div>
</div>

<?php
if(!$fb_data['me'])
{
?>
<div id="navigasyon" style=" padding: 5px; border:1px solid #efefef;">
<strong>Bu sayfayı sadece Facebook ile giriş yapmış kullanıcılar kullanabilirler. Lütfen giriş yapınız!</strong>
</div>
<?php 
} else {
?>
<div id="news_write_return" class="guestbook_list"></div>
<div id="guestbook_list">
<form name="news_write" id="news_write" onsubmit="return checkForm();" action="<?php echo base_url('news/save_form'); ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="face_id" id="face_id" value="<?php echo $fb_data['me']['id']; ?>" />
<input type="hidden" name="face_name" id="face_name" value="<?php echo $fb_data['me']['name']; ?>" />
<input type="hidden" name="face_email" id="face_email" value="<?php echo $fb_data['me']['email']; ?>" />

<input class="textbox" type="text" name="baslik" id="baslik" value="" /> Haber Başlığı
<input class="textbox" type="text" name="tarih" id="tarih" value="<?php echo date('d.m.Y H:i:s',time()); ?>" readonly="readonly" /> Tarih Saat<br />

<input name="file" id="file" type="file" />
<select class="textbox" style="height:30px; width:307px;" name="kategori" id="kategori">
	<option value="0">Seçiniz...</option>
<?php
	foreach ($categories as $c)
	{
		if ($c['is_notice'] == 0)
		{
			echo '<option value="' . $c['c_id'] . '">' . $c['category_name'] . '</option>';
		}
	}
?>
</select> Kategori
<input class="textbox" type="text" name="captcha" id="captcha"/> Güvenlik Kodu <img src="<?php echo base_url('captcha/draw_captcha'); ?>" style="vertical-align: middle;"/>
<br />
<textarea name="mesaj" id="mesaj"></textarea>

<input class="buton" id="submitbutton" type="submit" value="Haberi Gönder" name="submitbutton" />
</form>
</div>
<?php } ?>

</div>
