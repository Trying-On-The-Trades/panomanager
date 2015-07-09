<?php

class item_type{
  protected $id, $name, $description;

  function __construct($id){
    if(is_numeric($id)){
      $item_type_row = get_item_type($id);
      $this->build($item_type_row);
    }
  }

  function build($item_type_row){
    if($item_type_row->id > 0){
      $this->exists = 1;
      $this->id = $item_type_row->id;
      $this->name = $item_type_row->name;
      $this->description = $item_type_row->description;
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
  
}
