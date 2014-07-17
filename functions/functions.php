<?php

// reusable functions for the pano manager

function get_panos(){
	global $wpdb;
	$pano_table_name = get_pano_table_name();
	$text_table_name = get_pano_text_table_name();
	$language_code = get_user_language();

	// DB query joining the pano table and the pano text table
	$panos = $wpdb->get_results( 
		"SELECT * FROM " . $pano_table_name . " wpp " .
		"INNER JOIN " . $text_table_name . " wppt ON " .
		"wppt.`pano_id` = wpp.`id` " .
		"WHERE wppt.`language_code` = " $language_code);

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
        "wppt.`pano_id` = wpp.`id` " .
        "WHERE wppt.`language_code` = " $language_code .
        "AND wpp.`id` = %d", $id)
	);

	return $pano;
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
		"wpqt.`quest_id` = wpq.`id` " .
		"WHERE wpqt.`language_code` = " $language_code .
		"AND wpq.`pano_id` = %d", $pano_id)
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
		"wpmt.`mission_id` = wpm.`id` " .
		"WHERE wpmt.`language_code` = " $language_code .
		"AND wpm.`quest_id` = %d", $quest_id)
	);

	// Returnß
	return $quest;
}

function get_hotspots($mission_id){
	global $wpdb;
	$table_name = get_hotspot_table_name();

	// DB query
	// Return
}

function get_types(){
	global $wpdb;
	$table_name = get_type_table_name();

	// DB query
	// Return
}	

function get_hotspot_type($hotspot_id){
	global $wpdb;
	$table_name = get_type_table_name();

	// DB query
	// Return
}

function build_pano(){
  $script = "blank pano";
  return $script;
}

// Get the user's prefered language
function get_user_language(){
	// placeholder
	return "EN";
}

// build the script to replace the short code
function pano_script_output($incomingfromhandler) {
  $pano_output = "";
  return $pano_output;
}
