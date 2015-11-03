<?php 

namespace Lib;

use Request;
use Input;

class PaginationUtil{
	
	public static function paginationText($result){
		$current_page = $result->current_page;
		$last_page = $result->last_page;
		$per_page = $result->per_page;
		$total = SglvCoreUtil::formatNumber($result->total);

		$from = SglvCoreUtil::formatNumber(($per_page * ($current_page - 1)) + 1);
		$to = SglvCoreUtil::formatNumber($per_page * ($current_page));

		// $output = "Menampilkan $from - $to dari total $total data";
		$output = trans('label.show_from_to_total', array('from'=>$from, 'to'=>$to, 'sumtotal'=>$total));

		return $output;
	}

	public static function paginationLinks($result, $params=false, $base_url=false){
		$current_page = $result->current_page;
		$last_page = $result->last_page;
		$per_page = $result->per_page;
		$total = $result->total;

		$base_url = ($base_url) ? $base_url : Request::url();
		$params = ($params) ? $params : Input::all();
		unset($params['page']);
		$params = http_build_query($params);

		$output = '<ul class="pagination">';

		// goto prev link
		if($current_page>1){
			$param_page = 'page='.($current_page-1);
			$query = trim($param_page.'&'.$params, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
		}
		else{
			$link = false;
		}
		if($link){
			$output .= '<li><a href="'.$link.'">&laquo;</a></li>';
		}
		else{
			$output .= '<li class="disabled"><span>&laquo;</span></li>';
		}

		// goto page link
		$first_page = 1;
		$segment = 7;
		$segment_avg = floor($segment/2);

		if($last_page<=$segment){
			$segment_1 = $last_page;
			$segment_2 = 0;
			$segment_3 = 0;
		}
		else{

			$segment_1_0 = $first_page-1+$current_page-1;
			$segment_3_0 = $last_page+1-$current_page-1;

			if($segment_1_0<$segment_avg){
				$segment_1 = $segment_avg + $segment_1_0;
				$segment_2 = 0;
				$segment_3 = $segment_avg - $segment_1_0;
			}
			elseif($segment_3_0<$segment_avg){
				$segment_1 = $segment_avg - $segment_3_0;
				$segment_2 = 0;
				$segment_3 = $segment_avg + $segment_3_0;
			}
			else{
				$segment_1 = 1;
				$segment_2 = $segment_avg;
				$segment_3 = 1;
			}

		}

		if($segment_1){
			for($i=$first_page; $i<$first_page+$segment_1; $i++){
				$param_page = ($i>1) ? 'page='.$i : '';
				$query = trim($param_page.'&'.$params, '&');
				$link = ($query) ? $base_url.'?'.$query : $base_url;
				$li_class = ($i==$current_page) ? ' class="active"' : '';
				$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
				$segment -= 1;
			}
			if($segment_3){
				$output .= '<li><span>&hellip;</span></li>';
			}
		}

		if($segment_2){
			for($i=$current_page-1; $i<$current_page+$segment_2-1; $i++){
				$param_page = 'page='.$i;
				$query = trim($param_page.'&'.$params, '&');
				$link = ($query) ? $base_url.'?'.$query : $base_url;
				$li_class = ($i==$current_page) ? ' class="active"' : '';
				$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
				$segment -= 1;
			}
			if($segment_3){
				$output .= '<li><span>&hellip;</span></li>';
			}
		}

		if($segment_3){
			for($i=$last_page-$segment_3+1; $i<=$last_page; $i++){
				$param_page = 'page='.$i;
				$query = trim($param_page.'&'.$params, '&');
				$link = ($query) ? $base_url.'?'.$query : $base_url;
				$li_class = ($i==$current_page) ? ' class="active"' : '';
				$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
				$segment -= 1;
			}
		}


		// goto next link
		if($current_page<$last_page){
			$param_page = 'page='.($current_page+1);
			$query = trim($param_page.'&'.$params, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
		}
		else{
			$link = false;
		}

		if($link){
			$output .= '<li><a href="'.$link.'">&raquo;</a></li>';
		}
		else{
			$output .= '<li class="disabled"><span>&raquo;</span></li>';
		}	

		$output .= '</ul>';

		return $output;
	}
}