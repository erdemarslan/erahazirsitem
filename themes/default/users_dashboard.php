<script type="text/javascript">
$(document).ready(function(){

	$('#notify').hide();
	
	var loading = '<img src="<?php echo theme('loading.gif','image',true); ?>" /> Lütfen bekleyiniz!';
	var a = '<div id="navigasyon" style=" border:1px solid #efefef; padding:5px;">';
	var b = '<div style="clear:both;"></div></div>';
			
	$("#update_button").click(function () {
		
		
		$('#notify').show();
		$('#notify').html(a + loading + b);
		
		var form_data;
		// Verileri gönderelim ve verileri alalım :)
		$.ajax({
			type: "POST",
			url: "/users/update/<?php echo $fb_data['uid']; ?>",
			data: form_data,
			success: function(msg)
			{
				myAlert(msg);
				setTimeout("location.reload();",300);
			}
		});
	});	// updatebutton end
	
	
	$("#delete_button").click(function () {
		
		$('#notify').show();
		$('#notify').html(a + loading + b);
		
		x = myConfirm('Üyeliğinizi iptal etmek istiyor musunuz? Bu işlem sonucunda sistemdeki sizin adınıza olan herşeyin silineceğinin garantisi verilmez!');
		
		if (x)
		{
			var form_data;
			$.ajax({
				type: "POST",
				url: "/users/delete/<?php echo $fb_data['uid']; ?>",
				data: form_data,
				success: function(msg)
				{
					myAlert(msg);
					setTimeout(window.location="<?php echo $fb_data['logoutUrl']; ?>",300);
				}
			});
		} else {
			myAlert('Bizden ayrılmadığınız için teşekkür ederiz!');
			$('#notify').html('');
			$('#notify').hide();
			
		}
	});	// delete_button end
	
	
	
}); // Document ready end
</script>
<div id="sol">

<div class="haberbaslik">Üyelik Bilgilerim</div>

<div id="navigasyon" style="border:1px solid #efefef; width:292px; float:left; margin-right:3px; padding:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><strong>Facebook Verileri</strong></td>
    </tr>
  <tr>
    <td width="40%"><strong>Ad Soyad</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $fb_data['me']['name']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Email</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $fb_data['me']['email']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Doğum Tarihi</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php
    $dt = explode('/',$fb_data['me']['birthday']);
	echo $dt[1] . '.' . $dt[0] . '.' . $dt[2]; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Cinsiyet</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php
    if ($fb_data['me']['gender'] == 'male')
	{
		echo 'Erkek';
	} elseif ($fb_data['me']['gender'] == 'female')
	{
		echo 'Kadın';
	} else {
		echo 'Belirtilmemiş';
	}
	?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Web Sayfası</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%">
    <?php
		if (!isset($fb_data['me']['website']))
		{
			echo '';
		} else {
			$web = explode ("\r\n",$fb_data['me']['website']);
			echo $web[0];
		}
	?>
    </td>
  </tr>
  <tr>
    <td width="40%"><strong>Yer</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php if (isset($fb_data['me']['location']['name'])) { echo $fb_data['me']['location']['name']; } else { echo 'Belirtilmemiş'; } ?></td>
  </tr>
  
</table>

</div>

<div id="navigasyon" style="border:1px solid #efefef; width:292px; float:right; margin-left:3px; padding:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><strong>Bizde Kayıtlı Olan</strong></td>
    </tr>
  <tr>
    <td width="40%"><strong>Ad Soyad</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $user['name']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Email</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $user['email']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Doğum Tarihi</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo date('d.m.Y',$user['birtday']); ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Cinsiyet</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $user['sex']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Web Sayfası</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $user['website']; ?></td>
  </tr>
  <tr>
    <td width="40%"><strong>Yer</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="57%"><?php echo $user['location']; ?></td>
  </tr>
  
</table>
</div>
<div style="text-align:center">
<input class="buton" id="update_button" type="button" value="Bilgilerimi Facebook ile Güncelle" name="update_button" /> <input class="buton" id="delete_button" type="button" value="Üyeliğimi İptal Et!" name="delete_button" />
</div>
<div style="clear:both"></div>

<!--
<div id="navigasyon" style=" border:1px solid #efefef;">
<?php print_r($fb_data); ?>
<div style="clear:both;"></div>    
</div>
-->




<div style="clear:both;"></div>
<div style="border-top:1px dotted #ccc; margin-top:10px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"></div>

<div id="notify">
</div>



</div>