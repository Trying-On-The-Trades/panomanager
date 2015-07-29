<?php

class hotspot_completed{
    protected $hotspot_id, $user_id, $price;

    function __construct($id){
        if(is_numeric($id)){
            $hotspot_completed_row = get_hotspot_completed_table($id);
            $this->build($hotspot_completed_row);
        }
    }

    function build($hotspot_completed_row){
        if($hotspot_completed_row->id > 0){
            $this->exists = 1;
            $this->hotspot_id = $hotspot_completed_row->hotspot_id;
            $this->user_id = $hotspot_completed_row->user_id;
        }
    }

    function get_hotspot_id(){
        return $this->hotspot_id;
    }

    function get_user_id(){
        return $this->user_id;
    }

}
