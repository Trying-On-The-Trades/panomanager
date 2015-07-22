<?php

class prereq_item{

    protected $prereq_id,
        $item_id,
        $exists   = 0;

    function __construct($prereq_id = 1, $item_id = 1){
        if (is_numeric($prereq_id) && is_numeric($item_id)){
            $prereq_items_row = get_prereq_item($prereq_id, $item_id);
            $this->build($prereq_items_row);
        }
    }

    function build($prereq_items_row){
        if ($prereq_items_row->prereq_id > 0 && $prereq_items_row->item_id > 0){
            $this->exists    = 1;
            $this->prereq_id = $prereq_items_row->prereq_id;
            $this->item_id   = $prereq_items_row->item_id;
        }
    }

    function get_prereq_id(){
        return $this->prereq_id;
    }

    function get_item_id(){
        return $this->item_id;
    }
}