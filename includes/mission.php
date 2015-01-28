<?php

class mission{

	protected $id, $pano_id, $description, 
                  $name, $language_code,
                  $xml, $points, $quest_id,
				  $trade_id, $trade_name,
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
                $this->exists        = 1;
                $this->id            = $mission_row->mission_id;
                $this->name          = $mission_row->name;
				$this->description   = $mission_row->description;
				$this->language_code = $mission_row->language_code;
				$this->quest_id      = $mission_row->quest_id;
				$this->pano_id       = $mission_row->pano_id;
				$this->trade_id      = $mission_row->trade_id;
                $this->points        = $mission_row->points;
                $this->xml           = $mission_row->mission_xml;

                // Build the hotspots for this mission
                $this->build_hotspots();
				$this->build_trade();
            }
	}

	function build_hotspots(){
		// Get all the hotspots
		$this->hotspots = get_hotspot_ids($this->id);
	}

	function build_trade(){
		// Gets the trade name associated with the mission
		$trade = get_trade($this->trade_id);
		$this->trade_name = $trade->name;
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

	function get_trade_id(){
		return $this->trade_id;
	}

	function get_trade_name(){
		return $this->trade_name;
	}

	function get_points(){
		return $this->points;
	}
}