<?php
// Function that get and set data in the database

// ***********************************************************
//				      Registration FUNCTIONS
// ***********************************************************

function get_schools(){
    global $wpdb;
    $school_table_name = get_school_table_name();
    
    // Get the schools out of the database
    $schools = $wpdb->get_results( 
            "SELECT * FROM " . $school_table_name . " wps ");

    return $schools;
}

function get_tools(){
    global $wpdb;
    
    $tool_table_name = get_tool_table_name();
    $trade_table_name = get_trade_table_name();
    
    $tools = $wpdb->get_results( 
            "SELECT wpt.*, wptt.name FROM " . $tool_table_name . " wpt " .
            "INNER JOIN " . $trade_table_name . " wptt ON " .
            "wpt.`trade_id` = wptt.`id` ");

    return $tools;
}

function get_trades(){
    global $wpdb;
    
    $trade_table_name = get_trade_table_name();
    
     // Get the schools out of the database
    $trades = $wpdb->get_results( 
            "SELECT * FROM " . $trade_table_name . " wpt ");

    return $trades;
}

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

function get_pano_names($user_id){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $language_code = get_user_language();
        
}

function get_allowed_pano_ids($user_id){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $language_code = get_user_language();
    
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

function get_pano_prereq($pano_id){
	global $wpdb;

	$prereq_table_name = get_prereq_table_name();
	$pano_table_name   = get_pano_table_name();

	$prereq = $wpdb->get_results( 
		"SELECT wppr.* FROM " . $prereq_table_name . " wppr " .
		"INNER JOIN " . $pano_table_name . " wpp ON " .
		"wpp.`id` = wppr.`pano_id` " .
		"WHERE wppr.`pano_id` = " . $pano_id);

	return $prereq;
}

// Return a user's points for completing missions for a specific pano
function get_user_mission_points($mission_id, $user_id){
	global $wpdb;

	$progress_table = get_user_progress_table_name();
	$mission_table  = get_mission_table_name();

	$points = $wpdb->get_results( 
		"SELECT sum(wpm.`points`) FROM " . $progress_table . " wup " .
		"INNER JOIN " . $mission_table . " wpm ON " .
		"wup.`mission_id` = wpm.`id` " .
		"WHERE wup.`user_id` = " . $user_id .
		"AND wup.`mission_id` = " . $mission_id);

	return $points;
}

// Return a user's points for completing skills for a specific pano
function get_user_skill_points($skill_id, $user_id){
	global $wpdb;

	$progress_table = get_user_skill_progress_table_name();
	$mission_table  = get_mission_table_name();

	$points = $wpdb->get_results( 
		"SELECT sum(wpm.`points`) FROM " . $progress_table . " wup " .
		"INNER JOIN " . $mission_table . " wpm ON " .
		"wup.`skill_id` = wpm.`id` " .
		"WHERE wup.`user_id` = " . $user_id .
		"AND wup.`skill_id` = " . $skill_id);

	return $points;
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