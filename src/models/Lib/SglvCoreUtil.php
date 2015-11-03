<?php 

namespace Lib;

use Scienceguard\SG_Util;

class SglvCoreUtil{

	public static function ordinalSuffix($num){
		$num = $num % 100; // protect against large numbers
		$suffix = 'th';
		if($num < 11 || $num > 13){
			switch($num % 10){
				case 1: $suffix = 'st'; break;
				case 2: $suffix = 'nd'; break;
				case 3: $suffix = 'rd'; break;
			}
		}
		return $num.$suffix;
	}

	public static function fileSuffix($file, $suffix='', $path=''){
		if($file){
			$path_part = pathinfo($file);
			$file_name = SG_Util::val($path_part, 'filename');
			$file_ext  = SG_Util::val($path_part, 'extension');

			if($suffix){
				$file_name = $file_name.'_'.$suffix.'.'.$file_ext;
			}
			else{
				$file_name = $file_name.'.'.$file_ext;
			}

			return ($path) ? $path.'/'.$file_name : $file_name;;
		}
		else{
			return false;
		}
	}

	public static function getFileSuffix($file, $delimiter='_'){
		if($file){
			$path_part = pathinfo($file);
			$file_name = SG_Util::val($path_part, 'filename');
			$file_ext  = SG_Util::val($path_part, 'extension');

			$arr = explode($delimiter, $file_name);

			return end($arr);
		}
		else{
			return false;
		}
	}

	public static function formatNumber($number){
		return number_format($number,0,',','.');
	}

	public static function getCompares($haystack, $needle, $return=true){
		if(strpos($haystack, $needle)!==false){
			return $return;
		}
	}

	public static function urlCompares($haystack, $needle, $wildcard=false){
		if(!$haystack){
			$haystack = \Request::url();
		}

		$needle = url($needle);

		if($wildcard){
			return self::getCompares($haystack, $needle);
		}

		return ($haystack == $needle);
	}


	public static function interpolateQuery($query, $params){
	    $keys = array();
	    $vals = array();

	    // build a regular expression for each parameter
	    foreach ($params as $key => $value) {
	        if (is_string($key)) {
	            $keys[] = '/:'.$key.'/';
	        } else {
	            $keys[] = '/[?]/';
	        }

	        if(is_string($value)) {
	        	$vals[] = "'".htmlspecialchars($value)."'";
	        }
	        else{
	        	$vals[] = $value;
	        }
	    }

	    $query = preg_replace($keys, $vals, $query, 1, $count);

	    // trigger_error('replaced '.$count.' keys');

	    return $query;
	}

	public static function arrayTotal($array){
		$total = 0;

		foreach($array as $row){
			$total += (int) $row;
		}

		return $total;
	}

	public static function arrayTree($array, $parent=0){
		$new_array = array();
		$sub_array = array();
		$i=0;
		foreach($array as $row){
			if(is_array($row)){ $row = (object) $row; }
			
			if($row->parent_id == $parent){
				$new_array[$i] = $row;
				$new_array[$i]->childs = self::arrayTree($array, $row->id);
			}
			$i++;
		}

		return $new_array;
	}

	public static function splitSlugID($string, $delimiter='-'){
		$reversed = explode($delimiter, strrev($string), 2);
		$result = array();
		if(isset($reversed[1])){
			$result['id'] = strrev($reversed[0]);
			$result['slug'] = strrev($reversed[1]);
		}
		else{
			$result['slug'] = strrev($reversed[0]);
			$result['id'] = 0;
		}

		return (object) $result;		
	}
}