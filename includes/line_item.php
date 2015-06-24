<?php

class line_item{
  protected $purchase_id, $item_id, $price;

  function __construct($id){
    if(is_numeric($id)){
      $line_item_row = get_line_item($id);
      $this->build($line_item_row);
    }
  }

  function build($line_item_row){
    if($line_item_row->id > 0){
      $this->exists = 1;
      $this->purchase_id = $line_item_row->purchase_id;
      $this->item_id = $line_item_row->item_id;
      $this->price = $line_item_row->price;
    }
  }

  function get_purchase_id(){
    return $this->purchase_id;
  }

  function get_item_id(){
    return $this->item_id;
  }

  function get_price(){
    return $this->price;
  }
  
}
