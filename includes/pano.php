<?php

class pano{
	protected $id, $name, $description, 
                  $quests = array(), 
                  $missions, $language_code,
				  $quest_id,
                  $prereqs = array(),
                  $exists = 0,
                  $show_desc_onload = 0,
                  $xml;

	function __construct($id){

		// get the pano based on the id supplied
		if (is_numeric($id)){
			$pano_row = get_pano($id);
			$this->build($pano_row);
		}
	}

	// Load up the pano into the object
	function build($pano_row){

		// Load the data if the id exists
		if ($pano_row->id > 0){
			$this->exists      = 1;
			$this->xml              = $pano_row->pano_xml;
			$this->id               = $pano_row->pano_id;
			$this->title            = $pano_row->title;
			$this->name             = $pano_row->name;
			$this->description      = $pano_row->description;
            $this->show_desc_onload = $pano_row->show_desc_onload;

			$this->build_quest_id();
			$this->build_prereqs();
		}
	}

	function build_quest_id(){
		return $this->quest_id = get_quest_by_pano($this->id);
	}

	function build_prereqs(){
		return $this->prereqs = get_pano_prereq($this->id);
	}
        
	function get_prereq(){
		return $this->prereqs;
	}

	function get_id(){
		return $this->id;
	}

	function get_name(){
		return $this->name;
	}

	function get_title(){
		return $this->title;
	}

	function get_description(){
		return $this->description;
	}

	function get_pano_language(){
		return $this->language_code;
	}

	function get_xml(){
		return $this->xml;
	}

    function get_show_desc_onload(){
        return $this->show_desc_onload;
    }

	function get_quest_id(){
		return $this->id;
	}
}