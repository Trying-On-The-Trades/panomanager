<?php

class hotspotType{

	protected $id,
              $name,
              $description,
              $type_xml,
              $js_function;
    public    $exists   = 0;
	
	function __construct($id = 1){

		// Get the Quest (Skill) based on the id
		if (is_numeric($id)){
			$hotspot_type_row = get_hotspot_type($id);
			$this->build($hotspot_type_row);
		}
	}

	function build($hotspot_type_row){
            if ($hotspot_type_row->id > 0){
                $this->exists      = 1;
                $this->id          = $hotspot_type_row->id;
                $this->name        = $hotspot_type_row->name;
                $this->description = $hotspot_type_row->description;
                $this->xml         = $hotspot_type_row->type_xml;
                $this->js_function = $hotspot_type_row->js_function;
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

    function get_xml(){
        return $this->xml;
    }

    function get_type_js_function(){
        return $this->js_function;
    }

    function is_home(){
        if ($this->js_function == "goHome"){
            return true;
        } else {
            return false;
        }
    }

    function is_default(){
        if (is_null($this->js_function)){
            return true;
        } else {
            return false;
        }
    }
}