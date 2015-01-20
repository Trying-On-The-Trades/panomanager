<?php

// ***********************************************************
//		    FUNCTIONS TO BUILD OUTPUT
// ***********************************************************

// The function that actually handles replacing the short code
function pano_handler($incomingfrompost) {

  $script_text;

  $incomingfrompost=shortcode_atts(array(
    "headingstart" => $script_text
  ), $incomingfrompost);

  $pano_output = pano_script_output($incomingfrompost);
  return $pano_output;
}

// function that can be called from a page template
function load_pano($pano_id = 1){

	// Make sure the pano exists before trying to load it
	$id = check_pano_id($pano_id);

	// Check if the user is aloud to see it
//	$id = check_user_progress($id);

	$pano = build_pano($id);
        $quest = build_quest($id);
        
	$javascript = build_pano_javascript($id, $pano, $quest);

	return $javascript;
}

function check_user_progress($pano_id){
	// Check the user's progress before allowing 
	// the user to see the pano
	$allowed = false;
        
        $user_id = get_current_user_id();

	// Check if the pano has a prereq
	$prereq = get_pano_prereqs($pano_id);

	// if it does make sure the user has completed 
	// enough skills and missions
        if ($prereq.length > 0){
            
            // Get the points by mission
            $mission_points = get_user_mission_points($mission_id, $user_id);
            
            // Get the points by skill
            $skill_points = get_user_skill_points($skill_id, $user_id);
            // Add up the points
            $total_points = $mission_points + $skill_points;
            
            // check if they are enough for the prereq
            if ($total_points >= $prereq->points){
                $allowed = true;
            }
        }

	// If they have, return the pano else return default id
	if ($allowed){
		return $pano_id;
	} else {
		return 1;
	}
}

function get_pano_prereqs($pano_id){
    $prereq = get_pano_prereq($pano_id);
    return $prereq;
}

function build_pano($pano_id = 1){

	// Make a new pano object from the supplied id
	$pano = new pano($pano_id);

  	return $pano;
}

function build_quest($quest_id = 1){
    $quest = new quest($quest_id);
    return $quest;
}

// Get the user's prefered language
function get_user_language(){
	// placeholder
	return "'EN'";
}

// build the script to replace the short code
function pano_script_output($incomingfromhandler) {
  $pano_output = "";
  return $pano_output;
}

function check_pano_id($pano_id){
        // Get the allowed pano ids
	$existing_panos = get_pano_ids();
	$existing_ids = array();

	// Get the ids from the array of arrays
	foreach ($existing_panos as $ex) {
		array_push($existing_ids, $ex['id']);
	}

	if (in_array($pano_id, array_values($existing_ids))){
		return $pano_id;
	} else {
		return 1;
	}
}

function get_hotspot_menu_objects($quest){
    
    $user_id = get_current_user_id();
    $hotspot_ids    = array();
    $hotspots       = array();
    $missions_array = array();
    
    // Get the missions
    if ($quest->exists){
        
        $missions = $quest->get_missions();

        foreach ($missions as $mission) {
            array_push($missions_array,$mission->id);
        }

        foreach ($missions_array as $mission_id) {
            $current_mission = new mission($mission_id);

            // Get the hotspot ids from the current mission, add them to the array
            $current_hotspots = $current_mission->get_hotspots();

            foreach ($current_hotspots as $ch) {
                array_push($hotspot_ids, $ch->id);
            }
        }

        foreach ($hotspot_ids as $hid) {
            $new_hotspot = new hotspot($hid);
            
            $progress = check_hotspot_prgress($hid, $user_id);
            
            if(count($progress) > 0){
                $new_hotspot->set_completed_state(true);
            }
            
            array_push($hotspots, $new_hotspot);
        }
    
    }
    return $hotspots;
}

function get_hotspot_objects($quest){
    $hotspot_ids    = array();
    $hotspots       = array();
    $hotspot_xml_objects = array();
    $missions_array = array();
    
    // Get the missions
    if ($quest->exists){
        
        $missions = $quest->get_missions();

        foreach ($missions as $mission) {
            array_push($missions_array,$mission->id);
        }

        foreach ($missions_array as $mission_id) {
            $current_mission = new mission($mission_id);

            // Get the hotspot ids from the current mission, add them to the array
            $current_hotspots = $current_mission->get_hotspots();

            foreach ($current_hotspots as $ch) {
                array_push($hotspot_ids,$ch->id);
            }
        }

        foreach ($hotspot_ids as $hid) {
            $new_hotspot = new hotspot($hid);
            array_push($hotspots, $new_hotspot);
        }

        // Turn the xml from each of the hotspots into an xml object
        foreach ($hotspots as $xml){
            $new_xml_obj = simplexml_load_string($xml->get_xml());
            array_push($hotspot_xml_objects, $new_xml_obj);
        }
    
    }
    return $hotspot_xml_objects;
}

