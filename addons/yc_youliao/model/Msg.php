<?php
include_once("Common.php");
class Msg extends common{
     public $msg_id         = 'msg_id';
     public $msg_title      = 'msg_title';
     public $msg_content    = 'msg_content';
     public $status         = 'status';
    public $type            = 'type';

    public function __construct(){
        $this->setTable(MSG);
        $this->setGlobal();
    }
    public function dataAdd($arr){
        return parent::add($arr);
    }
    public function dataEdit($id,$up=false){
        $where[$this->msg_id] = $id;
        $result               = parent::edit($where,$up);
        return $result;
    }
  
}