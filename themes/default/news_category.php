<script type="text/javascript">
$(document).ready(function(){
	$("#submitbutton").click(function () {
		var select_value = $('#news_category_select').val();
		var url = '<?php echo base_url(); ?>news/category/0/' + select_value;
		//alert(url);
		window.location=url;
	});	// submitbutton end
}); // Document ready end
</script>
<div id="sol">
<div id="navigasyon" style="height:25px; padding:5px; border:1px solid #efefef;">
	
    <select name="news_category_select" id="news_category_select" style="height:25px; width:250px; border:1px solid #efefef; padding:2px;">
    	<option value="0-Tum-Haberler.html">Tüm Haberler</option>
        <?php
			if (count($categories) >0)
			{
				foreach($categories as $ct)
				{
					echo '<option value="' . $ct['c_id'] . '-' . no_tr($ct['category_name']) . '.html">' . $ct['category_name'] . '</option>';
				}
			}
		?>
        
    </select>
    <input type="button" name="submitbutton" id="submitbutton" value="Göster" />
	<div style="clear:both;"></div>
    
</div>

<div style="clear:both;"></div>
<div class="clear"></div>

<?php
if (count($news) > 0)
{
	$sayi = 0;
	foreach ($news as $nm)
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
} else {
	echo 'Bu kategoriye hiç içerik eklenmemiş!';
}
echo '<div>';
if (isset($page_list)) { echo $page_list; }
echo '</div>';
?>

</div>