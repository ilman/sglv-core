<?php 

use Scienceguard\SG_Util;
use Scienceguard\SG_Form;
use Lib\SglvCoreUtil;

class SG_Tags{

	static function spacer($attr=array()){
		
		$attr['class'] = trim('vspacer '.SG_Util::val($attr, 'class'));
		$output = '<div '.SG_Util::inlineAttr($attr).'></div>';	

		return $output;
	}

	static function divider($attr=array()){
		
		$output = '<div class="hr"><hr></div>';	

		return $output;
	}

	static function popover($attr=array(), $content=''){

		$content = '<div class="popover-content">'.$content.'</div>';
		$output = '<div class="popover top"><div class="arrow"></div>'.$content.'</div>';

		return $output;
	}

	static function headTitle($page_title, $params=array()){

		if(!$page_title){
			return;
		}

		$page_title = SG_Util::slug($page_title, '_');
		if(strpos($page_title, 'heading') === false){
			$page_title = 'heading.'.$page_title;
		}

		$output = trans($page_title, $params);

		return $output;
	}

	static function pageTitle($page_title, $params=array()){

		if(!$page_title){
			return;
		}

		$page_title = SG_Util::slug($page_title, '_');
		$page_icon = SG_Util::val($params, 'icon', 'icon-page');
		if(strpos($page_title, 'heading') === false){
			$page_title = 'heading.'.$page_title;
		}

		$output = '<h2 class="page-title"><i class="icon32 '.$page_icon.'"></i> '.trans($page_title, $params).'</h2>';

		return $output;
	}

	static function breadcrumb($str_path){

		$paths = explode('/', $str_path);
		$paths_count = count($paths);
		$path_url = '';

		$output = '<ol class="breadcrumb">';
		for($i=0; $i<$paths_count; $i++){

			$path_text = ucwords(str_replace('_', ' ', $paths[$i]));
			$path_url .= '/'.$paths[$i];

			if($i<$paths_count-1){
				$output .= '<li><a href="'.url($path_url).'">'.$path_text.'</a></li>';
			}
			else{
				$output .= '<li class="active">'.$path_text.'</li>';
			}
		}
		$output .= '</ol>';

		return $output;
	}

	static function navTabs($tabs)
	{
		$output = '<ul class="nav nav-tabs div-tabs">';
		foreach($tabs as $tab){
			$tab_label = SG_Util::val($tab,'label');
			$tab_value = SG_Util::val($tab,'value');
			$tab_notif = SG_Util::val($tab, 'notif');
			$tab_notif = ($tab_notif) ? ' <span class="badge bg-danger">'.$tab_notif.'</span>' : '';

			$li_class = (SglvCoreUtil::urlCompares('',$tab_value)) ? 'active' : '';
			$output .= '<li class="'.$li_class.'"><a href="'.url($tab_value).'">'.trans($tab_label).$tab_notif.'</a></li>';
		}
		$output .= '</ul>';

		return $output;
	}

	static function listTree($datas, $params=array(), $parent=0, $depth=0)
	{
		$ul_class = SG_Util::val($params, 'ul_class');
		$li_class = SG_Util::val($params, 'li_class');

		$ul_class = (isset($ul_class[$depth])) ? ' class="'.$ul_class[$depth].'"' : '';
		$li_class = (isset($li_class[$depth])) ? ' class="'.$li_class[$depth].'"' : '';

		$output = '<ul'.$ul_class.'>';
		$sub_output = '';
		foreach($datas as $row){
			if(is_array($row)){ $row = (object) $row; }
			
			if($row->parent_id == $parent){
				$sub_output .= '<li'.$li_class.'>';
				$sub_output .= '<a>'.$row->cat_name.'</a>';
				$sub_output .= self::listTree($datas, $params, $row->id, $depth+1);
				$sub_output .= '</li>';
			}
		}
		$output .= $sub_output.'</ul>';

		return ($sub_output) ? $output : '';
	}

	static function inputFilter($attr)
	{
		$attr['placeholder'] = 'Filter';

		$output = '<div class="input-group input-filter">';
		$output .= SG_Form::field('text', 'filter', Input::get('filter'), $attr);
		$output .= '<span class="input-group-btn">';
		$output .= '<button class="btn btn-default" type="submit">'.trans('label.btn_search').'</button>';
		$output .= '</span></div>';

		return $output;
	}

}