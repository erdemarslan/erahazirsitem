<?php
Class Ecache
{
	static $cache		= true;				# cacheleme açık mı kapalı mı
	static $folder		= './';				# sitenin kök dizinine göre
	static $time		= 6;				# saat cinsinden
	static $log_level	= 1;				# log seviyesi 0-kapalı, 1-hata 2-hata+uyarı 3-hata+uyarı+bilgi
	static $file		= 'ecache.cache';	# cache dosyası
	static $class		= __CLASS__;
	
	private static $instance;
	private $variable = array();
	private $log;
	
	# Açılışı ayarlar !
	public function __construct($settings = array())
	{
		# Log ayarlarını yap!
		require_once 'elog.php';
		$this->log = new elog('ecache.log');
		if (self::$log_level == 3) { $this->log->write('Ecache Sınıfı oluşturuldu!',2); }
		
		if (count($settings) != 0)
		{
			self::settings($settings);
		}
	}
	
	# Kapanışta orjinal değerleri tekrar yerine koyarak, sınıfın hata vermesini engeller!
	public function __destruct()
	{
		$array = array(
				'cache'		=> true,
				'folder'	=> './cache/',
				'time'		=> 6,
				'log_level'	=> 0,
				'file'		=> 'ecache.cache'
			);
		self::settings($array);
	}
	
	/*
	 *
	 * ---------------------------------------------------------------------------------------
	 * Sınıfın direk çalıştırılan kısmı!
	 * ---------------------------------------------------------------------------------------
	 *
	 */
	
	
	/*
	 * public function readCache();
     * Cache dosyasındaki veriyi okur ve geri verir
     * @since v.1.0
	 * @return string;
     */
	public function readCache()
	{
		$data = @file_get_contents(self::$folder . self::$file);
		return $data;
	}
	
	
	/*
	 * public function writeCache($data);
     * cache dosyasına veriyi yazar
     * @since v.1.0
	 * @return boolean;
     */
	public function writeCache($data)
	{
		$fp = fopen( self::$folder . self::$file ,'w' );
        if (fputs($fp,$data))
		{
			return true;
		} else {
			return false;
		}
        fclose($fp);
	}
	
	
	
	/*
     * public function checkCache();
     * Cache dosyası var mı yok mu ona bakar, varsa true yoksa false değeri döner
	 * false değeri dönmesi durumunda, WARNING düzeyinde, true değeri dönmesi durumunda INFO düzeyinde log oluşturur!
     * @since v.1.0
	 * @return boolean;
     */
	public function checkCache()
	{
		if (is_dir(self::$folder)) // cache klasörü gerçekten var mı?
		{
			if ( file_exists(self::$folder . self::$file)) // cache dosyası var mı?
			{
				$time = time() - (60*60*self::$time); // $time ile belirtildiği kadar zaman
				if (filemtime(self::$folder . self::$file) > $time)
				{
					if (filesize(self::$folder . self::$file) < 1024) // dosya boş ise
					{
						if (self::$log_level == 2 OR self::$log_level == 3)
						{
							$this->log->write('[' . self::$class . '] Cache dosyası boş!',1);
						}
						return false;
					} else { // dosyanın zamanı geçmemiş!
						if (self::$log_level == 3) { $this->log->write('[' . self::$class . '] Cache dosyası bulundu ve zamanı geçmemiş.',2); }
						return true;
					}
					
					
				} else {
					if (self::$log_level == 2 OR self::$log_level == 3)
					{
						$this->log->write('[' . self::$class . '] Cache dosyası için belirtilen zaman dolmuş!',1);
					}
					return false;
				}
			} else {
				if (self::$log_level == 2 OR self::$log_level == 3)
				{
					$this->log->write('[' . self::$class . '] Cache dosyası bulunamadı!',1);
				}
				return false;
			}
		} else {
			if (self::$log_level == 2 OR self::$log_level == 3)
			{
				$this->log->write('[' . self::$class . '] Lütfen cache klasörünü gözden geçirin! Şu anda geçerli gözüken: ' . self::$folder,1);
			}
			return false;
		}
	}
		
	/*
	 *
	 * ------------------------------------------------------------------------------
	 * Sınıfın Çalışması ve ayarlanması ile ilgili bölüm. Ellemeyiniz!
	 * ------------------------------------------------------------------------------
	 *
	 */
	
	
	/*
     * public static function getInstance();
     * Sınıfın bir kopyasını çıkartır.
     * @since v.1.0
	 * @return $instance;
     */
    public static function getInstance()
    {
        if ( ! self::$instance )
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /*
     * public static function settings()
     * Sınıfın değişkenlerini ayarlar.
     * @since v.1.0
     * @return none
     * 
     */
    public static function settings( $setting,$values = null )
    {
        if ( is_array( $setting ) )
        {
            foreach ( $setting as $key => $value)
            {
                self::settings($key,$value);
            }
        }
        elseif (property_exists(__CLASS__, $setting) )
        {
            self::$$setting = $values;
        }
    }
    
    /*
     * public function __get($setting)
     * Sınıfı gelen statik değişkenin değerini alır.
     * @since v.1.0
     * @return $degisken
     */
    public function __get( $setting )
    {
        return $this->variable[$setting];
    }
    
    /*
     * public function __set($ayar,$deger)
     * Sınıfa gelen statik değişkenin yeni ayarını atar.
     * @ since v.2.0
     * @ return none
     */
    public function __set( $setting,$value )
    {
        $this->variable[$setting] = $value;
    }
	
	
}
?>