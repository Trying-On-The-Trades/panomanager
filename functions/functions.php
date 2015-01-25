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

	$pano  = build_pano($id);
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

function build_mission($mission_id = 1){

    $mission = new mission($mission_id);
    return $mission;
}

function build_hotspot($hotspot_id = 1){

    $hotspot = new hotspot($hotspot_id);
    return $hotspot;
}

function build_hotspot_type($hotspot_type_id = 1){

    $hotspot_type = new hotspotType($hotspot_type_id);
    return $hotspot_type;
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
        // Get the user id and hotspot id
        $user_id    = get_current_user_id();
        $points = 0;
        $points_allowed = false;
        
        // Make sure a numeric id is supplied
        if (is_numeric($_POST['hotspot'])){
            $hotspot_id = $_POST['hotspot'];
        } else {
            $hotspot_id = 0;
        }
        
        // Update the user progress
        if ($user_id == 0){
            // maybe do session stuff?
        } else {
            // Check if the user is allowed to get points
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
    $pano_xml         = stripslashes($_POST['pano_xml']);
    $pano_name        = $_POST['pano_name'];
    $pano_description = $_POST['pano_description'];

    print_r($_POST);
    print_r($_FILES);
    die();

	// Get the id
    $pano_id = create_pano($pano_xml, $pano_name, $pano_description);

    // // Process the zip
    if(isset($_FILES['pano_zip'])) {
        upload_panos($_FILES['pano_zip'], $pano_id);
    }

    wp_redirect( admin_url( 'admin.php?page=pano_menu' ) );
}

function process_new_quest(){

    // Create a new quest using the post data
    $quest_name        = $_POST['quest_name'];
    $quest_description = trim($_POST['quest_description']);
    $pano_id           = $_POST['pano_id'];

    // Get the id
    create_quest($quest_name, $quest_description, $pano_id);

    wp_redirect( admin_url( 'admin.php?page=pano_quest_settings' ) );
}

function process_new_mission(){

    // Create a new mission using the post data
    $mission_name        = $_POST['mission_name'];
    $mission_description = trim($_POST['mission_description']);
    $mission_xml         = trim(stripslashes($_POST['mission_xml']));
    $quest_id            = $_POST['quest_id'];
    $mission_points      = $_POST['mission_points'];

    // Get the id
    create_mission($mission_name, $mission_description, $mission_xml, $quest_id, $mission_points);

    wp_redirect( admin_url( 'admin.php?page=pano_mission_settings' ) );
}

function process_new_hotspot(){

    // Create a new hotspot using the post data
    $mission_id          = $_POST['mission_id'];
    $type_id             = $_POST['type_id'];
    $hotspot_name        = $_POST['hotspot_name'];
    $hotspot_menu_name   = $_POST['hotspot_menu_name'];
    $hotspot_description = trim($_POST['hotspot_description']);
    $hotspot_xml         = trim(stripslashes($_POST['hotspot_xml']));
    $hotspot_action_xml  = trim(stripslashes($_POST['hotspot_action_xml']));
    $hotspot_points      = $_POST['hotspot_points'];
    $hotspot_attempts    = $_POST['hotspot_attempts'];

    // Get the id
    create_hotspot($mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts);

    wp_redirect( admin_url( 'admin.php?page=pano_hotspot_settings' ) );
}

function process_new_hotspot_type(){

    // Create a new hotspot using the post data
    $hotspot_type_name        = $_POST['hotspot_type_name'];
    $hotspot_type_description = trim($_POST['hotspot_type_description']);
    $hotspot_type_xml         = trim(stripslashes($_POST['hotspot_type_xml']));
    $hotspot_type_action_xml  = $_POST['hotspot_type_js_function'];

    // Get the id
    create_hotspot_type($hotspot_type_name, $hotspot_type_description, $hotspot_type_xml, $hotspot_type_action_xml);

    wp_redirect( admin_url( 'admin.php?page=pano_hotspot_type_settings' ) );
}

// ***********************************************************
//				    Editing Existing Panos
// ***********************************************************
function process_edit_pano(){

    // Create a new pano using the post data
    $pano_id          = $_POST['pano_id'];
    $pano_xml         = trim(stripslashes($_POST['pano_xml']));
    $pano_name        = $_POST['pano_name'];
    $pano_description = trim($_POST['pano_description']);

    // Get the id
    $return = update_pano($pano_id, $pano_xml, $pano_name, $pano_description);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_pano_settings&id=' . $pano_id . '&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=edit_pano_settings&id=' . $pano_id . '&error') );
    }
}

