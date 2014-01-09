<?php

   # ========================================================================#
   #
   #  Author:    Jarrod Oberto
   #  Version:	 1.2
   #  Date:      Jul 11
   #  Purpose:   Provides album gallery functionality
   #  Project:	 Facebook Graph API	
   #  Param In:  See functions.
   #  Param Out: n/a
   #  Requires : 
   #
   # ========================================================================#

require_once('FaceBookWrapper.php');

class FacebookAlbum extends FaceBookWrapper
{
	private $_currentAlbum;
	private $_showPerPage;
	private $_isDataSourceRemote;
	private $_predefinedSize;
	
	private $_imageDataRaw;
	
	private $_path;
	
## _____________________________________________________________________________	
## ________                _____________________________________________________
## ________ PUBLIC METHODS _____________________________________________________
## _____________________________________________________________________________
##	
	
	public function __construct($appId, $secretId, $redirectURL, $userId = 'me', $publicUserIs=null, $cookies = true) {
		parent::__construct($appId, $secretId, $redirectURL, $userId, $publicUserIs, $cookies);
	}
	
	## --------------------------------------------------------
	
	public function getAlbumPredefined($album, $size='small', $limit=999, $offset=0) 
	{
		$this->_currentAlbum = $album;
		$this->_showPerPage = $limit;
		$this->_isDataSourceRemote = 'predefined';
		$this->_predefinedSize = $size;
		
		$fileListingArray = array();
	
		$size = strToLower($size);
		switch ($size) {
			case 'largest':
				$fileListingArray = $this->getAlbumRemote($album, 999, 0, true, 'largest');
				break;
			case 'large':
				$fileListingArray = $this->getAlbumRemote($album, 999, 0, true, 'large');
				break;
			case 'medium':
				$fileListingArray = $this->getAlbumRemote($album, 999, 0, true, 'medium');
				break;
			case 'small':
				$fileListingArray = $this->getAlbumRemote($album, 999, 0, true, 'small');
				break;
			case 'tiny':
				$fileListingArray = $this->getAlbumRemote($album, 999, 0, true, 'tiny');
				break;
		}
				
		return $fileListingArray;
	}


	## --------------------------------------------------------
	
	public function getAlbum($album, $limit=999, $offset=0, $remote=true)
	#
	#	Author:		Jarrod Oberto
	#	Date:		Jul 11
	#	Purpose:	(interface) Simplify the interface
	#	Params in:	(str) $album: the name or id of the album to get
	#				(bool) $remote: serve remote image or store and serve local
	#	Params out:	
	#	Notes:		The constants in this method should probably be passed in.
	#
	{

		$fileListingArray = array();
			
		// *** If predefined enabled, redirect (and skip the rest)	
		if (USE_PREDEFINED) {
			$fileListingArray= $this->getAlbumPredefined($album, PREDEFINED_SIZE);
			return $fileListingArray;
		}
		
	
		$this->_currentAlbum = $album;
		$this->_showPerPage = $limit;
		$this->_isDataSourceRemote = $remote;
				
		if ($remote) {
			$fileListingArray = $this->getAlbumRemote($album);
		} else {
			$fileListingArray = $this->getAlbumLocal($album);
		}
				
		return $fileListingArray;
	}

	## --------------------------------------------------------
		
