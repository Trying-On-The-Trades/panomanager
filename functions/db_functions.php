<?php
// Function that get and set data in the database

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

function get_pano_ids(){
	global $wpdb;
	$pano_table_name = get_pano_table_name();
	$text_table_name = get_pano_text_table_name();
	$language_code = get_user_language();

	// DB query joining the pano table and the pano text table
	$panos = $wpdb->get_results( 
		"SELECT wpp.id FROM " . $pano_table_name . " wpp " .
		"INNER JOIN " . $text_table_name . " wppt ON " .
		"wppt.pano_id = wpp.id " .
		"WHERE wppt.language_code = " . $language_code, ARRAY_A);

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
	$quests = $wpdb->get_results( 
		"SELECT * FROM " . $quest_table_name . " wpq " .
		"INNER JOIN " . $quest_text_table_name . " wpqt ON " .
		"wpqt.quest_id = wpq.id " .
		"WHERE wpqt.language_code = " . $language_code);

	// Return
	return $quests;
}

function get_quest($quest_id){
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
		" AND wpq.id = %d", $quest_id)
	);

	// Returnß
	return $quest;
}

function get_quest_by_pano($pano_id){
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
//				    Updating Panos
// ***********************************************************

function update_pano(){

}

function update_quest(){

}

function update_hotspot(){

}

// ***********************************************************
//				    Creating New Panos
// ***********************************************************

function create_pano(){

}

function create_quest(){

}

function create_hotspot(){

}