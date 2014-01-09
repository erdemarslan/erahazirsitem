<script type="text/javascript" language="javascript" src="<?php echo theme('jwplayer.js','js',true); ?>"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1&appId=372655852782830";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div id="sol">

<div id="youtubevideoizle">Video yükleniyor ...</div>

<script type="text/javascript">
	jwplayer("youtubevideoizle").setup({
	flashplayer: "<?php echo theme('player.swf','js',true); ?>",
	file: "http://www.youtube.com/watch?v=<?php echo $video['video_id']; ?>",
	image: "<?php echo $video['video_thumb']; ?>",
	height: 400,
	width: 620,
	autostart: true,
	provider: 'youtube',
	/*
	// Eğer bir sonraki videoya falan geç işlemi yapılırsa :) çok anlamlı olacaktır.
	events : {
		onComplete : function(){
			videoyu_begendik_mi();
		}
	}
	*/
	});
</script>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>

<?php
 echo '<strong>' . $video['video_title'] . '</strong> | ' . calc_time($video['video_length']) . ' | ' . $video['video_desc'];
?>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>

<!-- facebook ile yorumlar :) -->
<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-num-posts="10" data-width="620"></div>

</div>