<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=utf-8");
Class Video_admin_model Extends CI_Model
{
	public function getVideos()
	{
		return $this->db->get('videos')->result_array();
		
	}
	
	public function getVideoDB($id)
	{
		$sorgu = $this->db->get_where('videos',array('id'=>$id));
		if ($sorgu->num_rows > 0)
		{
			$sonuc = $sorgu->row();
			$r['status'] = 'ok';
			$r['info']	= 'Veri başarıyla çekildi.';
			$r['id'] = $sonuc->id;
			$r['video_id']	= $sonuc->video_id;
			$r['title'] = $sonuc->video_title;
			$r['description'] = $sonuc->video_desc;
			$r['thumbnail'] = $sonuc->video_thumb;
			$r['length'] = $sonuc->video_length;
			
		} else {
			$r['status'] = 'error';
			$r['info']	= 'Böyle bir ID değerine sahip video bulunamadı!';
		}
		
		return $r;
	}
	
	public function getYoutubeVideo($url)
	{
		// get video ID from $_GET
		//$vid = stripslashes($_GET['a']);
		//$vid = stripslashes('http://www.youtube.com/watch?v=N1Te_03drhk');
		//$string = $vid;
		//$url = parse_url($string);
		//parse_str($url['query']);
		
		$vid = stripslashes($url);
		
		$url = parse_url($vid);
		parse_str($url['query']);
		
		//die(print_r($v));
		
		
		
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $v;
	
		// read feed into SimpleXML object
		$read = file_get_contents($feedURL);
		//die($read);
		if ($read)
		{
			if ($read == 'Invalid id')
			{
				$video_info['status'] = 'error';
				$video_info['info'] = 'Geçersiz Video ID';
			} else {
				$entry = simplexml_load_string($read);
				
				
			
				// parse video entry
				$video = $this->parseVideoEntry($entry);
				
				
				//These variables include the video information
				$video_info['status'] = 'ok';
				$video_info['info'] = 'Video bilgileri başarıyla alındı.';
				$video_info['id'] = $v;
				$video_info['title'] = (stripslashes($video->title));
				$video_info['description'] = (stripslashes($video->description));
				$video_info['thumbnail'] = stripslashes($video->thumbnailURL);
				$video_info['watchURL'] = (stripslashes($video->watchURL));
				$video_info['length'] = (stripslashes($video->length));
			}
		} else {
			$video_info['status'] = 'error';
			$video_info['info'] = 'Youtubedan veri alınamadı!';
		}
		
		return $video_info;
	}
	
	private function parseVideoEntry($entry)
	{
		$obj= new stdClass;
	
		// get nodes in media: namespace for media information
		$media = $entry->children('http://search.yahoo.com/mrss/');
		$obj->title = $media->group->title;
		$obj->description = $media->group->description;
	
		// get video player URL
		$attrs = $media->group->player->attributes();
		$obj->watchURL = $attrs['url'];
	
		// get video thumbnail
		$attrs = $media->group->thumbnail[0]->attributes();
		$obj->thumbnailURL = $attrs['url'];
	
		// get  node for video length
		$yt = $media->children('http://gdata.youtube.com/schemas/2007');
		$attrs = $yt->duration->attributes();
		$obj->length = $attrs['seconds'];
		
		return $obj;
	}
}