<?php
Class Elog
{
	protected $file		= 'logs.log';
	protected $folder	= './logs/';
	private $path;
	
	public function __construct($file=null,$folder=null)
	{		
		if ($file === null)
		{
			$this->file = $this->file;
		} else {
			$this->file = $file;
		}
		
		if ($folder === null)
		{
			$this->folder = $this->folder;
		} else {
			$this->folder = $folder;
		}
		
		$this->path = $this->folder . $this->file;
	}
	
	# veriyi dosyaya yazar!
	public function write( $str = '', $type = 0 )
	{
		if ($str == '')
		{
			$data = '[' . date('d.m.Y H:i:s',time()) . '] [' . $this->error_type($type) . '] Hata nedeni bulunamadı!' . "\r";
		} else {
			$data = '[' . date('d.m.Y H:i:s',time()) . '] [' . $this->error_type($type) . '] ' . $str . "\r";
		}
		
		$fp = @fopen($this->path,"a");
        fputs($fp,$data);
        fclose($fp);
	}
	
	# Hata tiplerini oluşturur!
	private function error_type($d)
	{
		switch ($d)
		{
			default:
			case 0:
				$r = 'ERROR';
			break;
			
			case 1:
				$r = 'WARNING';
			break;
			
			case 2:
				$r = 'INFO';
			break;
		}
		return $r;
	}
}
?>