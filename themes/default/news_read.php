<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1&appId=372655852782830";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="sol">

<div class="haberbaslik"><?php echo $post['title']; ?></div>

<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
<div style="float:right; padding-top:4px; padding-right:10px;">
<?php
	$post['news_writer'] == 'admin' ? $info = 'Okunma : <strong>' . $post['hit'] . '</strong> | Kategori : <a href="' . base_url('news/category/0/' . $post['c_id'] . '-' . no_tr($post['category_name']) .'.html') . '"><strong>' . $post['category_name'] . '</strong></a>' : $info = 'Yazar : <a href="http://www.facebook.com/' . $post['news_writer_facebookid'] . '" target="_blank" rel="nofollow"><strong>' . $post['news_writer'] . '</strong></a> | Okunma : <strong>' . $post['hit'] . '</strong> | Kategori : <a href="' . base_url('news/category/0/' . $post['c_id'] . '-' . no_tr($post['category_name']) .'.html') . '"><strong>' . $post['category_name'] . '</strong></a>';
	
	echo $info;
?>
</div>
</div>



<?php echo str_replace(array('<p>','</p>'),array('','<br /><br />'),$post['news_content']); ?>

<br /><br />

<div style="clear:both"></div>


<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
	
    <div style="margin-top:4px; float:right">
    <div class="g-plusone" data-size="small" data-href="http://www.erdemarslan.com"></div>
    </div>
    
    <div style="margin-top:4px; float:right">
    <a target="_blank" href="https://twitter.com/share?url=<?php echo urlencode(base_url($this->uri->uri_string())); ?>"><img src="<?php echo theme('s_twitter.png','image',true); ?>" /></a>
    </div>
    
    <div style="margin-top:4px; float:right">
    <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(base_url($this->uri->uri_string())); ?>&t=<?php echo urlencode($post['title']); ?>"><img src="<?php echo theme('s_facebook.png','image',true); ?>" /></a>
    </div>

	<div style="clear:both;"></div>
    
</div>





<div style="clear:both;"></div>
<div style="border-top:1px dotted #ccc; margin-top:10px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"></div>



<br />
<?php
if (count($related) > 0)
{
	echo '<div class="haberbaslik"><strong>BENZER YAZILAR</strong></div>';
	echo '<div id="navigasyon" style="border:1px solid #efefef;">';
	foreach ($related as $r)
	{
		echo '<div class="liste"><a href="' . base_url('news/read/' . $r['c_id'] . '-' . no_tr($r['category_name']) . '/' . $r['id'] . '-' . no_tr($r['title']) . '.html') . '">' . $r['title'] . '</a></div>';
	}
	echo '</div>';
}
?>

<div class="haberbaslik"><strong>YORUMLAR</strong></div>
<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-num-posts="10" data-width="620"></div>


</div>