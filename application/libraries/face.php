<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */

require_once('library/facebook.php');
	
class Face{
	
	public function __construct($config) 
	{
        
		$this->facebook = new Facebook($config);
		$this->user_id = $this->facebook->getUser();
    }
	
	function login()
	{
		if(!$this->user_id) 
		{
			$params = array(
				'scope' => 'email, public_profile, user_photos, publish_actions'
			);
			return $this->facebook->getLoginUrl($params);
		}
	}
	
	//get All Album.
	/*
		$photo = false{
			view album.
			return array(album_id + name + count + cover_photo);
		}
		
		$photo = true{
			view all photo.
			return array(cover_photo + photo_big);
		}
	*/
	function getAllAlbum($photo = false)
	{
		if($this->user_id) 
		{
			try{
				$all_albums =  $this->facebook->api('/me/albums','GET');
				if($photo == false)
				{
					$data = array();
					foreach($all_albums['data'] as $album)
					{
						if ( (int) $album['count'] == 0) continue;
						$data['album_id'][] = $album['id'];
						$data['name'][] = $album['name'];
						$data['count'][] = $album['count'];
						if($album['cover_photo'])
						{
							$cover_photo = $this->facebook->api('/'.$album['cover_photo'],'GET');
							$data['cover_photo'][] = $cover_photo['picture'];
						}
					}
				
					return $data;
				}
				else
				{	
					$data = array();
					foreach($all_albums['data'] as $album)
					{
						$data[] = $this->getAllPhoto($album['id']);
					}
					foreach($data as $photos)
					{
						foreach($photos['photo'] as $photo)
						{
							$images['cover_photo'][] = $photo;
						}
						foreach($photos as $photo)
						{
							$images['photo_big'][] = $photo;
						}
					}
					return $images;
				}
			} 
			catch(FacebookApiException $e) 
			{
				return error_log($e->getMessage());
				$user_id = null;
			} 
		}
	}
	
	//get view Photo. return array(photo_medium + photo_big + photo);
	function getPhoto($photo_id)
	{	
		if($this->user_id) 
		{	
			$data = array();
			$photos = $this->facebook->api('/'.$photo_id,'GET');
			$data['photo_medium'] = $photos['source'];
			$data['photo_big'] = $photos['images'][0]['source'];
			$data['photo'] = $photos['picture'];
			return $data;
		}
	}
	
	//get All Photo in album. return array(photo_id + photo_medium + photo_big + photo);
	function getAllPhoto($album_id)
	{
		if($this->user_id) 
		{	
			$data = array();
			$photos = $this->facebook->api('/'.$album_id.'/photos','GET');
			foreach($photos['data'] as $photo)
			{
				$data['photo_id'][] = $photo['id'];
				$data['photo_medium'][] = $photo['source'];
				$data['photo_big'][] = $photo['images'][0]['source'];
				$data['photo'][] = $photo['picture'];
			}
			return $data;
		}
	}
}
	
?>