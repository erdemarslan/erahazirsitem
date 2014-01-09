<div id="sol">

<div id="guestbook_list" style="overflow:hidden;">
	<div id="foto" style="float:left; width:135px; height:100px;">
    	<img src="<?php echo base_url($album['album_cover']); ?>" width="134px" height="100px" border="none" />
    </div>
    
    <div id="icerik" style="float:right; width:460px;">
    	<div style="margin-bottom:5px;"><?php echo $album['album_name']; ?></div>
        <div style="margin-bottom:5px;"><?php echo date('d.m.Y H:i:s',$album['album_date']); ?></div>
        <div style="margin-bottom:5px;"><?php echo $album['album_desc']; ?></div>
        <div style="margin-bottom:5px;"><?php echo $numPhotos; ?> fotoğraf</div>
    </div>
    
</div>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>


<?php
	/**/
	if (is_array($photos))
	{
		$sira = 1;
		foreach ($photos as $photo)
		{
			if ($sira%3==0)
			{
				echo '<div style="float:right; margin-bottom:4px; border:solid 1px #999; padding:1px;"><a href="' . base_url('gallery/photo/' . $photo['id'] . '/view.html') . '"><img src="' . base_url($photo['photo_thumb']) . '"  width="200px" height="150px" /></a></div>';
			} else {
				echo '<div style="float:left; margin-right:4px; margin-bottom:4px; border:solid 1px #999; padding:1px;"><a href="' . base_url('gallery/photo/' . $photo['id'] . '/view.html') . '"><img src="' . base_url($photo['photo_thumb']) . '" width="200px" height="150px" /></a></div>';
			}
			
			//print_r($photo);
			$sira++;
		}
	} else {
		echo $photos;
	}
?>
<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>
<?php
	if (isset($page_list)) { echo $page_list; }
?>


</div>