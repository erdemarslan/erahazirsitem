<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Default Theme | Anasayfa</title>
<meta name="description" content="içerik">
<meta name="keywords" content="anahtar kelimeler">
<meta name="robots" content="index, follow">
<meta name="author" content="Erdem ARSLAN">
<meta name="revisit-after" content="7 days">
<link rel="shortcut icon" href="favicon.ico">

<!--css dosyaları -->
<link href="<?php echo theme('reset.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('style.css','css',true); ?>" rel="stylesheet" type="text/css">

<link href="http://localhost.era/template/default/css/reset.css" rel="stylesheet" type="text/css">
<link href="http://localhost.era/template/default/css/style.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans">

<!-- javascriptler -->
<script src="<?php echo theme('jQuery.js','js',true); ?>" type="text/javascript"></script>
<script src="<?php echo theme('jnewsticker.js','js',true); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('jquery_corolerfoloser.js','js',true); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('scroll.js','js',true); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('featuredbox.js','js',true); ?>"></script>
<script src="<?php echo theme('era.js','js',true); ?>" type="text/javascript"></script>

</head>

<body>

<div id="kapsa">

<div id="header">
<div class="header_alt">

<div class="slogan">Site Adı ve  Sloganı</div>

<div class="uyegiris"> 
	
    <div style="float:right; margin-bottom:5px;"><script type="text/javascript" src="<?php echo theme('clock.js','js',true); ?>" ></script></div>

<div style="clear:both;"></div>
</div>
<!-- Reklam Alan? -->
 
 
<div style="float:left; cursor:pointer; border:1px solid #e7e7e7; background-color:#fff; width:975px; padding:2px; margin:10px 0;">
	<a href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item('theme_logo'); ?>" alt="Logo" width="975px" height="160px" /></a>
</div>



<div style="clear:both;"></div>

<!-- Reklam Alan? -->

</div>
</div>

<div id="content"> 

<div id="content_alt">
<!-- Reklam Alan? -->
<div style="clear:both;"></div>
<!-- Reklam Alan? -->
<div id="sol">

<div style="clear:both;">
<div>
<ul id="duyurular" class="newsticker">
    <li><strong>[20 Mayıs 2012 Pazar]</strong> <a href="#">Deneme duyurusudur falan filan :)...</a></li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip...</li>
    <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum...</li>
    <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia...</li>
    <li>Bubble bubble ipsum dolor sit amet, consectetur adipisicing elit...</li>            
</ul> 
</div>

</div>



<!-- burası haberlerin fotoğraflıları olacak! -->
  <div class="border">
    <div class="featuredbox-wrapper" id="manset">
      <ul>
        <li>
          		<img src="<?php echo uploaded('image1.jpg'); ?>" alt="Image" width="620" height="300" />
       	  <div>Et harum quidem rerum</div>
                <div><img src="<?php echo base_url('timthumb.php?src=' . uploaded('thumb_image1.jpg',false) . '&w=120&h=60'); ?>" alt="Image"/></div>
            </li>
            <li>
                <img src="<?php echo uploaded('image2.jpg'); ?>" alt="Image" />
              <div>Omnis voluptas assumenda est</div>
                <div><img src="<?php echo base_url('timthumb.php?src=' . uploaded('thumb_image2.jpg',false) . '&w=120&h=60'); ?>" alt="Image"/></div>
            </li>
            <li>
            	<img src="<?php echo uploaded('image3.jpg'); ?>" alt="Image" />
              <div>Aut reiciendis voluptatibus maiores alias consequatur?</div>
                <div><img src="<?php echo base_url('timthumb.php?src=' . uploaded('thumb_image3.jpg',false) . '&w=120&h=60'); ?>" alt="Image"/></div>
            </li>
            <li>
            	<img src="<?php echo uploaded('image4.jpg'); ?>" alt="Image" />
              <div>Saepe eveniet ut et voluptates?</div>
                <div><img src="<?php echo base_url('timthumb.php?src=' . uploaded('thumb_image4.jpg',false) . '&w=120&h=60'); ?>" alt="Image"/></div>
            </li>
        </ul>
 	</div>
  </div>

