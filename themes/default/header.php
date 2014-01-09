<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $meta['title'] . ' - ' . $this->config->item('site_title'); ?></title>
<meta name="description" content="<?php echo $meta['description'] . ' ' . $this->config->item('site_desc'); ?>">
<meta name="keywords" content="<?php echo $meta['keywords'] . ', ' . $this->config->item('site_keywords'); ?>">
<meta name="robots" content="index, follow">
<meta name="author" content="Erdem ARSLAN">
<meta name="revisit-after" content="7 days">
<!-- css dosyaları -->
<link href="<?php echo theme('reset.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('style.css','css',true); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo theme('lightbox.css','css',true); ?>" rel="stylesheet" type="text/css">
<!--
<link href="http://localhost.era/template/default/css/reset.css" rel="stylesheet" type="text/css">
<link href="http://localhost.era/template/default/css/style.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans">
-->
<!-- javascriptler -->
<script src="<?php echo theme('jQuery.js','js',true); ?>" type="text/javascript"></script>
<script src="<?php echo theme('jnewsticker.js','js',true); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('jquery_corolerfoloser.js','js',true); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('scroll.js','js',true); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo theme('featuredbox.js','js',true); ?>"></script>
<script src="<?php echo theme('plusone.js','js',true); ?>" type="text/javascript">
  {lang : "tr", "parsetags": "explicit"}
</script>
<script src="<?php echo theme('myDialog.js','js',true); ?>" type="text/javascript"></script>
<script src="<?php echo theme('era.js','js',true); ?>" type="text/javascript"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33551133-1']);
  _gaq.push(['_setDomainName', 'derenti.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>

<div id="kapsa">

<div id="header">
<div class="header_alt">

<div class="slogan"><?php echo $this->config->item('site_slogan'); ?></div>

<div class="uyegiris"> 
	
    <div style="float:right; margin-bottom:5px;"><script type="text/javascript" src="<?php echo theme('clock.js','js',true); ?>" ></script></div>

<div style="clear:both;"></div>
</div>
<!-- Reklam Alan? -->
 
<div style="float:left; cursor:pointer; border:1px solid #e7e7e7; background-color:#fff; width:975px; padding:2px; margin:10px 0;">
	<a href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item('theme_logo'); ?>" alt="Logo" width="975px" height="200px" /></a>
</div>

<div style="clear:both;"></div>

<!-- Reklam Alan? -->

</div>
</div>

<div id="content"> 

<div id="content_alt">
<!-- Reklam Alan? -->
<div style="clear:both;"></div>
<!-- Reklam Alan? -->