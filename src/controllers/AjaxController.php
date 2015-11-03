<?php

namespace Scienceguard\SglvCore\Controllers;

use Scienceguard\SglvCore\Controllers\BaseController;
use Input;
use DB;
use Response;

use Scienceguard\SG_Util;

class AjaxController extends BaseController {

    var $allowed_table = array('users','location_provinces','location_cities','location_areas','location_districts','product_categories','product_brands','product_tags');
    var $restricted_field = array('email','phone','password');

    public function isAllowed($table, $field)
    {
        if(!in_array($table, $this->allowed_table)){
            return false;
        }

        if($field && in_array($field, $this->restricted_field)){
            return false;
        }

        return true;
    }

    public function postOptions()
    {
        $table = Input::get('table');
        $key = Input::get('key');
        $val = Input::get('val');
        $label = Input::get('label');
        $ops = Input::get('ops','=');
        $prefix = Input::get('prefix','');
        $suffix = Input::get('prefix','');
        $con = Input::get('con');
        $con = ($con) ? '_'.$con : '';

        if(!$this->isAllowed($table, $label)){
            $data = array(
                'error' => true, 
                'message' => 'notif.request_isnt_allowed', 
            );
            return Response::json($data, 500);
        }

        $model = DB::connection('mysql'.$con)
        ->table($table)
        ->select($label.' as label', 'id as value')
        ->where($key, $ops, $val);

        return Response::json($model->get());
    }

    public function postValue()
    {
        $table = Input::get('table');
        $key = Input::get('key');
        $val = Input::get('val');
        $field = Input::get('field');
        $ops = Input::get('ops','=');
        $prefix = Input::get('prefix','');
        $suffix = Input::get('prefix','');
        $con = Input::get('con');
        $con = ($con) ? '_'.$con : '';

        if(!$this->isAllowed($table, $field)){
            $data = array(
                'error' => true, 
                'message' => 'notif.request_isnt_allowed', 
            );
            return Response::json($data, 500);
        }

        $model = DB::connection('mysql'.$con)
        ->table($table)
        ->select($field)
        ->where($key, $ops, $val);

        return Response::json($model->pluck($field));
    }

    public function postOptionParent()
    {
        $table = Input::get('table');
        $key = Input::get('key');
        $val = Input::get('val');
        $label = Input::get('label');
        $parent_key = Input::get('parent_key');
        $ops = Input::get('ops','=');
        $con = Input::get('con');
        $con = ($con) ? '_'.$con : '';

        if(!$this->isAllowed($table, $field)){
            $data = array(
                'error' => true, 
                'message' => 'notif.request_isnt_allowed', 
            );
            return Response::json($data, 500);
        }

        $model = DB::connection('mysql'.$con)
        ->table($table)
        ->select($parent_key.' as parent_id')
        ->where($key, '=', $val);

        $parent_id = $model->pluck('parent_id');

        $model = DB::connection('mysql'.$con)
        ->table($table)
        ->select($label.' as label', 'id as value')
        ->where($parent_key, '=', $parent_id);

        return Response::json($model->get());
    }

}