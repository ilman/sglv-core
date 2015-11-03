<?php 

function view_path($path, $suffix='.php')
{
	$view_path = app_path('views/'.$path.$suffix);
	if(file_exists($view_path)){
		return $view_path;
	}

	$base_dir = Lib\Template::getBaseDir();

	if(!$base_dir){
		$base_dir = __DIR__;
	}

	$view_path = $base_dir.'/views/'.$path.$suffix;
	return $view_path;
}