	public function getAlbumRemote($album, $limit=999, $offset=0, $useCache=true, $size='custom')
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Serves images directly from Facebook
	#	Params in:	(str) $album - the album name or id
	#	Params out:	(array) associative array of Facebook image URL's with image
	#					 id's as key.
	#	Notes:	
	#
	{
		$FBListArray = array();
		$this->_album = $album;
		
		// *** Get a list of images in the album
		$albumPhotoDataArray = $this->_getAlbumPhotoDataRaw($album);

		$this->_imageDataRaw = $albumPhotoDataArray;
				
		if ($albumPhotoDataArray['data']) {
			
			foreach ($albumPhotoDataArray['data'] as $photoArray) {


				$size = strToLower($size);
				switch ($size) {
					case 'custom':
						$FBListArray[$photoArray['id']] = $photoArray['source'];
						break;
					case 'largest':
						$FBListArray[$photoArray['id']]['thumb'] = $photoArray['source'];
						$FBListArray[$photoArray['id']]['large'] = $photoArray['source'];
						break;
					case 'large':
						$FBListArray[$photoArray['id']]['thumb'] = $photoArray['images'][0]['source'];
						$FBListArray[$photoArray['id']]['large'] = $photoArray['source'];
						break;
					case 'medium':
						$FBListArray[$photoArray['id']]['thumb'] = $photoArray['images'][1]['source'];
						$FBListArray[$photoArray['id']]['large'] = $photoArray['source'];
						break;
					case 'small':
						$FBListArray[$photoArray['id']]['thumb'] = $photoArray['images'][2]['source'];
						$FBListArray[$photoArray['id']]['large'] = $photoArray['source'];
						break;
					case 'tiny':
						$FBListArray[$photoArray['id']]['thumb'] = $photoArray['images'][3]['source'];
						$FBListArray[$photoArray['id']]['large'] = $photoArray['source'];
						break;
				}				
			}
		}

		return $FBListArray;
	}
	
	## --------------------------------------------------------
	
		
	public function getAlbumLocal($album, $albumsFolder='albums')
	#
	#	Author:		Jarrod Oberto
	#	Date:		July	11
	#	Purpose:	Synchronise a local album with a Facebook album  
	#	Params in:	(str) $album - the album name or id
	#				(str) $albumsFolder - the master album folder to save to.
	#					(actual albums will be named after the album id)
	#	Params out:	(array) associative array of the images absolute path with 
	#					image id as key.
	#	Notes:		Returning absolute paths makes it hard to work with - can't 
	#				retirieve an image easily - need to tweak.
	{
		$this->_album = $album;
			
		$path =  dirname(__FILE__) . '/' . $albumsFolder . '/' . $album;
		$this->_path = $path;
				
		// *** Prep folder
		if (!$this->_prepFolder($path)) {
			return false;
		}
		
		// *** Get local list
		$localListArray = $this->_getLocalGalleryList($path, true);
		
		//check $localListArray is_array

		// *** Get FB list
		$FBListArray = $this->_getFBGalleryList($album);
		
		// *** Generate list of images to get (have been added to facebook)
		$addedToFBArray = array_diff($FBListArray, $localListArray);
		
		// *** Generate list of images to delete (have been removed from facebook)
		$removedFromFBArray = array_diff($localListArray, $FBListArray);
		
		// *** Download missing images
		$this->_downloadImages($path, $addedToFBArray);
		
		// *** Delete those not needed
		$this->_deleteRemovedImages($path, $removedFromFBArray);
		
		// *** Save current (master) list to folder (json)
		
		// *** Save descriptions to folder (json)
			
		// *** If successful, return the gallery path
		return $this->_getLocalGalleryList($path);
	}	
	
	## --------------------------------------------------------
	
	public function getAlbumInfo($albumName='', $includeProfileAlbum = false)
	#
	#	Author:		Jarrod Oberto
	#	Date:		August 11
	#	Purpose:	Like get albumNames but with a bit more info
	#	Params in:	(bool) $includeProfileAlbum: if set to true, the users profile pictures album will be returned, too.
	#	Params out:	(array) 
	#	Notes:	
	#	Used in:	FB Album Gallery
	#	Ver added:	1.3
	{
		// *** Get album data
		$albumsData = $this->_getAlbumDataRaw();

		$albumNamesArray = array();
		
		if (count($albumsData['data']) > 0) {
			
			// *** Loop through album data
			foreach ($albumsData['data'] as $album) {
				
				// *** Test if we want to include the Profile Pictures album
				if (($includeProfileAlbum || strtolower($album['name']) != 'profile pictures')) {
				
					$albumNamesArray[$album['id']]['name'] = $album['name'];
					
					if (isset( $album['cover_photo']))
					{
						$albumNamesArray[$album['id']]['coverPhoto'] = $album['cover_photo'];
					} else {
						$albumNamesArray[$album['id']]['coverPhoto'] = '';
					}
					
					$albumNamesArray[$album['id']]['date'] = $album['created_time'];
		
					if (isset( $album['description'])) {
						$albumNamesArray[$album['id']]['description'] = $album['description'];
					} else {
						$albumNamesArray[$album['id']]['description'] = '';
					}
				}
			}
		}
		unset($albumsData);
		
		// *** Convert to album id
		$albumId = $this->getAlbumId($albumName);

		if (isset($albumNamesArray[$albumId])) {
			return $albumNamesArray[$albumId];
		}

		return $albumNamesArray;
	}

