<?php

class item{
  protected $id, $name, $description, $imge, $price, $type_id;

  function __construct($id){
    $item_row = get_item($id);
    $this->build($item_row);
  }

  function build($item_row){
    if($item_row->id > 0){
      $this->exists = 1;
      $this->id = $item_row->id;
      $this->name = $item_row->name;
      $this->description = $item_row->description;
      $this->image = $item_row->image;
      $this->price = $item_row->price;
      $this->type_id = $item_row->type_id;
    }
  }

  function get_id(){
    return $this->id;
  }

  function get_name(){
    return $this->name;
  }

  function get_description(){
    return $this->description;
  }

  function get_image(){
    return $this->image;
  }

  function get_price(){
    return $this->price;
  }

  function get_type_id(){
    return $this->type_id;
  }
}
