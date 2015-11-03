<?php 

namespace Lib;

use Scienceguard\SG_Util;

class Template{

	static $base_dir= '';
	static $head = '';
	static $foot = '';
	static $template = 'template_app';
	static $page = array();
	static $scripts = array();
	static $styles = array();

	public static function setBaseDir($base_dir)
	{
		self::$base_dir = $base_dir;
	}

	public static function getBaseDir()
	{
		return self::$base_dir;
	}

	public static function setTemplate($template)
	{
		self::$template = $template;
	}

	public static function getTemplate()
	{
		return self::$template;
	}

	public static function setPageParam($key, $val)
	{
		self::$page[$key] = $val;
	}

	public static function setPageTitle($val = '')
	{
		if(!$val){
			$val = SG_Util::slug(Request::path(), '_');
		}
		self::$page['title'] = $val;
	}

	public static function getPageParam($key)
	{
		return SG_Util::val(self::$page, $key);
	}
			
	public static function enqueueStyle($styles)
	{
		if(is_array($styles)){
			self::$styles = array_merge(	self::$styles, $styles );
		}
		else{
			self::$styles[] = $styles;
		}
	}
	
	public static function printStyle($position='bottom')
	{
		if(!isset(self::$styles)){
			return false;
		}

		$output = '';
		
		foreach(self::$styles as $style){
			$output .= '<link rel="stylesheet" href="'.asset($style).'" />';
		}		
		return $output;
	}
    	
	public static function enqueueScript($scripts)
	{
		if(is_array($scripts)){
			self::$scripts = array_merge(	self::$scripts, $scripts );
		}
		else{
			self::$scripts[] = $scripts;
		}		
	}
	
	public static function printScript($position='bottom')
	{
		if(!isset(self::$scripts)){
			return false;
		}

		$output = '';

		foreach(self::$scripts as $script){
			$script_url = (strpos($script, 'http:') !== false) ? $script : asset($script);			
			$output .= '<script type="text/javascript" src="'.$script_url.'"></script>'."\n";
		}		
		return $output;
	}

	public static function printMetas($metas = array())
	{
		// $default_metas = Config::get('nesia::template.default_metas');

		if(!$metas || !is_array($metas)){
			$metas = array();
		}

		$output = '';

		foreach($metas as $meta_key=>$meta_attr){
			if(!is_array($meta_attr)){
				$meta_attr = array();
			}

			$tag = SG_Util::val($meta_attr, 'tag');
			unset($meta_attr['tag']);

			$output .= ($tag) ? '<'.$tag.' '.SG_Util::inlineAttr($meta_attr, false).'/>'."\n" : '';
		}

		return $output;
	}

	public static function addHead($head)
	{
		self::$head .= "\n".$head;
	}

	public static function printHead()
	{
		return self::$head;
	}
}