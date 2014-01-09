<div id="sol">

<div class="haberbaslik"><?php echo $baslik; ?></div>
	
<?php echo $icerik; ?>


<div style="float:right; padding-top:4px; padding-right:10px;">
Bu sayfa <strong><?php echo $hit; ?></strong> kez görüntülendi. 
</div>
<div style="clear:both"></div>
<div style="border-top:1px dotted #ccc; margin-top:10px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;">

<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
	
    <div style="margin-top:4px; float:right">
    <div class="g-plusone" data-size="small" data-href="http://www.erdemarslan.com"></div>
    </div>
    
    <div style="margin-top:4px; float:right">
    <a target="_blank" href="https://twitter.com/share?url=<?php echo urlencode(base_url($this->uri->uri_string())); ?>"><img src="<?php echo theme('s_twitter.png','image',true); ?>" /></a>
    </div>
    
    <div style="margin-top:4px; float:right">
    <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(base_url($this->uri->uri_string())); ?>&t=<?php echo urlencode($baslik); ?>"><img src="<?php echo theme('s_facebook.png','image',true); ?>" /></a>
    </div>

	<div style="clear:both;"></div>
    
</div>





<div style="clear:both;"></div>
</div>

</div>
