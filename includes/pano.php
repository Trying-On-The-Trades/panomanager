<?php

class pano{
	protected $name, $description, $quests, $missions;

	function __construct($id){
		// get the pano based on the id supplied
		if (is_numeric($id)){
			$pano_row = get_pano($id);
			$this->build($pano_row);
		}
	}

	// Load up the pano into the opbject
	function build($pano_row){
		$this->name = "";

	}

	function get_name(){
		return $this->name;
	}

	function get_description(){
		return $this->description;
	}
}