function process_edit_quest(){

    // Create a new quest using the post data
    $quest_id          = $_POST['quest_id'];
    $quest_name        = $_POST['quest_name'];
    $quest_description = trim($_POST['quest_description']);
    $pano_id           = $_POST['pano_id'];

    // Get the id
    $return = update_quest($quest_id, $quest_name, $quest_description, $pano_id);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_quest_settings&id=' . $quest_id . '&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=edit_quest_settings&id=' . $quest_id . '&error') );
    }
}

function process_edit_mission(){

    // Create a new mission using the post data
    $mission_id          = $_POST['mission_id'];
    $mission_name        = $_POST['mission_name'];
    $mission_description = trim($_POST['mission_description']);
    $mission_xml         = trim(stripslashes($_POST['mission_xml']));
    $mission_points      = $_POST['mission_points'];
    $quest_id            = $_POST['quest_id'];

    // Get the id
    $return = update_mission($mission_id, $mission_name, $mission_description, $mission_xml, $mission_points, $quest_id);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_mission_settings&id=' . $mission_id . '&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=edit_mission_settings&id=' . $mission_id . '&error') );
    }
}

function process_edit_hotspot(){

    // Create a new hotspot using the post data
    $mission_id          = $_POST['mission_id'];
    $type_id             = $_POST['type_id'];
    $hotspot_id          = $_POST['hotspot_id'];
    $hotspot_name        = $_POST['hotspot_name'];
    $hotspot_menu_name   = $_POST['hotspot_menu_name'];
    $hotspot_description = trim($_POST['hotspot_description']);
    $hotspot_xml         = trim(stripslashes($_POST['hotspot_xml']));
    $hotspot_action_xml  = trim(stripslashes($_POST['hotspot_action_xml']));
    $hotspot_points      = $_POST['hotspot_points'];
    $hotspot_attempts    = $_POST['hotspot_attempts'];
    $hotspot_trade_id    = $_POST['hotspot_trade_id'];
    $hotspot_modal_url   = $_POST['hotspot_modal_url'];

    // Get the id
    $return = update_hotspot($hotspot_id, $mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_trade_id, $hotspot_modal_url);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_hotspot_settings&id=' . $hotspot_id . '&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=edit_hotspot_settings&id=' . $hotspot_id . '&error') );
    }
}

function process_edit_hotspot_type(){

    // Create a new hotspot using the post data
    $hotspot_type_id          = $_POST['hotspot_type_id'];
    $hotspot_type_name        = $_POST['hotspot_type_name'];
    $hotspot_type_description = trim($_POST['hotspot_type_description']);
    $hotspot_type_xml         = trim(stripslashes($_POST['hotspot_type_xml']));
    $hotspot_type_js_function = $_POST['hotspot_type_js_function'];

    // Get the id
    $return = update_hotspot_type($hotspot_type_id, $hotspot_type_name, $hotspot_type_description, $hotspot_type_xml, $hotspot_type_js_function);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_hotspot_type_settings&id=' . $hotspot_type_id . '&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=edit_hotspot_type_settings&id=' . $hotspot_type_id . '&error') );
    }
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
function upload_panos($file, $pano_id)
{
    // Make a pano file at the directory if it doesn't exist
    $pano_directory = ABSPATH . "wp-content/panos/";
	// If the upload directory doesn't exist, make it
	if (!check_file($pano_directory)){

        mkdir($pano_directory, 0755, true);
	}

	// Process the upload data
    $source   = $file["tmp_name"];
	$type     = $file["type"];

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

	$zip_target_path = $pano_directory. "pano" . $pano_id. ".zip";  // change this to the correct site path
    $target_path = $pano_directory . $pano_id;

    if (!check_file($target_path)){
        mkdir($target_path, 0755, true);
    }

	if(move_uploaded_file($source, $zip_target_path)) {

		$zip = new ZipArchive();
		$x = $zip->open($zip_target_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::CREATE);
		if ($x === true) {
			$zip->extractTo($target_path); // change this to the correct site path
			$zip->close();

            unlink($zip_target_path);
		}
	}

	
}

// Function for checking if the directory exists
function check_file($file){
	if (file_exists($file))
		return true;

    return false;
}