<!-- Reklam Alan? -->

<div style="clear:both;"></div>




<div class="list_carousel" style="margin-top:0px; margin-bottom:15px;">

<div class="baslik">   
    <a href="/galeri" title="Fotoğraf Albümleri">Fotoğraf Albümleri</a> 
    <div style="float:right;">
    	<a id="prev2" href="#">&lt;</a>
        <a id="next2" href="#">&gt;</a>
    </div>
    <div class="clear"></div>
</div>


<div style="position: relative; overflow: hidden; margin: 0px; width: 620px; height: 140px;" class="caroufredsel_wrapper">
	<ul style="margin: 0px; float: none; position: absolute; top: 0px; left: 7.5px; width: 4114px; height: 140px;" id="vnoviwvw">

		<li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>
        
        <li style="margin-right: 6px;">
			<a href="#" title="Deneme Albümü">
			<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Fotoğrafı" title="Deneme Fotoğrafı" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">
            <br>
			<span style="float:left; width:100px;">Deneme Fotoğrafı</span>

			</a>
		</li>

	</ul>
</div>

<div class="clearfix"></div>					
</div>

<div class="clear"></div>


<!-- haberler sol taraf -->
<div class="haberlistele" style="float:left; width:47%; margin:10px 0px 5px 0px; height:130px; overflow:hidden;">
	<div style="color:#999; margin-bottom:5px; padding-bottom:5px; border-bottom:1px dotted #ccc;">
    	<span style="float:right; margin-right:0px; ">20 Mayıs 2012 Pazar</span>
        <span style="color:#c06; float:left; margin-right:0px; "><a href="#" title="Diğer Güncel Haberler" >
        <span style="color:#555; text-decoration:underline; ">Güncel</span> </a></span>
		<div class="clear">
    </div>
</div>
<div class="clear"></div>

<div style="float:left; margin:0px 5px 0 0;">
    <a href="#" title="Deneme Haberi">
    	<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Haberi" style="padding: 2px; background-color: rgb(255, 255, 255); border: 1px solid rgb(231, 231, 231);" align="left" border="0" height="75" width="100">
    </a>
</div>

<span class="bold">
	<a href="#" title="Deneme Haberi">Deneme Haberi</a>
</span>
<br>
<a href="#" title="Deneme Haberi">
<span style="color:#666;">Bu deneme haberidir. haber tamamen asparagas olup, tümüyle yalan ve yanlıştır. Sadece deneme amaçlı olduğundan da kimseye zarar vermemektedir.</span></a>
<div class="clear"></div>    
</div>


<!-- haberler sağ taraf -->
<div class="haberlistele" style="float:right; width:47%; margin:10px 0px 5px 0px; height:130px; overflow:hidden;">
	<div style="color:#999; margin-bottom:5px; padding-bottom:5px; border-bottom:1px dotted #ccc;">
    	<span style="float:right; margin-right:0px; ">20 Mayıs 2012 Pazar</span>
        <span style="color:#c06; float:left; margin-right:0px; "><a href="#" title="Diğer Güncel Haberler" >
        <span style="color:#555; text-decoration:underline; ">Güncel</span> </a></span>
		<div class="clear">
    </div>
</div>
<div class="clear"></div>

<div style="float:left; margin:0px 5px 0 0;">
    <a href="#" title="Deneme Haberi">
    	<img src="<?php echo uploaded('image_sa1213312.jpg'); ?>" alt="Deneme Haberi" style="padding: 2px; background-color: rgb(255, 255, 255); border: 1px solid rgb(231, 231, 231);" align="left" border="0" height="75" width="100">
    </a>
</div>

<span class="bold">
	<a href="#" title="Deneme Haberi">Deneme Haberi Budur Ark</a>
</span>
<br>
<a href="#" title="Deneme Haberi">
<span style="color:#666;">Bu deneme haberidir. haber tamamen asparagas olup, tümüyle yalan ve yanlıştır. Sadece deneme amaçlı olduğundan da kimseye zarar vermemektedir.</span></a>
<div class="clear"></div>    
</div>









