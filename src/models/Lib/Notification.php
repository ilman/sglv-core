<?php 

use Scienceguard\SG_Util;

class Notification{

	private static $message = 0;

	public static function success($message)
	{
		return Session::push('notif.success', $message);
	}

	public static function error($message)
	{
		return Session::push('notif.error', $message);
	}

	public static function warning($message)
	{
		return Session::push('notif.warning', $message);
	}

	public static function info($message)
	{
		return Session::push('notif.info', $message);
	}

	public static function has($key, $session=null)
	{
		$values = (is_object($session)) ? $session->get('notif') : Session::get('notif');
		$sub_values = SG_Util::val($values, $key);

		if(is_array($sub_values)){
			return (count($sub_values)) ? true : false;
		}
		else{
			return ($sub_values) ? true : false;
		}
	}

	public static function container()
	{
		$output = '';
		$values = Session::get('notif');

		if(!is_array($values)){
			return $output;
		}

		foreach($values as $key=>$vals){			
			foreach($vals as $val){
				$output .= self::render($val, $key);
			}
		}

		return $output;
	}

	public static function clearAll()
	{
		return Session::forget('notif');
	}

	public static function errorInstant($values)
	{
		$output = '';

		if(!is_array($values)){
			return $output;
		}

		foreach($values as $val){
			$output .= self::render($val, 'error');
		}
		return $output;
	}

	public static function render($content, $key='default')
	{
		$class = 'default';
		if($key == 'error'){
			$class = 'danger';
		}
		elseif(in_array($key, array('success', 'info', 'warning'))){
			$class = $key;
		}

		return '<div class="alert alert-'.$class.'">'.$content.'</div>';
	}
}