<?php 

if(!isset($base_dir)){
	$base_dir = '';
}

if(Request::ajax()){
	include(view_path('template_ajax'));
}
elseif(isset($template)){
	include(view_path($template));
}
elseif(isset($theme)){
	if(!$theme){
		$theme = '_default';
	}

	$theme_path = 'uploads/themes/'.$theme;

	include(public_path($theme_path.'/base.php'));
	return true;
}
else{
	include(view_path(\Lib\Template::getTemplate()));
}