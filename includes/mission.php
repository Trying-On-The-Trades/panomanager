<?php

class mission{

	protected $id, $pano_id, $description, 
                  $name, $language_code,
                  $xml, $points, $quest_id,
				  $domain_id, $domain_name,
                  $hotspots = array(),
		  $exists   = 0;
	
	function __construct($id){

		// Get the Quest (Skill) based on the id
		if (is_numeric($id)){
			$mission_row = get_mission($id);
			$this->build($mission_row);
		}
	}

	function build($mission_row){
            if ($mission_row->id > 0){
                $this->exists        = 1;
                $this->id            = $mission_row->mission_id;
                $this->name          = $mission_row->name;
				$this->description   = $mission_row->description;
				$this->language_code = $mission_row->language_code;
				$this->quest_id      = $mission_row->quest_id;
				$this->pano_id       = $mission_row->pano_id;
				$this->domain_id     = $mission_row->domain_id;
                $this->points        = $mission_row->points;
                $this->xml           = $mission_row->mission_xml;

                // Build the hotspots for this mission
                $this->build_hotspots();
				$this->build_domain();
            }
	}

	function build_hotspots(){
		// Get all the hotspots
		$this->hotspots = get_hotspot_ids($this->id);
	}

	function build_domain(){
		// Gets the domain name associated with the mission
		$domain = get_domain($this->domain_id);
		$this->domain_name = $domain->name;
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

	function get_pano_id(){
		return $this->pano_id;
	}

	function get_domain_id(){
		return $this->domain_id;
	}

	function get_domain_name(){
		return $this->domain_name;
	}

	function get_points(){
		return $this->points;
	}
}