// ***********************************************************
//				    Processing User Progress
// ***********************************************************

function update_pano_user_progress() {
	global $wpdb; // this is how you get access to the database

        // Get the user id and hotspot id
        $user_id = get_current_user_id();
	$hotspot_id = $_POST['hotspot'];
        $points = 0;
        $points_allowed = false;
        
        // Make sure a numeric id is supplied
        if (!is_numeric($hotspot_id)){
            $hotspot_id = 0;
        }
        
        // Update the user progress
        if ($user_id == 0){
            // maybe do session stuff?
        } else {
            
            // Check if the user is aloud to get points
            $points_allowed = check_points($user_id, $hotspot_id);
            
            // If yes, give them points
            if ($points_allowed){
                $points = add_user_progress($user_id, $hotspot_id);
            }
        }
        
	// Return the points associated to flash on the screen
        echo $points;
        
	die(); // this is required to terminate immediately and return a proper response
}

// check to make sure the user is aloud to get the points
function check_points($user_id, $hotspot_id){
    
    // Check if there is a limit on the attempts on a pano
    $hotspot = new hotspot($hotspot_id);
    
    // Make sure the hotspot exists
    if ($hotspot->exists){
        
        // Check if there are multiple attempts
        if ($hotspot->get_attempts() == 0){
            return true;
        } else {
            
            // Get user progress on the hotspot
            $progress = check_hotspot_prgress($hotspot_id, $user_id);
            
            // check the number of attempts
            $attempts = count($progress);
            
            // return if they are aloud
            if ($attempts >= $hotspot->get_attempts()){
                return false;
            } else {
                return true;
            }
        }
        
    }
}

// Calculates the accumulated number of points
function calculate_total_user_points(){
    global $wpdb; // this is how you get access to the database
    //
    // Get the user id
    $user_id = get_current_user_id();
    
    if ($user_id == 0){
        return 0;
    } else {
        $points = get_user_accumulated_points($user_id);
        
        if($points[0]->point || $points[0]->point > 0){
            return $points[0]->point;
        } else {
            return 0;
        }
    }
}

// ***********************************************************
//				    Processing New Panos
// ***********************************************************

function process_new_pano(){

	// Create a new pano using the post data

	// Get the id

	print_r($_POST);
	print_r($_FILES);
	die();

	// // Process the zip
	// if($_FILES["zip_file"]["pano_zip"]) {
	// 	upload_panos($_FILES["zip_file"]["pano_zip"]);
	// }
}

function process_new_quest(){

}

function process_new_mission(){

}

function process_new_hotspot(){

}
// ***********************************************************
//			   Pano Ad Messages
// ***********************************************************

function get_pano_ad_message($quest){

    $ad_messages = array();
    
    // Get the quest id
    if ($quest->exists){
        
        $messages = get_pano_ads($quest->get_id());
        
        foreach ($messages as $message) {
            array_push($ad_messages, $message->message);
        }
        
        return $ad_messages;
    }
    
    return false;
}

// ***********************************************************
//			   Uploading Panos
// ***********************************************************

// Handle uploading panos
function upload_panos($file, $pano_id){
	$upload_dir = wp_upload_dir();

	// Make a pano file at the directory if it doesn't exist
	$pano_directory = $upload_dir['baseurl'] . "/panos/";

	// If the upload directory doesn't exist, make it
	if (!check_file($pano_directory)){
		mkdir($pano_directory, 0654, true);
	}

	// Process the upload data
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
	
	$name = explode(".", $filename);

	$accepted_types = array('application/zip', 
		                    'application/x-zip-compressed', 
		                    'multipart/x-zip', 
		                    'application/x-compressed');

	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$message = "The file you are trying to upload is not a .zip file. Please try again.";
	}

	$target_path = "/home/var/yoursite/httpdocs/".$filename;  // change this to the correct site path
	if(move_uploaded_file($source, $target_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($target_path);
		if ($x === true) {
			$zip->extractTo("/var/ww/tott/"); // change this to the correct site path
			$zip->close();
	
			unlink($target_path);
		}
		$message = "Your .zip file was uploaded and unpacked.";
	} else {	
		$message = "There was a problem with the upload. Please try again.";
	}
	
}

// Function for checking if the directory exists
function check_file($file){
	if (file_exists($file)){
		return true;
	} else {
		return false;
	}
}