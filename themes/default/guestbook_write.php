<script type="text/javascript" src="<?php echo base_url('tinymce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">
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
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,hr,emotions,insertdate,inserttime",
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

$(document).ready(function(){

	$('#guestbook_return').hide();
		
	$("#submitbutton").click(function () {
		var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" /> Lütfen bekleyiniz!';
		
		$('#guestbook_return').show();
		$('#guestbook_return').html(loading);
		
		var isim = $('#isim').val();
		var email = $('#email').val();
		var captcha = $('#captcha').val();
		tinyMCE.triggerSave();
		var mesaj = $('#mesaj').val();
		
		if (isim == '')
		{
			$('#guestbook_return').html('HATA: İsim alanı boş bırakılamaz!');
			$('#guestbook_return').delay(5000).hide(1000);
			return false;
		}
		else if (email == '') 
		{
			$('#guestbook_return').html('HATA: Email alanı boş bırakılamaz!');
			$('#guestbook_return').delay(5000).hide(1000);
			return false;
		}
		else if (captcha == '')
		{
			$('#guestbook_return').html('HATA: Güvenlik kodu alanı boş bırakılamaz!');
			$('#guestbook_return').delay(5000).hide(1000);
			return false;
		}
		else if (mesaj == '')
		{
			$('#guestbook_return').html('HATA: Mesaj alanı boş bırakılamaz!');
			$('#guestbook_return').delay(5000).hide(1000);
			return false;
		}
		else
		{
			var form_data = $('form#guestbook').serialize();
			// Verileri gönderelim ve verileri alalım :)
			$.ajax({
				type: "POST",
				url: "/guestbook/save",
				data: form_data,
				success: function(msg)
				{
					if (msg=="ok")
					{
						$('#guestbook_return').html("TEŞEKKÜRLER! İletiniz başarıyla gönderildi. Yönlendiriliyorsunuz...");
						setTimeout(window.location="<?php echo base_url('guestbook'); ?>",3000);
					}
					else
					{
						$('#guestbook_return').html(msg);
						$('#guestbook_return').delay(5000).hide(1000);
					}
				}
			});
		}
		
	});	// submitbutton end
}); // Document ready end
</script>
<div id="sol">
<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
	
    <div style="margin-top:4px; float:right; font-weight:bold;">
    	<a href="<?php echo base_url('guestbook/read'); ?>">Defteri Oku &nbsp; </a>
    </div>    
	<div style="clear:both;"></div>
    
</div>
<div id="navigasyon" style=" padding: 5px; border:1px solid #efefef;">
<strong>Önemli Hatırlatma</strong><br />
- Facebook ile sitemize bağlanırsanız, göndereceğiniz iletiler otomatik olarak onaylanacaktır. Diğer durumlarda mesajlarınız yönetici onayından sonra yayınlanacaktır.<br />
- İletilerinizde fotoğraflarınızın çıkmasını istiyorsanız, Facebook ile giriş yaptıktan sonra ileti yazınız veya <a href="http://www.gravatar.com" target="_blank">http://www.gravatar.com</a> adresinden e-mail adresiniz için avatar servisini ücretsiz olarak açtırınız.</div>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;">

<div style="clear:both;"></div>
</div>
<div id="guestbook_return" class="guestbook_list"></div>
<div id="guestbook_list">
<form name="guestbook" id="guestbook">
<?php
if(!$fb_data['me'])
{
?>
<input type="hidden" name="face_id" id="face_id" value="empty" />
<input class="textbox" type="text" name="isim" id="isim" /> Adınız Soyadınız
<input class="textbox" type="text" name="email" id="email" /> Email Adresiniz
<input class="textbox" type="text" name="website" id="website" value="http://" /> Web Siteniz
<?php } else {
if (isset($fb_data['me']['website']))
{
	$w = explode("\r\n",$fb_data['me']['website']); 
	$w = $w[0];
} else {
	$w = '';
}
?>
<input type="hidden" name="face_id" id="face_id" value="<?php echo $fb_data['me']['id']; ?>" />
<input class="textbox" type="text" name="isim" id="isim" value="<?php echo $fb_data['me']['name']; ?>" readonly="readonly" /> Adınız Soyadınız
<input class="textbox" type="text" name="email" id="email" value="<?php echo $fb_data['me']['email']; ?>" readonly="readonly" /> Email Adresiniz
<input class="textbox" type="text" name="website" id="website" value="<?php echo $w; ?>" /> Web Siteniz
<?php } ?>
<input class="textbox" type="text" name="captcha" id="captcha"/> Güvenlik Kodu <img src="<?php echo base_url('captcha/draw_captcha'); ?>" style="vertical-align: middle;"/>
<br />
<textarea name="mesaj" id="mesaj"></textarea>

<input class="buton" id="submitbutton" type="button" value="Ziyaretçi Defterine Yaz" name="submitbutton" />
</form>
</div>
</div>