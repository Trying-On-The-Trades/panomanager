<?php

// ***********************************************************
//				      REUSABLE FUNCTIONS
// ***********************************************************

function get_panos(){
	global $wpdb;
	$pano_table_name = get_pano_table_name();
	$text_table_name = get_pano_text_table_name();
	$language_code = get_user_language();

	// DB query joining the pano table and the pano text table
	$panos = $wpdb->get_results( 
		"SELECT * FROM " . $pano_table_name . " wpp " .
		"INNER JOIN " . $text_table_name . " wppt ON " .
		"wppt.pano_id = wpp.id " .
		"WHERE wppt.language_code = " . $language_code);

	return $panos;
}

function get_pano($id){
	global $wpdb;
	$pano_table_name = get_pano_table_name();
	$text_table_name = get_pano_text_table_name();
	$language_code = get_user_language();

	// DB query
	$pano = $wpdb->get_row( $wpdb->prepare( 
		"SELECT * FROM " . $pano_table_name . " wpp " .
	    "INNER JOIN " . $text_table_name . " wppt ON " .
        "wppt.pano_id = wpp.id " .
        "WHERE wppt.language_code = " . $language_code .
        " AND wpp.id = %d", $id)
	);

	return $pano;
}

function get_quests(){
	global $wpdb;

	$quest_table_name = get_quest_table_name();
	$quest_text_table_name = get_quest_text_table_name();
	$language_code = get_user_language();

	// DB query
	$quests = $wpdb->get_row( $wpdb->prepare( 
		"SELECT * FROM " . $quest_table_name . " wpq " .
		"INNER JOIN " . $quest_text_table_name . " wpqt ON " .
		"wpqt.quest_id = wpq.id " .
		"WHERE wpqt.language_code = " . $language_code)
	);

	// Return
	return $quests;
}

function get_quest($pano_id){
	global $wpdb;

	$quest_table_name = get_quest_table_name();
	$quest_text_table_name = get_quest_text_table_name();
	$language_code = get_user_language();

	// DB query
	$quest = $wpdb->get_row( $wpdb->prepare( 
		"SELECT * FROM " . $quest_table_name . " wpq " .
		"INNER JOIN " . $quest_text_table_name . " wpqt ON " .
		"wpqt.quest_id = wpq.id " .
		"WHERE wpqt.language_code = " . $language_code .
		" AND wpq.pano_id = %d", $pano_id)
	);

	// Returnß
	return $quest;
}

function get_missions($quest_id){
	global $wpdb;
	$mission_table_name = get_mission_table_name();
	$mission_text_table_name = get_mission_text_table_name();
	$language_code = get_user_language();

	// DB query
	$quest = $wpdb->get_row( $wpdb->prepare( 
		"SELECT * FROM " . $mission_table_name . " wpm " .
		"INNER JOIN " . $mission_text_table_name . " wpmt ON " .
		"wpmt.mission_id = wpm.id " .
		"WHERE wpmt.language_code = " . $language_code .
		" AND wpm.quest_id = %d", $quest_id)
	);

	// Return
	return $quest;
}

function get_hotspots($mission_id){
	global $wpdb;
	$hotspot_table_name = get_hotspot_table_name();

	// DB query joining the pano table and the pano text table
	$hotspot = $wpdb->get_results( 
		"SELECT * FROM " . $hotspot_table_name . " wph " .
		"WHERE wph.mission_id = " . $mission_id);

	return $hotspots;
}

function get_types(){
	global $wpdb;
	$type_table_name = get_type_table_name();

	// get all the types
	$hotspot = $wpdb->get_results( 
		"SELECT * FROM " . $type_table_name . " wpht ");

	return $hotspots;
}	

function get_hotspot_type($hotspot_type_id){
	global $wpdb;
	$type_table_name = get_type_table_name();

	// Get a specific type from the db
	$hotspot = $wpdb->get_results( 
		"SELECT * FROM " . $type_table_name . " wpht " .
		"WHERE wpht.id = " . $hotspot_type_id);

	return $hotspots;
}

// ***********************************************************
//				    FUNCTIONS TO BUILD OUTPUT
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
	build_pano($pano_id);

	$javascript = build_pano_javascript($pano_id);

	return $javascript;
}

// Build the javascript needed to load the pano into the div
function build_pano_javascript($pano_id){
	$pano_js_location = content_url() . "/panos/" . $pano_id . "/pano.js";
	$pano_swf_location = content_url() . "/panos/" . $pano_id . "/pano.swf";

	// printf(content_url());

	wp_register_script('pano_js', $pano_js_location, true);
	wp_enqueue_script('pano_js');

	$script = '<script type="text/javascript">';
	$script .= 'embedpano({';

		// Script that loads the pano
		$script .= 'swf:"' . $pano_swf_location . '"';
		$script .= ',target:"panoDIV"';
		$script .= ',passQueryParameters:true';

	$script .= '});';
	$script .= '</script>';

	return $script;
}

function build_pano($pano_id = 1){

	// Make a new pano object from the supplied id
	$pano = new pano($pano_id);

  	$script = "blank pano";

  	return $script;
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

// ***********************************************************
//				    Creating Panos
// ***********************************************************

function process_new_pano(){

}


// ***********************************************************
//				    Uploading Panos
// ***********************************************************

// Handle uploading panos
function upload_panos(){
	$upload_dir = wp_upload_dir();

	// Make a pano file at the directory if it doesn't exist
	$pano_directory = $upload_dir['baseurl'] . "/panos/";

	// If the upload directory doesn't exist, make it
	if (!check_file($pano_directory)){
		mkdir($pano_directory, 0654, true);
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