	## --------------------------------------------------------
	
	public function getAlbumCover($albumName)
	#
	#	Author:		Jarrod Oberto
	#	Date:		August 11
	#	Purpose:	Get the album cover image
	#	Params in:	(str) $albumName: The id or name of the album
	#	Params out:	(array) Associate array of album id's / names
	#	Notes:	
	#	Used in:	FB Album Gallery
	#	Ver added:	1.3
	{

		// *** Convert album name to id
		$albumId = $this->getAlbumId($albumName);	

		// *** Get each albums info (id, cover image, date) 
		$albumsArray = $this->getAlbumInfo();

		// *** Get the cover image id for the album we've specified
		if (isset($albumsArray[$albumId])) {
			$coverPhotoId = $albumsArray[$albumId]['coverPhoto'];

			// *** Get all the photos for that album
			$photosArray = $this->getAlbum($albumId);
	
			// *** Return the image of the photo id we specificed
			return $photosArray[$coverPhotoId];
		}

		return false;
			
	}

	## --------------------------------------------------------

	public function getImageCaptions($albumName=null)
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Get all the image captions for the images in an album
	#	Params in:	(str) $album - the album name or id
	#	Params out: (array) an associative array of image id's and captions.
	#	Notes:	
	#
	{
		if ($albumName == null) {
			
			$albumName = $this->_album;
		}
		
		$rawImageData = $this->_getAlbumPhotoDataRaw($albumName);
		
		$captionsArray = array();
		
		if ($rawImageData['data']) {
		
			foreach ($rawImageData['data'] as $image) {

				if (isset($image['id']) && isset($image['name'])) {
					$imageId = $image['id'];
					$imageCaption = $image['name'];
					$captionsArray[$imageId] = $imageCaption;
				}
			
				
			}
		}
		$this->_getImageCaptionsArrayCache = $captionsArray;
		return $captionsArray;
	}
	
	## --------------------------------------------------------
	
	public function getImageCaption($imageId, $albumName=null)
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Return a single caption for an image
	#	Params in:	(str) $imageId - the id of the image for caption you want 
	#	Params out: (str) the caption
	#	Notes:	
	#
	{	
		if (isset($imageId)) {
			
			// *** Make the API call now
			$captionsArray = $this->getImageCaptions($albumName);
			

			if (count($captionsArray) > 0) {
				if (isset($captionsArray[$imageId])) {
					return $captionsArray[$imageId];
				}
			}
		}
		return '';
	}
	
	## --------------------------------------------------------
	
	public function getPhoto($photoId, $albumId='')
	{
		
		if ($albumId == '') {
			$albumId = $this->_currentAlbum;
		}
	
		$photosArray = $this->_getAlbumPhotoDataRaw($albumId);
				
		if (isset($photosArray['data']) && count($photosArray['data']) > 0) {
			foreach ($photosArray['data'] as $imageArray) {
		
				if ($imageArray['id'] == $photoId) {
					
					return $imageArray['source'];
					
				}
			}
		}
		
	}
	
	## --------------------------------------------------------
	
