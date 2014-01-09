<div id="sol">

<?php

$say = count($albums);


if ($say > 0)
{
	
	$sayi = 1;
	foreach ($albums as $a)
	{
		echo '<div id="guestbook_list" style="overflow:hidden;">
	<div id="foto" style="float:left; width:135px; height:100px;">
    	<a href="' . base_url('gallery/album/' . $a['id']) . '/1/' . no_tr($a['album_name']) . '.html"><img src="' . base_url($a['album_cover']) . '" width="134px" height="100px" border="none" /></a>
    </div>
    
    <div id="icerik" style="float:right; width:460px;">
    	<div style="margin-bottom:5px; font-weight:bold;"><a href="' . base_url('gallery/album/' . $a['id']) . '/1/' . no_tr($a['album_name']) . '.html">' . $a['album_name'] . '</a></div>
        <div style="margin-bottom:5px;">' . date('d.m.Y H:i:s',$a['album_date']) . '</div>
        <div style="margin-bottom:5px;">' . $a['album_desc'] . '</div>
		<div style="margin-bottom:5px;"><strong>' . $a['numPhotos'] . '</strong> fotoğraf</div>
    </div>
    
</div>';
	
		if ($sayi < $say)
		{
			echo '<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>';
		}
		$sayi++;
	
	}
} else {
	echo 'Şuan için hiç fotoğraf albümü ve fotoğraf eklemedik!';
}

?>



</div>