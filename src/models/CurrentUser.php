<?php 

use Scienceguard\SG_Util;

class CurrentUser{

	public static function getUser(){
		$current_user = Auth::user();

		if(!$current_user){
			return false;
		}

		$current_user->groups = array(SG_Util::val($current_user, 'type'));

		return $current_user;
	}
}