	public function getComments($photoId, $albumName='', $formatDate=true)
	{
		
		if ($albumName == '') {
			$albumName = $this->_currentAlbum;
		}
		
		$albumId = $this->getAlbumId($albumName);
	
		$photosArray = $this->_getAlbumPhotoDataRaw($albumId);
		$commentsArray = array();	
		
		if (count($photosArray['data']) > 0) {
			foreach ($photosArray['data'] as $imageArray) {
		
				if ($imageArray['id'] == $photoId) {
								
					if (isset($imageArray['comments']['data']) && count($imageArray['comments']['data']) > 0) {
						
						foreach ($imageArray['comments']['data'] as $key => $commentArray) {
							$commentsArray[$key]['name'] = $commentArray['from']['name'];
							$commentsArray[$key]['date'] = $commentArray['created_time'];
							$commentsArray[$key]['comment'] = $commentArray['message'];
							
							if ($formatDate) {
								$commentsArray[$key]['date'] = date(DATE_FORMAT, $commentsArray[$key]['date']);
							}
						}
					}
					
					
				}
			}
		}
		return $commentsArray;
	}	
	
	## --------------------------------------------------------
	
	
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
	 *	PAGINATION 	
	 */

	
	public function getAlbumPhotoCount($albumName=null)
	#
	#	Author:		Jarrod Oberto
	#	Date:		Jul 11
	#	Purpose:	Get the number of photos in an album
	#	Params in:	(str) $albumName: the name of the album to get the count for.
	#					Should already be set by getAlbum method
	#	Params out: (int) the number of images in the album
	#	Notes:	
	#
	{		
		if (is_null($albumName)) {

			// *** Then try use this (assuming method "getAlbum" has already been called)
			$albumName = $this->_currentAlbum;
		}

		$dataArray = $this->getAlbumDataRaw($albumName);

		return $dataArray['count'];
	}

## --------------------------------------------------------

    public function getNumberOfPages($albumName=null)
	#
	#	Author:		Jarrod Oberto
	#	Date:		Jul 11
	#	Purpose:	Get the number of pages based on how many photos and how 
	#				many to display per page
	#	Params in:	(str) $albumName: the name of the album to get the count for.
	#					Should already be set by getAlbum method.
	#	Params out: (int) the number of gallery pages.
	#	Notes:	
	#
    {
		if (is_null($albumName)) {
			
			// *** Then try use this (assuming method "getAlbum" has already been called)
			$albumName = $this->_currentAlbum;
		}		
		
		if (is_null($albumName) || $albumName == '') {
			$this->_errorArray[] = 'The album name was not set';
			$this->_debugArray[] = 'You need to call getAlbum method first';
			return false;
		}
		
		$numberOfPhotos = $this->getAlbumPhotoCount($albumName);
		
		if ($numberOfPhotos == '' || $this->_showPerPage == '') {
			return 1;
		}

        return ceil($numberOfPhotos / $this->_showPerPage);
    }	
	
	## --------------------------------------------------------
	
	public function getPage($pageNumber) 
	{
		// *** Calculate the offset
		$offset = ($pageNumber * $this->_showPerPage) - $this->_showPerPage;
	
		// *** Get the album data array
		$dataArray = $this->getAlbum($this->_currentAlbum, $this->_showPerPage); 
		
		// *** Slice our piece
		$resultsArray = array_slice($dataArray, $offset, $this->_showPerPage, true);
			
		return $resultsArray;
	}
	
	## --------------------------------------------------------
	
	public function setPhotosPerPage($limit)
	{
		//$this->_showPerPage = $limit;		
	}

## _____________________________________________________________________________	
## ________                 ____________________________________________________
## ________ PRIVATE METHODS ____________________________________________________
## _____________________________________________________________________________
##		
	
	private function _prepFolder($path)
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Create the gallery directory
	#	Params in:  (str) $path: the path to the album
	#	Params out:
	#	Notes:	
	#
	{
		return $this->_createDir($path, 0777);
	}
	
