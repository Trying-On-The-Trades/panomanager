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
	$javascript = build_pano_javascript($id);

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
			$zip->extractTo("/home/var/yoursite/httpdocs/"); // change this to the correct site path
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