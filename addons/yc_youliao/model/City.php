<?php
include_once("Common.php");
class City extends Common{
     public $city_id= 'city_id';
     public $name= 'name';
     public $pinyin= 'pinyin';
     public $isopen = 'isopen';
     public $lng  = 'lng';
     public $lat = 'lat';
     public $theme   = 'theme';
     public $orderby = 'orderby';
     public $first_letter = 'first_letter';
     public $is_hot = 'is_hot';

    public function __construct(){
        $this->setTable('mihua_sq_city');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        return parent::add($arr);
    }
    public function dataEdit($id,$up=false){
        $where[$this->city_id]    = $id;
        $result              = parent::edit($where,$up);
        return $result;
    }

 
}