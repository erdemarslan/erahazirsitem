<div id="sol">

<?php

if (isset($videos))
{
	$say = count($videos);

	if ($say > 0)
	{
		
		$sayi = 1;
		foreach ($videos as $v)
		{
			echo '<div id="guestbook_list" style="overflow:hidden;">
		<div id="foto" style="float:left; width:135px; height:100px;">
			<a href="' . base_url('video/watch/' . $v['id']) . '/' . no_tr($v['video_title']) . '.html"><img src="' . $v['video_thumb'] . '" width="134px" height="100px" border="none" /></a>
		</div>
	
		<div id="icerik" style="float:right; width:460px;">
			<div style="margin-bottom:5px; font-weight:bold;"><a href="' . base_url('video/watch/' . $v['id']) . '/' . no_tr($v['video_title']) . '.html">' . $v['video_title'] . '</a></div>
			<div style="margin-bottom:5px;">' . calc_time($v['video_length']) . '</div>
			<div style="margin-bottom:5px;">' . $v['video_desc'] . '</div>
			
		</div>
		
	</div>';
		
			if ($sayi < $say)
			{
				echo '<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>';
			}
			$sayi++;
		
		}
	} else {
		echo 'Bu sayfada hiç bir video yok!';
	}
	
	
} else {
	echo 'Yüklenmiş hiçbir video bulamadık!';
}
if (isset($lists) && $lists != '')
{
	echo '<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;"><div style="clear:both;"></div></div>';
	echo $lists;
}
?>

</div>