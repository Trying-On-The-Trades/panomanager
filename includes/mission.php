<?php

class mission{

	protected $id, $pano_id, $description, 
                  $name, $language_code,
                  $xml, $points, $quest_id,
                  $hotspots = array(),
		  $exists   = 0;
	
	function __construct($id = 1){

		// Get the Quest (Skill) based on the id
		if (is_numeric($id)){
			$mission_row = get_mission($id);
			$this->build($mission_row);
		}
	}

	function build($mission_row){
            if ($mission_row->id > 0){
                $this->exists      = 1;
                $this->id          = $mission_row->mission_id;
                $this->name        = $mission_row->name;
                $this->description = $mission_row->description;
				$this->quest_id    = $mission_row->quest_id;
                $this->points      = $mission_row->points;
                $this->xml         = $mission_row->mission_xml;

                // Build the hotspots for this mission
                $this->build_hotspots();
            }
	} 

	function build_hotspots(){
            
            // Get all the hotspots
            $this->hotspots = get_hotspot_ids($this->id);
            
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

	function get_hotspots(){
		return $this->hotspots;
	}

	function get_language(){
		return $this->language_code;
	}
        
	function get_xml(){
		return $this->xml;
	}

	function get_quest_id(){
		return $this->quest_id;
	}

	function get_points(){
		return $this->points;
	}
}