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
        plugins : "lists,pagebreak,style,layer,advhr,noneditable,nonbreaking,xhtmlxtras,insertdatetime,",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,insertdate,inserttime",
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

	$('#contact_return').hide();
		
	$("#submitbutton").click(function () {
		var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" /> Lütfen bekleyiniz!';
		
		$('#contact_return').show();
		$('#contact_return').html(loading);
		
		var isim = $('#isim').val();
		var email = $('#email').val();
		var konu = $('#konu').val();
		var captcha = $('#captcha').val();
		tinyMCE.triggerSave();
		var mesaj = $('#mesaj').val();
		
		if (isim == '')
		{
			$('#contact_return').html('HATA: İsim alanı boş bırakılamaz!');
			$('#contact_return').delay(5000).hide(1000);
			return false;
		}
		else if (email == '') 
		{
			$('#contact_return').html('HATA: Email alanı boş bırakılamaz!');
			$('#contact_return').delay(5000).hide(1000);
			return false;
		}
		else if (konu == 0) 
		{
			$('#contact_return').html('HATA: İletişim nedeni mutlaka seçilmeli!');
			$('#contact_return').delay(5000).hide(1000);
			return false;
		}
		else if (captcha == '')
		{
			$('#contact_return').html('HATA: Güvenlik kodu alanı boş bırakılamaz!');
			$('#contact_return').delay(5000).hide(1000);
			return false;
		}
		else if (mesaj == '')
		{
			$('#contact_return').html('HATA: Mesaj alanı boş bırakılamaz!');
			$('#contact_return').delay(5000).hide(1000);
			return false;
		}
		else
		{
			var form_data = $('form#contact').serialize();
			// Verileri gönderelim ve verileri alalım :)
			$.ajax({
				type: "POST",
				url: "/pages/contact_save",
				data: form_data,
				success: function(msg)
				{
					if (msg=="ok")
					{
						$('#contact_return').html("TEŞEKKÜRLER! İletiniz başarıyla gönderildi. Yönlendiriliyorsunuz...");
						$('#contact').get(0).reset();
						setTimeout(window.location="<?php echo base_url(); ?>",3000);
					}
					else
					{
						$('#contact_return').html(msg);
						//$('#contact_return').delay(5000).hide(1000);
					}
				}
			});
		}
		
	});	// submitbutton end
}); // Document ready end
</script>
<div id="sol">
  <div id="navigasyon" style=" padding: 5px; border:1px solid #efefef;">
  <strong>Önemli Hatırlatma</strong><br />
- İletişim için lütfen sizden istenen tüm bilgileri eksiksiz doldurunuz. Kimlik bilgileri ve iletişim bilgileri doğru olmayan mesajlara cevap verilmeyecektir.<br />
- Lütfen gönderdiğiniz mesajlarda <strong>Türkçe Dil Kurallarına</strong> uyunuz. Aksi durumda mesajınıza cevap verilmeyecektir.</div>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;">

<div style="clear:both;"></div>
</div>
<div id="contact_return" class="guestbook_list"></div>
<div id="guestbook_list">
<form name="contact" id="contact">
<?php
if(!$fb_data['me'])
{
?>
<input class="textbox" type="text" name="isim" id="isim" /> Adınız Soyadınız
<input class="textbox" type="text" name="email" id="email" /> Email Adresiniz
<?php } else { ?>
<input class="textbox" type="text" name="isim" id="isim" value="<?php echo $fb_data['me']['name']; ?>" readonly="readonly" /> Adınız Soyadınız
<input class="textbox" type="text" name="email" id="email" value="<?php echo $fb_data['me']['email']; ?>" readonly="readonly" /> Email Adresiniz
<?php } ?>
<select class="textbox" name="konu" id="konu" style="height:28px; width:308px">
	<option value="0">Seçiniz</option>
    <option value="İstek">İstek</option>
    <option value="Öneri">Öneri</option>
    <option value="Şikayet">Şikayet</option>
</select> İletişim Nedeni
<input class="textbox" type="text" name="captcha" id="captcha"/> Güvenlik Kodu <img src="<?php echo base_url('captcha/draw_captcha'); ?>" style="vertical-align: middle;"/>
<br />
<textarea name="mesaj" id="mesaj"></textarea>

<input class="buton" id="submitbutton" type="button" value="İletişim Formunu Gönder" name="submitbutton" />
</form>
</div>
</div>