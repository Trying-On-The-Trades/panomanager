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
            "SELECT wpt.*, wptt.name trade_name FROM " . $tool_table_name . " wpt " .
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

// Get the ids and names of the panos the user is aloud to see
function list_allowed_panos($user_id){
    global $wpdb;
    
    $pano_table_name     = get_pano_table_name();
    $text_table_name     = get_pano_text_table_name();
    $user_progress_table = get_user_skill_progress_table_name();
    $hotspot_table_name  = get_hotspot_table_name();
    $prereq_table_name   = get_prereq_table_name();
    
    $language_code = get_user_language();
    
    $pano = $wpdb->get_results( 
            "SELECT DISTINCT 
                wp.id, 
                wpt.name 
            FROM " . $pano_table_name . " wp

            INNER JOIN " . $text_table_name .  " wpt 
            ON wp.`id` = wpt.`pano_id`

            WHERE wp.id NOT IN (
                    SELECT wpr.`pano_id` FROM " . $prereq_table_name . " wpr
                    )
            OR wp.id IN (
                    SELECT wpr.`pano_id` FROM " . $prereq_table_name . " wpr
                    WHERE (SELECT sum(wph.`points`) FROM " . $user_progress_table . " wpup
                               INNER JOIN " . $hotspot_table_name .  " wph ON wpup.`skill_id` = wph.`id`
                               WHERE wpup.`user_id` = " . $user_id . ") >= wpr.`prereq_pts`
                    )
            AND wpt.`language_code` = " . $language_code .
            " ORDER BY wp.id"
    );

    return $pano;
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

function get_mission_ids($quest_id){
	global $wpdb;
	$mission_table_name = get_mission_table_name();
	$mission_text_table_name = get_mission_text_table_name();
	$language_code = get_user_language();

	// DB query
	$quest = $wpdb->get_results( $wpdb->prepare( 
		"SELECT wpm.id FROM " . $mission_table_name . " wpm " .
		"INNER JOIN " . $mission_text_table_name . " wpmt ON " .
		"wpmt.mission_id = wpm.id " .
		"WHERE wpmt.language_code = " . $language_code .
		" AND wpm.quest_id = %d", $quest_id, ARRAY_A)
	);

	// Return
	return $quest;
}

function get_mission($mission_id){
    global $wpdb;
    $mission_table_name      = get_mission_table_name();
    $mission_text_table_name = get_mission_text_table_name();
    $language_code = get_user_language();

    // DB query
    $mission = $wpdb->get_row( $wpdb->prepare( 
            "SELECT * FROM " . $mission_table_name . " wpm " .
            "INNER JOIN " . $mission_text_table_name . " wpmt ON " .
            " wpm.`id` = wpmt.`mission_id` " .
            " WHERE wpmt.language_code = " . $language_code .
            " AND wpm.id = %d", $mission_id)
    );

    return $mission;
}

function get_hotspot_ids($mission_id){
	global $wpdb;
	$hotspot_table_name = get_hotspot_table_name();

	// DB query joining the pano table and the pano text table
	$hotspots = $wpdb->get_results( $wpdb->prepare( 
		"SELECT wph.id FROM " . $hotspot_table_name . " wph " .
		"WHERE wph.mission_id = " . $mission_id, ARRAY_A)
        );

	return $hotspots;
}

function get_hotspot($hotspot_id){
    global $wpdb;
    $hotspot_table_name      = get_hotspot_table_name();
    $hotspot_type_table_name = get_type_table_name();

    // DB query
    $mission = $wpdb->get_row( $wpdb->prepare( 
            "SELECT wph.*, wpht.name type_name, wpht.description type_description FROM " . 
            $hotspot_table_name . " wph " .
            "INNER JOIN " . $hotspot_type_table_name . " wpht ON " .
            " wph.`type_id` = wpht.`id` " .
            " WHERE wph.id = %d", $hotspot_id)
    );
    return $mission;
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

// Return a user's accumulated points
function get_user_accumulated_points($user_id){
	global $wpdb;

	$progress_table = get_user_skill_progress_table_name();
	$hotspot_table  = get_hotspot_table_name();

	$points = $wpdb->get_results( 
		"SELECT sum(wph.`points`) as point FROM " . $progress_table . " wpusp " .
		"INNER JOIN " . $hotspot_table . " wph ON " .
		"wpusp.`skill_id` = wph.`id` " .
		"WHERE wpusp.`user_id` = " . $user_id);

	return $points;
}

function check_hotspot_prgress($hotspot_id, $user_id){
    global $wpdb;
    
    $progress_table = get_user_skill_progress_table_name();
    
    $hs = $wpdb->get_results("SELECT * FROM " . $progress_table . " wpusp" .
                             " WHERE wpusp.`skill_id` = " . $hotspot_id .
                             " AND wpusp.`user_id` = " . $user_id);
    
    return $hs;
}

//

function add_user_progress($user_id, $hotspot_id){
    global $wpdb;
    
    // Assign variables for the query
    $uid = $user_id;
    $sid = $hotspot_id;
    
    // Get the table names for the query
    $progress_table = get_user_skill_progress_table_name();
    $hotspot_table  = get_hotspot_table_name();
    
    // Insert the progress
    $wpdb->insert( $progress_table, array( 'user_id' => $uid, 
                                           'skill_id' => $sid ), 
                                    array( '%s', '%d' ) );

    // Get the id of the last row
    $lastid = $wpdb->insert_id;
    
    // Get the points that were just added
    $pano = $wpdb->get_row( $wpdb->prepare( 
            "SELECT wph.`points` 
            FROM " . $progress_table . " wpup
            INNER JOIN " . $hotspot_table . " wph
            ON wpup.`skill_id` = wph.`id`
            WHERE wpup.`id` =", $lastid)
    );

    // Return those points
    return $pano->points;
}

function get_leaderboard(){
    global $wpdb;
    
    // Table names
    $hotspot_table = get_hotspot_table_name();
    $progress_table = get_user_skill_progress_table_name();
    
    // Buddypress table names
    $profile_data_table = "wp_bp_xprofile_data";
    $profile_field_table = "wp_bp_xprofile_fields";
    
    // WordPress tables names
    $user_table = "wp_users";
    
    $leaderboard = $wpdb->get_results(
            "SELECT wu.`display_name` `name`, " .
            "sum(wph.`points`) score, " .
            "wbxf.`name` school " .
            "FROM " . $user_table . " wu " .
            "INNER JOIN " . $profile_data_table . " wbxd ".
            "ON wbxd.`user_id` = wu.`ID` " .
            "INNER JOIN " . $profile_field_table . " wbxf " .
            "ON wbxf.`id` = wbxd.`value` " .
            "INNER JOIN " . $progress_table . " wpusp " .
            "ON wpusp.`user_id` = wu.`ID` " .
            "INNER JOIN " . $hotspot_table . " wph " .
            "ON wph.`id` = wpusp.`skill_id` ".
            "GROUP BY wu.ID " .
            "ORDER BY score DESC");
    
    return $leaderboard;
}

function get_school_leaderboard(){
    global $wpdb;
    
    // Table names
    $hotspot_table = get_hotspot_table_name();
    $progress_table = get_user_skill_progress_table_name();
    
    // Buddypress table names
    $profile_data_table = "wp_bp_xprofile_data";
    $profile_field_table = "wp_bp_xprofile_fields";
    
    // WordPress tables names
    $user_table = "wp_users";
    
    $leaderboard = $wpdb->get_results(
            "SELECT wbxf.`name` `name`, " .
            "sum(wph.`points`) score " .
            "FROM " . $user_table . " wu " .
            "INNER JOIN " . $profile_data_table . " wbxd ".
            "ON wbxd.`user_id` = wu.`ID` " .
            "INNER JOIN " . $profile_field_table . " wbxf " .
            "ON wbxf.`id` = wbxd.`value` " .
            "INNER JOIN " . $progress_table . " wpusp " .
            "ON wpusp.`user_id` = wu.`ID` " .
            "INNER JOIN " . $hotspot_table . " wph " .
            "ON wph.`id` = wpusp.`skill_id` ".
            "GROUP BY wbxf.`name` " .
            "ORDER BY score DESC");
    
    return $leaderboard;
}

// ***********************************************************
//				    Trade Ads
// ***********************************************************

function get_pano_ads($quest_id){
    global $wpdb;
    
    // Table names 
    $quest_table    = get_quest_table_name(); 
    $ads_table      = get_ads_table_name(); 
    $ads_text_table = get_ads_text_table_name();
    $language_code  = get_user_language();
    
    $ad_messages = $wpdb->get_results("SELECT wpat.`message` FROM " . $ads_text_table . " wpat " . 
                                      "INNER JOIN " . $ads_table . " wpa ON wpa.`id` = wpat.`ads_id`" .
                                      "INNER JOIN " . $quest_table . " wpq ON wpq.`trade_id` = wpa.`trade_id`" . 
                                      "WHERE wpat.`language_code` = " . $language_code .
                                      "AND wpq.id = " . $quest_id);
    
    return $ad_messages;
    
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