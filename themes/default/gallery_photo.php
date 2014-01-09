<script type="text/javascript" language="javascript" src="<?php echo theme('lightbox.js','js',true); ?>"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1&appId=372655852782830";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="sol">

<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
	
    <div style="margin-top:4px; padding-left:3px; width:30%; float:left; font-weight:bold;">
   <?php
   		if ($prev != 'empty')
		{
			echo '<a href="' . $prev . '">Önceki Fotoğraf </a>';
		}
   ?>
    </div>
    
    <div style="margin-top:4px; width:38%; float:left; text-align:center; font-weight:bold;"><a href="<?php echo $photo['url']; ?>" rel="lightbox">Orjinal Boyut</a></div>
    
    <div style="margin-top:4px; padding-right:3px; width:30%; float:right; text-align:right; font-weight:bold;">
    <?php
   		if ($next != 'empty')
		{
			echo '<a href="' . $next . '">Sonraki Fotoğraf </a> ';
		}
   ?>
   </div>   
	<div style="clear:both;"></div>
    
</div>

<?php
//echo '<pre>';
//print_r($photo);
//echo '</pre>';

// Yükseklik ve genişlikleri hesaplayalım :)
$sw = 620;
$pw = $photo['width'];
$ph = $photo['height'];

# önce % kaç küçültçez onu bulalım
$x = @round((100*$sw)/$pw);
$sh = @round(($ph*$x)/100);
if ($next != 'empty')
{
	echo '<a href="' . $next . '"><img src="' . $photo['url'] . '" width="' . $sw . 'px" height="' . $sh . 'px" /></a>';
} else {
	echo '<img src="' . $photo['url'] . '" width="' . $sw . 'px" height="' . $sh . 'px" />';
}

?>



<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>

<!-- facebook ile yorumlar :) -->
<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-num-posts="10" data-width="620"></div>

</div>