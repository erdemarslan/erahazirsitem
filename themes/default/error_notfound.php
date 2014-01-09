<div id="sol">

<div class="haberbaslik">SAYFA BULUNAMADI!</div>
<p>
Aradığınız sayfa sunucularımız üzerinde bulunamadı! Bu sayfa hiç oluşturulmamış olabileceği gibi, yayından da kaldırılmış olabilir. Bizler gerekli bilgileri topladık. Bu hatanın nedenlerini ve düzeltilmesi için gerekenleri araştıracağınız. Şu anda yapabilecekleriniz:<br /><br />1. Tarayıcınızın geri tuşuna basarak geldiğiniz sayfaya geri dönebilirsiniz.<br />2. <a href="<?php echo base_url('home'); ?>">Buraya</a> tıklayarak anasayfaya gidebilirsiniz.<br />3. <a href="<?php echo base_url('pages/sitemap'); ?>">Site haritamızı</a> görüntüleyebilirsiniz.
</p>



<div style="clear:both"></div>
<div style="border-top:1px dotted #ccc; margin-top:10px; padding-top:5px; padding-bottom:5px; text-align:left; color:#09f;">
<code>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td width="24%"><strong>Hata Nedeni</strong></td>
    <td width="76%"><?php echo $neden; ?></td>
  </tr>
  <tr>
  	<td width="24%"><strong>IP Adresiniz</strong></td>
    <td width="76%"><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
  </tr>
  <tr>
    <td><strong>Bulunamayan Sayfa</strong> </td>
    <td><?php echo $url; ?></td>
  </tr>
  <tr>
    <td><strong>Bilgileriniz</strong> </td>
    <td><?php echo $this->agent->platform() . ' - ' . $this->agent->browser() . ' ' . $this->agent->version(); ?></td>
  </tr>
</table>    
</code>
<div style="clear:both;"></div>
</div>

</div>
