<?php

class hotspot{

	protected $id, $pano_id, $mission_id, $description, $hotspot_info,
                  $name, $menu_name, $language_code, 
                  $xml, $action_xml, $points, $menu_item,
                  $type_id, $attempts, $domain_id, $modal_url,
                  $mission_name, $type_name,
                  $type_description,
                  $type_js_function;
        protected $completed_state = false;
        public    $exists   = 0;
	
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
            $this->menu_item   = $hotspot_row->menu_item;
            $this->id          = $hotspot_row->id;
            $this->mission_id  = $hotspot_row->mission_id;
            $this->attempts    = $hotspot_row->attempts;
            $this->name        = $hotspot_row->name;
            $this->menu_name   = $hotspot_row->menu_name;
            $this->description = $hotspot_row->description;
            $this->hotspot_info = $hotspot_row->hotspot_info;
            $this->points      = $hotspot_row->points;
            $this->xml         = $hotspot_row->hotspot_xml;
            $this->action_xml  = $hotspot_row->action_xml;
            $this->domain_id    = $hotspot_row->domain_id;
            $this->modal_url   = $hotspot_row->modal_url;
            $this->type_id     = $hotspot_row->type_id;
            $this->type_name   = $hotspot_row->type_name;
            $this->type_description = $hotspot_row->type_description;
            $this->type_js_function = $hotspot_row->type_js_function;

            $this->build_mission();
            $this->build_domain();
        }
	}

    function build_mission(){
        // Gets the domain name associated with the mission
        $mission = get_mission($this->mission_id);
        $this->mission_name = $mission->name;
    }


    function build_domain(){
        // Gets the domain name associated with the mission
        $domain = get_domain($this->domain_id);
        $this->domain_name = $domain->name;
    }

    function get_id(){
        return $this->id;
    }

    function get_mission_id(){
        return $this->mission_id;
    }

    function get_mission_name(){
        return $this->mission_name;
    }

    function get_name(){
        return $this->name;
    }

    function get_menu_name(){
        return $this->menu_name;
    }

    function get_description(){
        return $this->description;
    }

    function get_hotspot_info(){
        return $this->hotspot_info;
    }

    function get_xml(){
        return $this->xml;
    }

    function get_action_xml(){
        return $this->action_xml;
    }

    function get_domain_id(){
        return $this->domain_id;
    }

    function get_domain_name(){
        return $this->domain_name;
    }

    function get_modal_url(){
        return $this->modal_url;
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

    function get_type_js_function(){
        return $this->type_js_function;
    }

    function get_attempts(){
        return $this->attempts;
    }

    function get_completed_state(){
        return $this->completed_state;
    }

    function set_completed_state($completed_state){
        $this->completed_state = $completed_state;
    }

    function is_menu_item(){
        if ($this->menu_item == 1){
            return true;
        } else {
            return false;
        }
    }

    function is_home(){
        if ($this->type_js_function == "goHome"){
            return true;
        } else {
            return false;
        }
    }

    function is_default(){
        if (is_null($this->type_js_function)){
            return true;
        } else {
            return false;
        }
    }
}