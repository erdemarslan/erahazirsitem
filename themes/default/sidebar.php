<div id="sag">

<div class="border">
	<div class="baslik">Facebook ile Oturum Aç</div>
 	<div>
	  <?php if(!$fb_data['me']): ?>
      <div class="liste" style="text-align:center"><a class="btn-auth btn-facebook" href="<?php echo $fb_data['loginUrl']; ?>"><b>Facebook</b> ile Giriş Yap</a></div>
		
      <?php else: ?>
      <div style="margin: 5px; height:50px;">
      	<div style="float:left; width:70%">
        	<strong><?php echo $fb_data['me']['name']; ?></strong><br />
            <?php isset($fb_data['me']['location']['name']) ? $loc = $fb_data['me']['location']['name'] : $loc = 'Belirtilmemiş';
			echo $loc;
			 ?><br />
            <a href="<?php echo base_url('users/dashboard'); ?>" title="Bilgilerim">Bilgilerim</a> | <a href="<?php echo base_url('news/write'); ?>">Haber Ekle</a> | <a href="<?php echo $fb_data['logoutUrl']; ?>" title="Çıkış Yap">Çıkış Yap</a>
        </div>
        <div style="float:right"><img src="https://graph.facebook.com/<?php echo $fb_data['uid']; ?>/picture" alt="" class="pic" /></div>
      </div>
      <?php endif; ?>
    </div>
  </div>

<div class="clear"></div>
    
<div class="border" style="margin:10px 0;">
	<div class="baslik">Menü</div>
		
        <div class="liste" style="margin:1px;">
        	<a href="<?php echo base_url(); ?>" style="font-weight:bold;" title="Anasayfa">Anasayfa</a>
        </div>
        
        <?php
			foreach ($menu as $m)
			{
				echo '<div class="liste" style="margin:1px;">';
				echo '<a href="' . base_url($m['url']) . '" target="' . $m['target'] .'" style="font-weight:bold;" title="' . $m['name'] . '">' . $m['name'] . '</a>';
				echo '</div>';
			}
		?>        
  </div>


<div class="clear"></div>



<div class="border" style="margin:10px 0;">
	<div class="baslik">Ziyaretçi Defterinde Son Durum</div>
    	<?php
			if (count($last5guestbookentry) == 0)
			{
				echo '<div class="liste" style="margin:2px; padding:5px;">Ziyaretçi defterinde hiç yazı yok!</div>';
			} else {
				foreach ($last5guestbookentry as $gb)
				{
					echo '<div class="liste" style="margin:2px; overflow:hidden; height:50px; padding-right:5px; padding-top:5px; padding-bottom:5px; padding-left:55px; background:url(' . gravatar($gb['photo'],$gb['email']) . ') no-repeat left;"><strong>[' . $gb['name'] . ']</strong> ' . str_replace(array('<p>','</p>'),array('','<br />'),$gb['message']) . '</div>';
				}
			}
		?>
</div>

<!-- Reklam Alan? -->
<div style="clear:both;"></div>

<!-- Reklam Alan? -->

<div class="clear"></div>

<?php
if ($this->config->item('weather_active') == 1)
{ ?>
<div class="border" style="margin:10px 0;">
	<div class="baslik"><?php echo $havadurumu['Şimdi']['yer']; ?> için Hava Durumu</div>
	<div class="weather">		
		<img src="<?php echo $havadurumu['Şimdi']['resim_kucuk']; ?>" alt="<?php echo $havadurumu['Şimdi']['aciklama']; ?>" title="<?php echo 'Durum: ' . $havadurumu['Şimdi']['aciklama'] . ' Sıcaklık: ' . $havadurumu['Şimdi']['derece'] . ' Nem: %' . $havadurumu['Şimdi']['nem'] . ' Rüzgar: ' . $havadurumu['Şimdi']['ruzgar']; ?>" />
        <div><strong>Şimdi</strong></div>
		<span class="condition">
			<?php echo $havadurumu['Şimdi']['derece'] . ', %' . $havadurumu['Şimdi']['nem'] . ', ' . $havadurumu['Şimdi']['ruzgar']; ?>		</span>
	</div>
    <?php
    foreach($havadurumu as $k => $v)
	{ 
		if ($k != 'Şimdi')
		{?>
        <div class="weather">		
            <img src="<?php echo $v['resim_kucuk']; ?>" alt="<?php echo $v['aciklama']; ?>" title="<?php echo 'Durum: ' . $v['aciklama'] . ' En Az: ' . $v['enaz'] . ' En Çok: ' . $v['encok']; ?>" />
            <div><strong><?php echo $k; ?></strong></div>
            <span class="condition">
                <?php echo $v['enaz']; ?> - <?php echo $v['encok'] . ', ' . $v['aciklama']; ?></span>
        </div>
	<?php 
		}
	}
	?>
</div>

<?php } ?>

<?php
	if ($this->config->item('prayer_active') == 1 && $namaz['durum'] == 'basarili' && count($namaz['veri']) > 0 )
	{
		$namaz = $namaz['veri'];
		echo '<div class="border" style="margin:10px 0;">'."\n\r";
		echo '<div class="baslik">' . $namaz['sehiradi'] . ' için Namaz Vakitleri [' . date('d.m.Y',time()) . ']</div>'."\n\r";
		echo '<div class="liste" style="margin:2px; padding:5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td colspan="4"><div align="center"><strong>' . $namaz['hicritarih'] . '</strong></div></td>
			</tr>
		  <tr>
			<td width="20%"><strong>İmsak</strong></td>
			<td width="30%">' . $namaz['imsak'] . '</td>
			<td width="20%"><strong>Güneş</strong></td>
			<td width="30%">' . $namaz['gunes'] . '</td>
		  </tr>
		  <tr>
			<td><strong>Öğle</strong></td>
			<td>' . $namaz['ogle'] . '</td>
			<td><strong>İkindi</strong></td>
			<td>' . $namaz['ikindi'] . '</td>
		  </tr>
		  <tr>
			<td><strong>Akşam</strong></td>
			<td>' . $namaz['aksam'] . '</td>
			<td><strong>Yatsı</strong></td>
			<td>' . $namaz['yatsi'] . '</td>
		  </tr>
		  <tr>
			<td><strong>Kıble</strong></td>
			<td>' . $namaz['kiblesaati'] . '</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</div>'."\n\r";
	echo '</div>';
	}
?>



<div class="border" style="margin:10px 0;">
	<div class="baslik">İstatistikler</div>
	<div class="liste" style="margin:2px; padding:5px;"><strong>Online :</strong> <?php echo $stats['online']; ?></div>
    <div class="liste" style="margin:2px; padding:5px;"><strong>Bugün :</strong> <?php echo $stats['today']; ?></div>
    <div class="liste" style="margin:2px; padding:5px;"><strong>Toplam :</strong> <?php echo $stats['total']; ?></div>
    <div class="liste" style="margin:2px; padding:5px;"><strong>IP :</strong> <?php echo $stats['user']['ip']; ?> |  <?php echo $stats['user']['country']; ?>  <img src="<?php echo $stats['user']['flag']; ?>"  /></div>
    <div class="liste" style="margin:2px; padding:5px;"><strong>ISP :</strong> <?php echo $stats['user']['isp']; ?></div>
</div>
</div>