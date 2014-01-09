<!DOCTYPE html>
<html lang="en">
<head>
<title>You IP Address Banned! | IP Adresiniz Engellendi!</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #F00;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1>Your IP Address Banned! | IP Adresiniz Yasaklandı!</h1>
        <div style="padding-left:10px; padding-right:10px;">
        <code>
        
        <?php
			$this->session->userdata('ban_time') == 0 ? $en_time = 'forever.' : $en_time = 'until ' . date('d.m.Y H:i:s',$this->session->userdata('ban_time')). '.';
		?>
		Your ip address is <?php echo $this->session->userdata('ban_ip'); ?> has banned from this web site <?php echo $en_time; ?> If you think that is a mistake, please contact the site administration.
		<hr />
        <?php
			$this->session->userdata('ban_time') == 0 ? $tr_time = 'sonsuza kadar' : $tr_time = date('d.m.Y H:i:s',$this->session->userdata('ban_time')) . ' tarihine kadar';
		?>
        IP adresiniz  <?php echo $this->session->userdata('ban_ip'); ?> bu siteden <?php echo $tr_time; ?> uzaklaştırıldınız. Eğer bir hata olduğunu düşünüyorsanız, lütfen site yönetimi ile iletişime geçiniz.
        </code>
        </div>
	</div>
</body>
</html>