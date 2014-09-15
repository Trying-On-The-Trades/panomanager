<?php

class quest{

	protected $id, $pano_id, $description, 
			  $name, $language_code,
		      $missions = array(); 
	public	      $exists   = 0;
	
	function __construct($id){

		// Get the Quest (Skill) based on the id
		if (is_numeric($id)){
			$quest_row = get_quest($id);
			$this->build($quest_row);
		}
	}

	function build($quest_row){
		if ($quest_row->id > 0){
			$this->exists      = 1;
			$this->id          = $quest_row->id;
			$this->name        = $quest_row->name;
			$this->description = $quest_row->description;
                        
                        $this->build_missions();
		}
	}

	function build_missions(){
            $this->missions = get_mission_ids($this->id); 
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

	function get_missions(){
		return $this->missions;
	}

	function get_language(){
		return $this->language_code;
	}
}