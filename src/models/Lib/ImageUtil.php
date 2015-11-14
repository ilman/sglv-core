<?php 

namespace Lib;

use Scienceguard\SG_Util;

class ImageUtil{

	public static function imageFirst($images){		
		$primary_image = explode(',', $images);
		
		return trim($primary_image[0]); 
	}

	public static function imageJoin($images){		
		$return_string = ($images) ? join(', ', $images) : '';
		
		return $return_string; 
	}

	public static function formatImageUrl($image, $size = '', $params=array()){
		extract((array)$params);

		$default_image = (isset($default_image)) ? $default_image : 'default_image.png';
		$image = trim($image);
		$qref = (isset($qref)) ? $qref : true;
		$qref = ($qref) ? '?ref='.$flag : '';

		$cdn_enabled = \Config::get('sglv-core::image.cdn_enabled');
		$cdn_container = \Config::get('sglv-core::image.cdn_container');

		$path = (isset($path)) ? $path : '';
		$default_path = 'assets/images/defaults';

		if(!$image){
			$path = $default_path;
			$image = $default_image;
			$image = SglvCoreUtil::fileSuffix($image, $size, $path);
			$file_url = asset($image.$qref);
		}
		else{
			$image = SglvCoreUtil::fileSuffix($image, $size, $path);
			$file_url = self::assetCdn($image.$qref, $cdn_container);
		}
		
		// if(!file_exists(public_path().'/'.$image)){
		// 	$image = SglvCoreUtil::fileSuffix($default_image, 'not_found_'.$size, $default_path);
		// }

		// if(ping_remote_file($file_url) !== true){
		// 	$file_url = SglvCoreUtil::fileSuffix($default_image, 'not_found_'.$size, $default_path);
		// 	$file_url = asset($file_url);
		// }

		return $file_url; 
	}

	public static function assetCdn($file_url, $container=''){
		$upload_url = \Config::get('sglv-core::image.upload_url');
		$cdn_enabled = \Config::get('sglv-core::image.cdn_enabled', false);

		if($cdn_enabled && $container){
			$cdn_url = \Config::get('sglv-core::image.cdn_url');
			$upload_url = SG_Util::val($cdn_url, $container);
		}

		$upload_url = trim($upload_url,'/');

		return trim($upload_url.'/'.trim($file_url,'/'), '/');
	}

}