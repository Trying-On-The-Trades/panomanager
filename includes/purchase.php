<?php

class purchase{
  protected $id, $date, $user_id;

  function __construct($id){
    if(is_numeric($id)){
      $purchase_row = get_purchase($id);
      $this->build($purchase_row);
    }
  }

  function build($purchase_row){
    if($purchase_row->id > 0){
      $this->exists = 1;
      $this->id = $purchase_row->id;
      $this->date = $purchase_row->date;
      $this->user_id = $purchase_row->user_id;
    }
  }

  function get_id(){
    return $this->id;
  }

  function get_date(){
    return $this->date;
  }

  function get_user_id(){
    return $this->user_id;
  }
  
}
