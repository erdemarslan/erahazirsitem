<div id="sol">
<div id="navigasyon" style="height:25px; border:1px solid #efefef;">
	
    <div style="margin-top:4px; float:right; font-weight:bold;">
    	<a href="<?php echo base_url('guestbook/write'); ?>">Deftere Yaz &nbsp; </a>
    </div>    
	<div style="clear:both;"></div>
    
</div>

<div style="border-top:1px dotted #ccc; margin-top:5px; padding-top:5px; padding-bottom:5px; text-align:right; color:#09f;">

<div style="clear:both;"></div>
</div>

<?php
	if (is_array($guestbook))
	{
		foreach ($guestbook as $g)
		{
		?>
<div id="guestbook_list" style="background:url(<?php echo gravatar($g['photo'],$g['email']); ?>) no-repeat;">
    <div class="guestbook_name"><?php echo $g['name']; ?></div>
    <div class="guestbook_date"><?php echo guestbook_date_webpage($g['date'],$g['webpage']); ?></div>
    <div class="guestbook_agent"><?php echo guestbookAgent($g['user_agent']); ?></div>
    <div  class="guestbook_message"><?php echo str_replace(array('<p>','</p>'),array('','<br />'),$g['message']); ?></div>
</div>
        <?php
		}
	} else {
		echo 'Ziyaretçi defterine hiç kimse yazmamış. İlk sen <a href="' . base_url('guestbook/write') . '">yazabilirsin!</a>';
	}
	
if (isset($page_list)) echo '<div id="guestbook_list" style="text-align:center">' . $page_list . '</div>';
?>
</div>