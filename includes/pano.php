<?php

class pano{
	protected $id, $name, $description, $quests = array(), 
			  $missions, $language_code, $exists = 0;

	function __construct($id){

		// get the pano based on the id supplied
		if (is_numeric($id)){
			$pano_row = get_pano($id);
			$this->build($pano_row);
		}
	}

	// Load up the pano into the opbject
	function build($pano_row){

		// Load the data if the id exists
		if ($pano_row->id > 0){
			$this->exists      = 1;
			$this->id          = $pano_row->id; 
			$this->name        = $pano_row->name;
			$this->description = $pano_row->description;
		}
	}

	function get_name(){
		return $this->name;
	}

	function get_description(){
		return $this->description;
	}

	function get_quests(){
		return $this->quests;
	}

	function get_pano_language(){
		return $this->language_code;
	}
}