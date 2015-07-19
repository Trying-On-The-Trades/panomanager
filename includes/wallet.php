<?php

class wallet{
  protected $id, $available_currency, $user_id;

  function __construct($id){
    if(is_numeric($id)){
      $wallet_row = get_wallet($id);
      $this->build($wallet_row);
    }
  }

  function build($wallet_row){
    if($wallet_row->id > 0){
      $this->exists = 1;
      $this->id = $wallet_row->id;
      $this->available_currency = $wallet_row->available_currency;
      $this->user_id = $wallet_row->user_id;
    }
  }

  function get_id(){
    return $this->id;
  }

  function get_available_currency(){
    return $this->available_currency;
  }

  function get_user_id(){
    return $this->user_id;
  }

}
