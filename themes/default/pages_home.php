<div id="sol">

<div style="clear:both;">
<div>
<ul id="duyurular" class="newsticker">
<?php
	if (count($notices) == 0)
	{
		echo '<li>Yayında olan duyuru yok!</li><li></li> ';
	} else {
		//$cat_name = $notices['category_name'];
		//unset($notices['category_name']);
		if (count($notices) == 1) { $li = '<li></li>'; } else { $li = '';}
		foreach ($notices as $n)
		{
			echo '<li><strong>[' . newsDate($n['date'],false) . ']</strong> <a href="' . base_url('news/read/' . $n['category'] . '-' . no_tr($n['category_name']) . '/' . $n['id'] . '-' . no_tr($n['title']) . '.html') . '">' . $n['title'] . '</a></li>' . $li;
		}
	}
?>          
</ul> 
</div>

</div>

<?php
// haberleri resimli ve resimsiz kısım olarak ikiye ayır!
if (count($news) == 0)
{
	$news_headline	= array();
	$news_middle	= array();
} else {
	$news_headline	= array();
	$news_middle	= array();
	$s = 1;
	foreach ($news as $value)
	{
		if ($s < 5)
		{
			$news_headline[] = $value;
		} else {
			$news_middle[] = $value;
		}
		$s++;
	}
}

// Sürmanşeti ver - resimli olanlar
if (count($news_headline) > 0)
{
?>
<!-- burası haberlerin fotoğraflıları olacak! -->
  <div class="border">
  	<div class="description">
    <div class="featuredbox-wrapper" id="manset">
      <ul>
            <?php
			foreach ($news_headline as $nh)
			{
				echo '<li> <a href="' . base_url('news/read/' . $nh['category'] . '-' . no_tr($nh['category_name']) . '/' . $nh['id'] . '-' . no_tr($nh['title']) . '.html') . '"><img src=" ' . uploaded($nh['picture']) . '" alt="' . $nh['title'] . '" width="620" height="300px" /></a> <div>' . $nh['title'] . '</div> <div><img src="' . base_url('timthumb.php?src=' . uploaded($nh['picture'],false) . '&w=120&h=60') . '" alt="' . $nh['title'] . '"/></div> </li>' . "\n\r";
			}
			?>
        </ul>
 	</div>
    </div>
  </div>
<?php
}
?>
<!-- Reklam Alan? -->
<div style="clear:both;"></div>



<?php
	if (is_array($galleries) AND count($galleries) > 0)
	{
?>

<div class="list_carousel" style="margin-top:0px; margin-bottom:15px;">

<div class="baslik">   
    <a href="<?php echo base_url('gallery'); ?>" title="Fotoğraf Albümleri">Fotoğraf Albümleri</a> 
    <div style="float:right;">
    	<a id="prev2" href="#">&lt;</a>
        <a id="next2" href="#">&gt;</a>
    </div>
    <div class="clear"></div>
</div>


<div style="position: relative; overflow: hidden; margin: 0px; width: 620px; height: 140px;" class="caroufredsel_wrapper">
	<ul style="margin: 0px; float: none; position: absolute; top: 0px; left: 7.5px; width: 4114px; height: 140px;" id="vnoviwvw">

		
        <?php
			foreach ($galleries as $gal)
			{
				echo '<li style="margin-right: 6px;">';
				echo '<a href="' . base_url('gallery/album/' . $gal['id'] . '/0/' . no_tr($gal['album_name']) . '.html') . '" title="' . $gal['album_name'] . '">';
				echo '<img src="' . base_url($gal['album_cover']) . '" alt="' . $gal['album_name'] . '" title="' . $gal['album_name'] . '" style="padding: 5px; background-color: rgb(255, 255, 255); border: 1px solid rgb(223, 223, 223); margin-bottom: 5px;" height="75" width="100">';
				echo '<br />';
				echo '<span style="float:left; width:100px;">' . $gal['album_name'] . '</span>';
				echo '</a>';
				echo '</li>';
			}
		?>

	</ul>
</div>

<div class="clearfix"></div>					
</div>

<?php
	}
?>





<div class="clear"></div>

<?php
if (count($news_middle) > 0)
{
	$sayi = 0;
	foreach ($news_middle as $nm)
	{
		if ($sayi%2 == 0)
		{
			echo '<div class="haberlistele" style="float:left; width:47%; margin:10px 0px 5px 0px; height:128px; overflow:hidden;">';
		} else {
			echo '<div class="haberlistele" style="float:right; width:47%; margin:10px 0px 5px 0px; height:128px; overflow:hidden;">';
		}
		?>

	<div style="color:#999; margin-bottom:5px; padding-bottom:5px; border-bottom:1px dotted #ccc;">
    	<span style="float:right; margin-right:0px; "><?php echo newsDate($nm['date'],false); ?></span>
        <span style="color:#c06; float:left; margin-right:0px; "><a href="<?php echo base_url('news/category/0/' . $nm['category'] . '-' . no_tr($nm['category_name']) . '.html'); ?>" title="<?php echo $nm['category_name']; ?> Kategorisi">
        <span style="color:#555; text-decoration:underline; "><?php echo $nm['category_name']; ?></span> </a></span>
		<div class="clear">
    </div>
</div>
<div class="clear"></div>

<div style="float:left; margin:0px 5px 0 0;">
     <a href="<?php echo base_url('news/read/' . $nm['category'] . '-' . no_tr($nm['category_name']) . '/' . $nm['id'] . '-' . no_tr($nm['title']) . '.html');?>" title="<?php echo $nm['title']; ?>">
    	<img src="<?php echo uploaded($nm['picture']); ?>" alt="<?php echo $nm['title']; ?>" style="padding: 2px; background-color: rgb(255, 255, 255); border: 1px solid rgb(231, 231, 231);" align="left" border="0" height="75" width="100">
    </a>
</div>

<span class="bold">
	 <a href="<?php echo base_url('news/read/' . $nm['category'] . '-' . no_tr($nm['category_name']) . '/' . $nm['id'] . '-' . no_tr($nm['title']) . '.html');?>" title="<?php echo $nm['title']; ?>"><?php echo $nm['title']; ?></a>
</span>
<br>
 <a href="<?php echo base_url('news/read/' . $nm['category'] . '-' . no_tr($nm['category_name']) . '/' . $nm['id'] . '-' . no_tr($nm['title']) . '.html');?>" title="<?php echo $nm['title']; ?>">
<span style="color:#666;"><?php echo str_replace(array('<p>','</p>'),array('',''),$nm['news_content']); ?></span></a>
<div class="clear"></div>    
</div>

<?php
$sayi++;
}
}
?>

</div>