	## --------------------------------------------------------
	
	private function _getLocalGalleryList($path, $returnId=false)
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Get a list of all the current images in the gallery
	#	Params in:  (str) $path: the path to the album
	#	Params out: (array) An array of images in the gallery
	#	Notes:	
	#			
	{
		
		/*
		 * Glob on windows may need a '/' at the begining of the path!
		 * http://www.php.net/manual/en/function.glob.php#49483
		 * 
		 */
		$winFix = '';
		if ($this->_is_windows_server()) {
			$winFix = "/";
		}

		$filesArray = array();
		$filesArray = glob($path . "/{*.jpg,*.JPG}", GLOB_BRACE);
		
		if ($returnId) {

			if (is_array($filesArray)) {

				// *** Strip path and file extention leaving just the id
				return array_map(array(&$this, "_removePath"), $filesArray);	
			}
		} else {
			return $filesArray;
		}	
	}
	
	## --------------------------------------------------------
	
	private function _getFBGalleryList($album)
	#
	#	Author:		Jarrod Oberto
	#	Date:		July 11
	#	Purpose:	Get a list of all the current images in the gallery
	#	Params in:  (str) $path: the path to the album
	#	Params out: (array) An array of images in the gallery
	#	Notes:	
	#			
	{
		$FBListArray = array();
		$albumPhotoDataArray = $this->_getAlbumPhotoDataRaw($album);
		
		if ($albumPhotoDataArray['data']) {
			foreach ($albumPhotoDataArray['data'] as $photoArray) {
				$FBListArray[] = $photoArray['id'];
			}
		} else {
			// add to debug
		}
		
		$this->_imageDataRaw = $albumPhotoDataArray;
		
		return $FBListArray;
	}	
	
	## --------------------------------------------------------
	
	private function _downloadImages($path, $addedToFBArray)
	{
				
		$albumPhotoDataArray = $this->_imageDataRaw;
		
		if ($albumPhotoDataArray) {
			foreach ($albumPhotoDataArray['data'] as $photoArray) {

				$link = $photoArray['source'];
				$imageId = $photoArray['id'];

				if (in_array($imageId, $addedToFBArray)) {
				
					$filename = $path . '/' . $imageId . '.jpg';
	
					$data = file_get_contents($link);
					$im = imagecreatefromstring($data);
					imagejpeg($im, $filename, 100);			
				}
			}
		}
	}
	
	## --------------------------------------------------------
	
	private function _deleteRemovedImages($path, $removedFromFBArray)
	{
		$resultArray = array();
		foreach ($removedFromFBArray as $image) {
			
			
			$image = $image . '.jpg';
			$fullPath = $path . '/' . $image;

			if (file_exists($fullPath)) {
				$resultArray[] = @unlink($fullPath);
			}
		}
		
		if (in_array(false, $resultArray)) {		
			return false;
		} else {
			return true;
		}
	}
	
	## --------------------------------------------------------
	
	private function _createDir ($path, $permissions=0755, $isRecursive=true) 
	#
	#	Author:		Jarrod Oberto
	#	Date:		May 11
	#	Purpose:	Attempt to create the dir should it not exist
	#	Params in:	(str) $path: path of directory to create
	#				(int) $permissions: the folder permissions to set
	#	Params out:
	#	Notes:	
	#		
	{
		$result = true;
		
		if(!file_exists($path)) {
			$result = @mkdir($path, $permissions, $isRecursive);
			@chmod($path, $permissions);			
		} 

		return $result;
	}
	
	## --------------------------------------------------------
	
	private function _removePath($filename)
	{
		$pathPartsArray = pathinfo($filename);
		return $pathPartsArray['filename'];
	}	
	
	## --------------------------------------------------------
	
	private function _is_windows_server()
	#	Purpose:	Check if server is Windows
	{
		return in_array(strtolower(PHP_OS), array("win32", "windows", "winnt"));
	}
	
	## --------------------------------------------------------
}
?>
