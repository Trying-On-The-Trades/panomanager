<?php

class hotspot{

	protected $id, $pano_id, $description, 
                  $name, $language_code, 
                  $xml, $points,
                  $type_id,
                  $type_name,
                  $type_description,
		  $exists   = 0;
	
	function __construct($id = 1){

		// Get the Quest (Skill) based on the id
		if (is_numeric($id)){
			$hotspot_row = get_hotspot($id);
			$this->build($hotspot_row);
		}
	}

	function build($hotspot_row){
            if ($hotspot_row->id > 0){
                $this->exists      = 1;
                $this->id          = $hotspot_row->id;
                $this->name        = $hotspot_row->name;
                $this->description = $hotspot_row->description;
                $this->points      = $hotspot_row->points;
                $this->xml         = $hotspot_row->hotspot_xml;
                $this->type_id     = $hotspot_row->type_id;
                $this->type_name   = $hotspot_row->type_name;
                $this->type_description = $hotspot_row->type_description;
            }
	}
        
        function get_id(){
            return $this->id();
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
        
        function get_points(){
            return $this->points;
        }

	function get_language(){
		return $this->language_code;
	}
        
        function get_type_id(){
            return $this->type_id;
        }
        
        function get_type_name(){
            return $this->type_name;
        }
        
        function get_type_description(){
            return $this->type_description;
        }
}