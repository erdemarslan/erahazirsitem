<?php

Class weather
{

	private $folder = './cache/';
	private $time = 6;
	private $log_level = 1;
	private $cache;
	private $log;
	private $url = 'http://weather.uk.msn.com/RSS.aspx?weadegreetype=C&wealocations=wc:';
	
	public function __construct()
	{
		require_once 'elog.php';
		$this->log = new elog();
		if ($this->log_level == 3)
		{
			$this->log->write('Havadurumu sınıfı başarı ile başlatıldı.',2);
		}
	}
	
	public function GetWeather($id, $multiple=true)
	{
		header("Content-Type: text/html; charset=utf-8");
		
		# cache işlemlerini yap!
		require_once 'ecache.php';
		
		$c = array(
				'folder'	=> $this->folder,
				'time'		=> $this->time,
				'log_level'	=> $this->log_level,
				'file'		=> 'havadurumu_' . $id,
				'class'		=> __CLASS__
			);
		$this->cache	= new ecache($c);
		
		if ($this->cache->checkCache())
		{
			$output = trim($this->cache->readCache());
		} else {
			$data = trim($this->getData($id));
			if ($this->cache->writeCache($data))
			{
				if ($this->log_level == 3)
				{
					$this->log->write('Havadurumu verileri başarıyla dosyaya yazıldı.',3);
				}
			} else {
				if ($this->log_level != 0)
				{
					$this->log->write('Havadurumu verileri dosyaya yazılamadı !',1);
				}
			}
			$output = $data;
		}			
		
		if(!empty($output))
		{
			$data 	= $this->GetXMLTree ($output);
			$now 		= $data["RSS"][0]["CHANNEL"][0]["ITEM"][0]["DESCRIPTION"][0]["VALUE"];
			$dex 		= $data["RSS"][0]["CHANNEL"][0]["ITEM"][1]["DESCRIPTION"][0]["VALUE"];
			$title 		= $data["RSS"][0]["CHANNEL"][0]["ITEM"][0]["TITLE"][0]["VALUE"];
			
			# Şu andaki bilgiler
			$current 	= explode('Current Conditions:', $now);
			$current 	= explode(')', $current[1]);
			$image 		= explode('law/', $current[1]);
			$image 		= explode('"', $image[1]);
			$desc		= explode('<br />', $current[1]);
			$desc		= explode('.', $desc[2]);
			$degree		= explode('(', $desc[1]);
			$feels		= explode('Feels like', $current[1]);
			$in			= explode(':', $current[2]);
			$winds 		= explode('.', $in[2]);
			$humidity 	= explode('%', $in[1]);
			$other		= explode('as of', $title);
			$place		= explode('in', trim($other[0]));
			$place		= explode('(', $place[1]);
			$place		= explode(',',$place[0]);
			$day 		= explode(' ', trim($other[1]));
			$time		= $day[0];
			$day 		= explode(')', $day[1]);
			
			

			$havadurumu['Şimdi']["derece"] 		= trim($degree[0]);
			$havadurumu['Şimdi']["nem"] 		= trim($humidity[0]);
			$havadurumu['Şimdi']["ruzgar"] 		= $this->prepData(trim($winds[0]),1);
			$havadurumu['Şimdi']["hissedilen"] 	= trim($feels[1]);
			$havadurumu['Şimdi']["saat"] 		= trim($time);
			$havadurumu['Şimdi']["gun"] 		= date('d.m.Y',strtotime(trim($day[0])));
			$havadurumu['Şimdi']["aciklama"] 	= $this->prepData(trim($desc[0]),2);
			$havadurumu['Şimdi']["resim_kucuk"]	= 'http://est.msn.com/as/wea3/i/en/saw/' . trim($image[0]);
			$havadurumu['Şimdi']["resim_buyuk"]	= 'http://est.msn.com/as/wea3/i/en/law/' . trim($image[0]);
			$havadurumu['Şimdi']["yer"]		 	= trim($place[0]);
			
			if($multiple)
			{
				$descr = explode('src=rss">', $dex);
				
				//die(print_r($descr));
				$count = count($descr);
				//die(print_r($count));
				
				for($i = 1; $i < $count; $i++)
				{
					if ($i != 6)
					{
						$ikinokta 	= explode(':', $descr[$i]);
						//die (print_r($ikinokta));
						
						
						$desc		= explode('alt="',$ikinokta[2]);
						$desc		= explode('"',$desc[1]);
						$image 		= explode('saw/', $ikinokta[2]);
						$image 		= explode('"', $image[1]);
						$low 		= explode('Lo', $ikinokta[2]);
						$low		= explode('Hi',$low[1]);
						$high 		= explode('Hi', $ikinokta[2]);
						$high		= explode('Precip chance',$high[1]);
						$chance 	= explode('Precip chance', $ikinokta[2]);					
						$chance		= explode('%',$chance[1]);
						
						$day = $this->prepData(strip_tags(trim($ikinokta[0])),3);
						
						//$havadurumu[$i]['day']			= strip_tags(trim($ikinokta[0]));
						$havadurumu[$day]["aciklama"] 		= $this->prepData(strip_tags(trim($desc[0])),2);
						$havadurumu[$day]["resim_kucuk"] 		=  'http://est.msn.com/as/wea3/i/en/saw/' .strip_tags(trim($image[0]));
						$havadurumu[$day]["resim_buyuk"] 		=  'http://est.msn.com/as/wea3/i/en/law/' .strip_tags(trim($image[0]));
						$havadurumu[$day]["enaz"] 			=  strip_tags(trim($low[0]));
						$havadurumu[$day]["encok"] 		=  strip_tags(trim($high[0]));
						$havadurumu[$day]["ihtimal"] 		=  strip_tags(trim($chance[0]));
					}
					
				}					
			}
			
			
			return $havadurumu;
		}
		
		return false;

	}
	
	private function prepData($data,$type)
	{
		switch ($type)
		{
			case 1: // rüzgar winds
				$d = explode(' ',$data);
				$kph = round( ((int)$d[0]) * 1.609344);
				
				$directions = array(
					'N'		=> 'Kuzey',
					'NNE'	=> 'Kuzey-Kuzeydoğu',
					'NE'	=> 'Kuzeydoğu',
					'ENE'	=> 'Doğu-Kuzeydoğu',
					'E'		=> 'Doğu',
					'ESE'	=> 'Doğu-Güneydoğu',
					'SE'	=> 'Güneydoğu',
					'SSE'	=> 'Güney-Güneydoğu',
					'S'		=> 'Güney',
					'SSW'	=> 'Güney-Güneybatı',
					'SW'	=> 'Güneybatı',
					'WSW'	=> 'Batı-Güneybatı',
					'W'		=> 'Batı',
					'WNW'	=> 'Batı-Kuzeybatı',
					'NW'	=> 'Kuzeybatı',
					'NNW'	=> 'Kuzey-Kuzeybatı'
				);
				if (array_key_exists($d[2],$directions))
				{
					$yon = $directions[$d[2]];
				} else {
					$yon = $d[2];
				}
				$r = $kph . ' km/h ' . $yon;
			break;
			
			
			case 2: // desc - açıklama
				$descriptions = array(
					'Partly Cloudy' => 'Parçalı Bulutlu',
					'Clear' => 'Açık',
					'Fair' => 'Az Bulutlu',
					'Showers / Clear' => 'Sağanak / Açık',
					'Light Showers' => 'Hafif Yağışlı',
					'Rain' => 'Yağmurlu',
					'Thunderstorms' => 'Gökgürültülü Sağnak Yağışlı',
					'Cloudy' => 'Bulutlu',
					'Mostly Cloudy' => 'Çok Bulutlu',
					'Flurries' => 'Kısa ve Şiddetli Yağış',
					'Snow Showers' => 'Kar Yağışlı',
					'Snow' => 'Kar',
					'Snow Showers / Sun' => 'Kar Yağışlı / Güneşli',
					'Scattered Flurries' => 'Aralıklı Yağışlı',
					'Showers' => 'Sağanak Yağışlı'
				);
				if (array_key_exists($data,$descriptions))
				{
					$r = $descriptions[$data];
				} else {
					$r = $data;
				}
			break;
			
			case 3 :
				$days = array(
					'Today'		=> 'Bugün',
					'Tomorrow'	=> 'Yarın',
					'Monday'	=> 'Pazartesi',
					'Tuesday'	=> 'Salı',
					'Wednesday'	=> 'Çarşamba',
					'Thursday'	=> 'Perşembe',
					'Friday'	=> 'Cuma',
					'Saturday'	=> 'Cumartesi',
					'Sunday'	=> 'Pazar'
				);
				if (array_key_exists($data,$days))
				{
					$r = $days[$data];
				} else {
					$r = $data;
				}
			break;
			
			
		}
		return $r;
	}
	
	private function getData($id)
	{
		$data = file_get_contents($this->url . $id);
		return $data;
	}
	
  	private function GetChildren($vals, &$i) 
  	{ 
	     $children = array(); // Contains node data
         if (isset($vals[$i]['value']))
         {
            $children['VALUE'] = $vals[$i]['value'];
         } 
         
         while (++$i < count($vals)){ 
            switch ($vals[$i]['type'])
            {
               
            case 'cdata': 
               if (isset($children['VALUE'])){
                  $children['VALUE'] .= $vals[$i]['value'];
               } else {
                  $children['VALUE'] = $vals[$i]['value'];
               } 
            break;
            
            case 'complete':
               if (isset($vals[$i]['attributes'])) {
                  $children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
                  $index = count($children[$vals[$i]['tag']])-1;
         
                  if (isset($vals[$i]['value'])){ 
                     $children[$vals[$i]['tag']][$index]['VALUE'] = $vals[$i]['value']; 
                  } else {
                     $children[$vals[$i]['tag']][$index]['VALUE'] = '';
                  }
               } else {
                  if (isset($vals[$i]['value'])){
                     $children[$vals[$i]['tag']][]['VALUE'] = $vals[$i]['value']; 
                  } else {
                     $children[$vals[$i]['tag']][]['VALUE'] = '';
                  } 
               }
            break;
            
            case 'open': 
               if (isset($vals[$i]['attributes'])) {
                  $children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
                  $index = count($children[$vals[$i]['tag']])-1;
                  $children[$vals[$i]['tag']][$index] = array_merge($children[$vals[$i]['tag']][$index],$this->GetChildren($vals, $i));
               } else {
                  $children[$vals[$i]['tag']][] = $this->GetChildren($vals, $i);
               }
            break; 
         
            case 'close': 
               return $children; 
         } 
      }
   }

	private function GetXMLTree($data)
    { 
     
         $parser = xml_parser_create('UTF-8');
         xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
         xml_parse_into_struct($parser, $data, $vals, $index); 
         xml_parser_free($parser); 
      
         $tree = array(); 
         $i = 0; 
      
         if (isset($vals[$i]['attributes'])) 
         {
            $tree[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes']; 
            $index = count($tree[$vals[$i]['tag']])-1;
            $tree[$vals[$i]['tag']][$index] =  array_merge($tree[$vals[$i]['tag']][$index], $this->GetChildren($vals, $i));
         } else {
            $tree[$vals[$i]['tag']][] = $this->GetChildren($vals, $i); 
         }
      return $tree; 
      }		

}
?>