</div>


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
            <?php echo $fb_data['me']['location']['name']; ?><br />
            <a href="<?php echo base_url('kullanicilar/bilgilerim'); ?>" title="Bilgilerim">Bilgilerim</a> | <a href="<?php echo $fb_data['logoutUrl']; ?>" title="Çıkış Yap">Çıkış Yap</a>
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
        
        <div class="liste" style="margin:1px;">
        	<a href="<?php echo base_url(); ?>" style="font-weight:bold;" title="Anasayfa">Anasayfa</a>
        </div>
        
        <div class="liste" style="margin:1px;">
        	<a href="<?php echo base_url(); ?>" style="font-weight:bold;" title="Anasayfa">Anasayfa</a>
        </div>
        
        <div class="liste" style="margin:1px;">
        	<a href="<?php echo base_url(); ?>" style="font-weight:bold;" title="Anasayfa">Anasayfa</a>
        </div>
        
        <div class="liste" style="margin:1px;">
        	<a href="<?php echo base_url(); ?>" style="font-weight:bold;" title="Anasayfa">Anasayfa</a>
        </div>
        
	</div>


<div class="clear"></div>


<!-- ultra menü -->
<ul class="tabs" style="margin-top:10px;">
	<div style=" background-color:#2d74c4; color:#fff; float:left; padding:6px 5px; font-weight:bold; font-family:Geneva, sans-serif; ">Yayınlanan Son 5 </div> 
	<li><a href="#tab1">Z. Defteri</a></li>
    <li><a href="#tab2">Köşe Yazıları</a></li>
</ul>

<div class="tab_container">

	<div id="tab1" class="tab_content">
    	<div class="liste" style="margin:2px; padding:5px;"><img src="<?php echo theme('firefox.png','image'); ?>" width="40px" height="40px" /> Selamlar</div>
        <div class="liste" style="margin:2px; padding:5px;">Def</div>
        <div class="liste" style="margin:2px; padding:5px;">Ghi</div>
        <div class="liste" style="margin:2px; padding:5px;">Jkl</div>
    </div>
    
    <div id="tab2" class="tab_content">
    	<div class="liste" style="margin:2px; padding:5px;">Lmn</div>
        <div class="liste" style="margin:2px; padding:5px;">Opr</div>
        <div class="liste" style="margin:2px; padding:5px;">Stu</div>
        <div class="liste" style="margin:2px; padding:5px;">Vyz</div>
    </div>

</div>

<!-- Reklam Alan? -->
<div style="clear:both;"></div>

<!-- Reklam Alan? -->

<div class="clear"></div>    
    
<div class="border" style="margin:10px 0;">
	<div class="baslik">Hava Durumu</div>
	<div class="liste" style="margin:2px; padding:5px; text-align:center;">sasa</div>
</div>

<div class="border" style="margin:10px 0;">
	<div class="baslik">İstatistikler</div>
	<div class="liste" style="margin:2px; padding:5px; text-align:center;">sasa</div>
</div>




</div><!--sag div sonu -->



<div style="clear:both;"></div>
<!--content_alt --></div>
</div>


<div id="footer">
<div style="clear:both;"></div>
	<div style="margin:20px auto 0px auto; padding:10px 5px 5px 5px; width:978px;">
    <div style="clear:both;"></div>
		<div class="altbaslik"><h1>Site Sahibiyle ilgili bilgi</h1></div>

		<div class="altyon"> 
			<a href="#top" title="Yukarı Çık">Yukarı Çık</a>
		</div>

		<div style="clear:both;"></div>


		<div class="altnot">
            Bu sitenin tüm hakları saklıdır. Era System v.2.0 

				<div style="clear:both;"></div>

			<a rel="dofollow" href="http://www.erdemarslan.com/" target="_blank" title="Erdem ARSLAN"><img src="<?php echo theme('era.png','image',true); ?>" alt="Erdem ARSLAN" longdesc="http://www.erdemarslan.com" style="float: right; margin: 5px 0pt 0pt;" border="0" height="32" width="100"></a>
        </div>
	</div>  
</div>

</div>
</body>
</html>