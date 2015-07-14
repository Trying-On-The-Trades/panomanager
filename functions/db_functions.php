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

    $domain_table_name = get_domain_table_name();

    $tools = $wpdb->get_results(
            "SELECT wpt.*, wptt.name domain_name FROM " . $tool_table_name . " wpt " .
            "INNER JOIN " . $domain_table_name . " wptt ON " .
            "wpt.`domain_id` = wptt.`id` ");

    return $tools;
}

function get_domains(){
    global $wpdb;

    $domain_table_name = get_domain_table_name();

     // Get the schools out of the database
    $domains = $wpdb->get_results(
            "SELECT * FROM " . $domain_table_name . " wpt ");

    return $domains;
}

// ***********************************************************
//				      REUSABLE FUNCTIONS
// ***********************************************************

function get_panos(){
    global $wpdb;
    $pano_table_name  = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $quest_table_name  = get_quest_table_name();
    $language_code    = get_user_language();

    // DB query joining the pano table and the pano text table
    $panos = $wpdb->get_results(
            "SELECT wpp.id as pano_id, wpp.pano_xml, wppt.* FROM " . $pano_table_name . " wpp " .
            "INNER JOIN " . $text_table_name . " wppt ON " . "wppt.pano_id = wpp.id " .
            "ORDER BY wpp.id ASC");

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
    $bonus_pts_table = get_user_skill_bonus_pts_table_name();
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
            WHERE wpt.`language_code` = " . $language_code .
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
            "SELECT wpp.id as pano_id, wpp.pano_xml, wppt.* FROM " . $pano_table_name . " wpp " .
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
    $pano_text_table_name = get_pano_text_table_name();
    $language_code = get_user_language();

    // DB query
    $quests = $wpdb->get_results(
            "SELECT wpq.id as quest_id, wpq.panno_id, wpq.domain_id, wpqt.*, wpt.name as pano_name FROM " . $quest_table_name . " wpq " .
            "INNER JOIN " . $quest_text_table_name . " wpqt ON wpqt.quest_id = wpq.id " .
            "INNER JOIN " . $pano_text_table_name . " wpt ON wpt.pano_id = wpq.panno_id " .
            "WHERE wpqt.language_code = " . $language_code . " ORDER BY id ASC");

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
            "SELECT wpq.id as quest_id, wpq.panno_id, wpq.domain_id, wpqt.* FROM " . $quest_table_name . " wpq " .
            "INNER JOIN " . $quest_text_table_name . " wpqt ON " .
            "wpqt.quest_id = wpq.id " .
            "WHERE wpqt.language_code = " . $language_code .
            " AND wpq.id = %d ", $quest_id)
    );

    // Returnß
    return $quest;
}

function get_quest_by_pano($pano_id){
	global $wpdb;

	$quest_table_name = get_quest_table_name();

	// DB query
	$quest = $wpdb->get_row( $wpdb->prepare(
		"SELECT wpq.id FROM " . $quest_table_name . " wpq " .
		" WHERE wpq.panno_id = %d", $pano_id)
	);

	// Returnß
	return $quest->id;
}

function get_missions(){
    global $wpdb;

    $pano_text_table_name    = get_pano_text_table_name();
    $mission_table_name      = get_mission_table_name();
    $mission_text_table_name = get_mission_text_table_name();
    $language_code           = get_user_language();

    // DB query
    $missions = $wpdb->get_results(
        "SELECT wpm.id as mission_id, wpm.quest_id, wpm.points, wpm.mission_xml, wpmt.*, wpt.name as pano_name FROM " . $mission_table_name . " wpm " .
        "INNER JOIN " . $mission_text_table_name . " wpmt ON wpmt.mission_id = wpm.id " .
        "INNER JOIN " . $pano_text_table_name . " wpt ON wpt.id = wpm.pano_id " .
        "WHERE wpmt.language_code = " . $language_code . " ORDER BY id ASC");

    // Return
    return $missions;
}

function get_hotspots(){
    global $wpdb;

    $hotspot_table_name      = get_hotspot_table_name();
    $hotspot_type_table_name = get_type_table_name();
    $mission_text_table_name = get_mission_text_table_name();

    // DB query
    $hotspots = $wpdb->get_results(
        "SELECT wph.*, wpmt.name as mission_name, wpht.name as type_name FROM " . $hotspot_table_name . " wph " .
        "INNER JOIN " . $hotspot_type_table_name . " wpht ON wpht.id = wph.type_id " .
        "INNER JOIN " . $mission_text_table_name . " wpmt ON wpmt.mission_id = wph.mission_id " .
        " ORDER BY id ASC");

    // Return
    return $hotspots;
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
            "SELECT wpm.id as mission_id, wpm.quest_id, wpm.pano_id, wpm.domain_id, wpm.points, wpm.mission_xml, wpmt.* FROM " . $mission_table_name . " wpm " .
            "INNER JOIN " . $mission_text_table_name . " wpmt ON " .
            " wpm.`id` = wpmt.`mission_id` " .
            " WHERE wpmt.language_code = " . $language_code .
            " AND wpm.id = %d",  $mission_id)
    );

    return $mission;
}

function get_hotspot_ids($mission_id){
	global $wpdb;
	$hotspot_table_name = get_hotspot_table_name();

	// DB query joining the pano table and the pano text table
	$hotspots = $wpdb->get_results( $wpdb->prepare(
		"SELECT wph.id FROM " . $hotspot_table_name . " wph " .
		"WHERE wph.mission_id = " . $mission_id . " ORDER BY id ASC", ARRAY_A)
        );

	return $hotspots;
}

function get_hotspot($hotspot_id){
    global $wpdb;
    $hotspot_table_name      = get_hotspot_table_name();
    $hotspot_type_table_name = get_type_table_name();

    // DB query
    $mission = $wpdb->get_row( $wpdb->prepare(
            "SELECT wph.*, wpht.name type_name, wpht.description type_description, wpht.js_function type_js_function FROM " .
            $hotspot_table_name . " wph " .
            "INNER JOIN " . $hotspot_type_table_name . " wpht ON " .
            " wph.`type_id` = wpht.`id` " .
            " WHERE wph.id = %d",  $hotspot_id)
    );
    return $mission;
}

function get_types(){
	global $wpdb;
	$type_table_name = get_type_table_name();

	// get all the types
	$hotspot = $wpdb->get_results(
		"SELECT * FROM " . $type_table_name . " wpht ");

	return $hotspot;
}

function get_hotspot_type($hotspot_type_id){
	global $wpdb;
	$type_table_name = get_type_table_name();

	// Get a specific type from the db

    $hotspot_type = $wpdb->get_row( $wpdb->prepare(
        "SELECT * FROM " . $type_table_name . " wpht " .
        "WHERE wpht.id = %d", $hotspot_type_id)
    );

	return $hotspot_type;
}

function get_domain($domain_id){
    global $wpdb;
    $domain_table_name = get_domain_table_name();

    // Get a specific type from the db

    $domain = $wpdb->get_row( $wpdb->prepare(
        "SELECT * FROM " . $domain_table_name . " wpt " .
        "WHERE wpt.id = %d", $domain_id)
    );

    return $domain;
}



function get_pano_prereq($pano_id){
	global $wpdb;

	$prereq_table_name = get_prereq_table_name();
	$domain_table_name  = get_domain_table_name();

	$prereq = $wpdb->get_results(
		"SELECT wppr.* FROM " . $prereq_table_name . " wppr " .
		"WHERE wppr.`pano_id` = " . $pano_id);

	return $prereq;
}

function get_db_prereq($prereq_id){
    global $wpdb;

    $prereq_table_name = get_prereq_table_name();
    $pano_text_table_name = get_pano_text_table_name();
    $pano_domain_table_name = get_domain_table_name();

    $prereq = $wpdb->get_row( $wpdb->prepare(
        "SELECT wppr.*, wppt.name as pano_name FROM " . $prereq_table_name ." wppr " .
        "INNER JOIN " . $pano_text_table_name . " wppt ON wppt.`pano_id` = wppr.`pano_id` " .
        "WHERE wppr.id = %d",  $prereq_id));

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

    $points = $wpdb->get_row( $wpdb->prepare(
        "SELECT sum(wph.`points`) as points FROM " . $progress_table . " wpusp " .
        "INNER JOIN " . $hotspot_table . " wph ON " .
        "wpusp.`skill_id` = wph.`id` " .
        "WHERE wpusp.`user_id` = %d",  $user_id));

    return $points;
}

function get_user_accumulated_points_for_prereq($user_id, $domain_id){
    global $wpdb;

    $progress_table = get_user_skill_progress_table_name();
    $hotspot_table  = get_hotspot_table_name();

    $points = $wpdb->get_row( $wpdb->prepare(
        "SELECT sum(wph.`points`) as points FROM " . $progress_table . " wpusp " .
        "INNER JOIN " . $hotspot_table . " wph ON " .
        "wpusp.`skill_id` = wph.`id` " .
        "WHERE wpusp.`user_id` = " . $user_id . " " .
        "AND wpusp.`domain_id` = %d",  $domain_id));

    return $points;
}

// Return a user's accumulated points
function get_user_accumulated_bonus_pts($user_id){
    global $wpdb;

    $bonus_pts_table = get_user_skill_bonus_pts_table_name();

    $bonus_points =  $wpdb->get_row( $wpdb->prepare(
        "SELECT sum(wpusbp.`bonus_points`) as bonus_points FROM " . $bonus_pts_table . " wpusbp " .
        "WHERE wpusbp.`user_id` = %d",  $user_id));

    return $bonus_points;
}

// Return a user's accumulated points
function get_user_accumulated_bonus_pts_for_prereq($user_id, $domain_id){
    global $wpdb;

    $bonus_pts_table = get_user_skill_bonus_pts_table_name();

    $bonus_points =  $wpdb->get_row( $wpdb->prepare(
        "SELECT sum(wpusbp.`bonus_points`) as bonus_points FROM " . $bonus_pts_table . " wpusbp " .
        "WHERE wpusbp.`user_id` = " . $user_id . " " .
        "AND wpusbp.`domain_id` = %d",  $domain_id));

    return $bonus_points;
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

function add_user_progress($user_id, $hotspot_id, $domain_id){
    global $wpdb;

    // Assign variables for the query
    $uid = $user_id;
    $sid = $hotspot_id;
    $tid = $domain_id;

    // Get the table names for the query
    $progress_table = get_user_skill_progress_table_name();
    $hotspot_table  = get_hotspot_table_name();

    // Insert the progress
    $wpdb->insert( $progress_table, array( 'user_id'  => $uid,
                                           'skill_id' => $sid,
                                           'domain_id' => $tid  ),
                                    array( '%s', '%d' ) );

    // Get the id of the last row
    $lastid = $wpdb->insert_id;

    // Get the points that were just added
    $pano = $wpdb->get_row( $wpdb->prepare("SELECT wph.`points`
                                            FROM " . $progress_table . " wpup
                                            INNER JOIN " . $hotspot_table . " wph
                                            ON wpup.`skill_id` = wph.`id`
                                            WHERE wpup.`id` = %d", $lastid));

    regular_points_to_wallet($uid, $pano->points, $sid);

    // Return those points
    return $pano->points;
}

function add_user_progress_with_bonus($user_id, $hotspot_id,  $domain_id, $bonus_points){
    global $wpdb;

    // Assign variables for the query
    $uid = $user_id;
    $sid = $hotspot_id;
    $tid = $domain_id;

    // Get the table names for the query
    $progress_table = get_user_skill_bonus_pts_table_name();

    // Insert the progress
    $wpdb->insert( $progress_table, array( 'user_id'      => $uid,
                                           'skill_id'     => $sid,
                                           'domain_id'     => $tid,
                                           'bonus_points' => $bonus_points ),
                                    array( '%s', '%d' ) );

    bonus_points_to_wallet($uid, $bonus_points);

    // Get the id of the last row
    $lastid = $wpdb->insert_id;

    // Get the points that were just added
    $pano = $wpdb->get_row( $wpdb->prepare("SELECT wpup.`bonus_points`
                                            FROM " . $progress_table . " wpup
                                            WHERE wpup.`id` = %d", $lastid));

    // Return those points
    return $pano->bonus_points;
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
            "SELECT wu.id, wu.`display_name` `name`, " .
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

function get_leaderboard_bonus_pts(){
    global $wpdb;

    // Table names
    $bonus_pts_table = get_user_skill_bonus_pts_table_name();

    // Buddypress table names
    $profile_data_table = "wp_bp_xprofile_data";
    $profile_field_table = "wp_bp_xprofile_fields";

    // WordPress tables names
    $user_table = "wp_users";

    $leaderboard = $wpdb->get_results(
        "SELECT wu.id, wu.`display_name` `name`, " .
        "sum(wpusp.`bonus_points`) score, " .
        "wbxf.`name` school " .
        "FROM " . $user_table . " wu " .
        "INNER JOIN " . $profile_data_table . " wbxd " .
        "ON wbxd.`user_id` = wu.`ID` " .
        "INNER JOIN " . $profile_field_table . " wbxf " .
        "ON wbxf.`id` = wbxd.`value` " .
        "INNER JOIN " . $bonus_pts_table . " wpusp " .
        "ON wpusp.`user_id` = wu.`ID` " .
        "GROUP BY wu.ID " .
        "ORDER BY score DESC");

    return $leaderboard;
}

function get_school_leaderboard(){
    global $wpdb;

    // Table names
    $hotspot_table   = get_hotspot_table_name();
    $progress_table  = get_user_skill_progress_table_name();

    // Buddypress table names
    $profile_data_table = "wp_bp_xprofile_data";
    $profile_field_table = "wp_bp_xprofile_fields";

    // WordPress tables names
    $user_table = "wp_users";

    $leaderboard = $wpdb->get_results(
            "SELECT wbxf.id, wbxf.`name` `name`, " .
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

function get_school_leaderboard_bonus_pts(){
    global $wpdb;

    // Table names
    $bonus_pts_table = get_user_skill_bonus_pts_table_name();

    // Buddypress table names
    $profile_data_table = "wp_bp_xprofile_data";
    $profile_field_table = "wp_bp_xprofile_fields";

    // WordPress tables names
    $user_table = "wp_users";

    $leaderboard = $wpdb->get_results(
        "SELECT wbxf.id, wbxf.`name` `name`, " .
        "sum(wpusbp.`bonus_points`) score " .
        "FROM " . $user_table . " wu " .
        "INNER JOIN " . $profile_data_table . " wbxd " .
        "ON wbxd.`user_id` = wu.`ID`" .
        "INNER JOIN " . $profile_field_table . " wbxf " .
        "ON wbxf.`id` = wbxd.`value` " .
        "INNER JOIN " . $bonus_pts_table . " wpusbp " .
        "ON wpusbp.`user_id` = wu.`ID` " .
        "GROUP BY wbxf.`name` " .
        "ORDER BY score DESC");

    return $leaderboard;
}

// ***********************************************************
//				    Domain Ads
// ***********************************************************

function get_pano_ads($quest_id){
    global $wpdb;

    // Table names
    $mission_table  = get_mission_table_name();
    $ads_table      = get_ads_table_name();
    $ads_text_table = get_ads_text_table_name();
    $language_code  = get_user_language();

    $ad_messages = $wpdb->get_results("SELECT wpat.`message` FROM " . $ads_text_table . " wpat " .
                                      "INNER JOIN " . $ads_table . " wpa ON wpa.`id` = wpat.`ads_id`" .
                                      "INNER JOIN " . $mission_table . " wpm ON wpm.`domain_id` = wpa.`domain_id`" .
                                      "WHERE wpat.`language_code` = " . $language_code .
                                      "AND wpm.quest_id = " . $quest_id);

    return $ad_messages;

}

// ***********************************************************
//				    Updating Panos
// ***********************************************************

function update_pano($pano_id, $pano_xml, $pano_title, $pano_description){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $language_code   = get_user_language();
    $language_code   = str_replace("'","",$language_code);

    if(isset($pano_id) && is_numeric($pano_id)){
        $wpdb->update( $pano_table_name,
            array('pano_xml' => $pano_xml),
            array('id'       => $pano_id));

        $wpdb->update( $text_table_name,
            array(
                'language_code' => $language_code,
                'title'         => $pano_title,
                'description'   => $pano_description
            ),
            array('pano_id' => $pano_id));

        return true;
    } else {
        return false;
    }
}

function update_prereq($id, $pano_id, $prereq_pts, $prereq_domain_id){
    global $wpdb;
    $prereq_table_name = get_prereq_table_name();

    if(isset($id) && is_numeric($id)){
        $wpdb->update( $prereq_table_name,
            array('prereq_pts'      => $prereq_pts,
                  'prereq_domain_id' => $prereq_domain_id),
            array('id'      => $id,
                  'pano_id' => $pano_id));
        return true;
    } else {
        return false;
    }
}

function update_quest($quest_id, $quest_name, $quest_description, $pano_id, $domain_id){
    global $wpdb;
    $quest_table_name = get_quest_table_name();
    $text_table_name  = get_quest_text_table_name();
    $language_code    = get_user_language();
    $language_code    = str_replace("'","",$language_code);

    if(isset($quest_id) && is_numeric($quest_id)){
        $wpdb->update( $quest_table_name,
            array('panno_id' => $pano_id,
                  'domain_id' => $domain_id),
            array('id'       => $quest_id));

        $wpdb->update( $text_table_name,
            array(
                'language_code' => $language_code,
                'name'          => $quest_name,
                'description'   => $quest_description
            ),
            array('quest_id' => $quest_id));

        return true;
    } else {
        return false;
    }

}

function update_mission($mission_id, $mission_name, $mission_description, $mission_xml, $mission_points, $quest_id, $pano_id, $domain_id){
    global $wpdb;
    $mission_table_name = get_mission_table_name();
    $text_table_name    = get_mission_text_table_name();
    $language_code      = get_user_language();
    $language_code      = str_replace("'","",$language_code);

    if(isset($mission_id) && is_numeric($mission_id)){
        $wpdb->update( $mission_table_name,
                array(
                    'quest_id'    => $quest_id,
                    'pano_id'     => $pano_id,
                    'domain_id'   => $domain_id,
                    'points'      => $mission_points,
                    'mission_xml' => $mission_xml),
                array('id'        => $mission_id));

        $wpdb->update( $text_table_name,
            array(
                'language_code' => $language_code,
                'name'          => $mission_name,
                'description'   => $mission_description
            ),
            array('mission_id' => $mission_id));

        return true;
    } else {
        return false;
    }


}

function update_hotspot($hotspot_id, $mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info,
    $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url){
    global $wpdb;
    $hotspot_table_name = get_hotspot_table_name();

    if(isset($hotspot_id) && is_numeric($hotspot_id)){
        $wpdb->update( $hotspot_table_name,
            array(
                'mission_id'  => $mission_id,
                'type_id'     => $type_id,
                'name'        => $hotspot_name,
                'menu_name'   => $hotspot_menu_name,
                'description' => $hotspot_description,
                'hotspot_info' => $hotspot_info,
                'hotspot_xml' => $hotspot_xml,
                'action_xml'  => $hotspot_action_xml,
                'points'      => $hotspot_points,
                'attempts'    => $hotspot_attempts,
                'domain_id'   => $hotspot_domain_id,
                'modal_url'   => $hotspot_modal_url),
            array('id'        => $hotspot_id));

        return true;
    } else {
        return false;
    }
}

function update_hotspot_type($hotspot_type_id, $hotspot_type_name, $hotspot_type_description, $hotspot_type_xml, $hotspot_type_js_function){
    global $wpdb;
    $hotspot_type_table = get_type_table_name();

    if(isset($hotspot_type_id) && is_numeric($hotspot_type_id)){
        $wpdb->update( $hotspot_type_table,
            array(
                'name'        => $hotspot_type_name,
                'description' => $hotspot_type_description,
                'type_xml'    => $hotspot_type_xml,
                'js_function' => $hotspot_type_js_function),
            array('id'        => $hotspot_type_id));

        return true;
    } else {
        return false;
    }
}

function update_domain($domain_id, $domain_name){
    global $wpdb;
    $domain_table_name = get_domain_table_name();

    if(isset($domain_id) && is_numeric($domain_id)){
        $wpdb->update( $domain_table_name,
                       array('name' => $domain_name),
                       array('id' => $domain_id));

        return true;
    } else {
        return false;
    }
}

function update_points_info($symbol, $singular, $plural, $multiplier = 1){
  global $wpdb;
  $points_info_table_name = get_points_info_table_name();

  if(isset($singular) && isset($plural)){
    $wpdb->update($points_info_table_name,
      array(
        'symbol'     => $symbol,
        'singular'   => $singular,
        'plural'     => $plural,
        'multiplier' => $multiplier),
      array('id'     => 1));
    return true;
  } else {
    return false;
  }
}

function update_points_initial_bonus($quantity){
  global $wpdb;
  $points_initial_bonus_table_name = get_points_initial_bonus_table_name();

  if(isset($quantity)){
    $wpdb->update($points_initial_bonus_table_name,
      array('quantity' => $quantity),
      array('id'        => 1));
    return true;
  } else{
    return false;
  }
}

// ***********************************************************
//				    Creating New Panos
// ***********************************************************

function create_pano($pano_xml, $pano_title, $pano_description){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $language_code   = get_user_language();
    $language_code   = str_replace("'","",$language_code);

    // Insert the pano
    $wpdb->insert( $pano_table_name, array( 'pano_xml'  => $pano_xml));

    // Get the id of the last row
    $pano_id = $wpdb->insert_id;

    // Insert the pano_text
    $wpdb->insert( $text_table_name, array( 'pano_id'       => $pano_id,
                                            'language_code' => $language_code,
                                            'title'         => $pano_title,
                                            'description'   => $pano_description));

    return $pano_id;
}

function create_prereq($pano_id, $prereq_pts, $prereq_domain_id){
    global $wpdb;
    $prereq_table_name = get_prereq_table_name();

    // Insert the pano
    $wpdb->insert( $prereq_table_name, array( 'pano_id'         => $pano_id,
                                              'prereq_pts'      => $prereq_pts,
                                              'prereq_domain_id' => $prereq_domain_id));

    // Get the id of the last row
    $prereq_id = $wpdb->insert_id;

    return $prereq_id;
}

function create_quest($pano_id){
    global $wpdb;
    $quest_table_name      = get_quest_table_name();

    // Insert the pano
    $wpdb->insert( $quest_table_name, array( 'panno_id'  => $pano_id));

    // Get the id of the last row
    $lastid = $wpdb->insert_id;

    return $lastid;
}

function create_mission($mission_name, $mission_description, $mission_xml, $pano_id, $domain_id, $quest_id, $mission_points){
    global $wpdb;
    $mission_table_name      = get_mission_table_name();
    $mission_text_table_name = get_mission_text_table_name();
    $language_code           = get_user_language();
    $language_code           = str_replace("'","",$language_code);

    // Insert the pano
    $wpdb->insert( $mission_table_name, array( 'quest_id'    => $quest_id,
                                               'points'      => $mission_points,
                                               'mission_xml' => $mission_xml,
                                               'pano_id'     => $pano_id,
                                               'domain_id'    => $domain_id));

    // Get the id of the last row
    $lastid = $wpdb->insert_id;

    // Insert the pano_text
    $wpdb->insert( $mission_text_table_name, array( 'mission_id'    => $lastid,
                                                    'language_code' => $language_code,
                                                    'name'          => $mission_name,
                                                    'description'   => $mission_description));
    return $wpdb->insert_id;
}

function create_hotspot($mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url){
    global $wpdb;
    $hotspot_table_name = get_hotspot_table_name();

    // Insert the pano
    $wpdb->insert( $hotspot_table_name, array( 'mission_id'  => $mission_id,
                                               'type_id'     => $type_id,
                                               'name'        => $hotspot_name,
                                               'menu_name'   => $hotspot_menu_name,
                                               'description' => $hotspot_description,
                                               'hotspot_info' => $hotspot_info,
                                               'hotspot_xml' => $hotspot_xml,
                                               'action_xml'  => $hotspot_action_xml,
                                               'points'      => $hotspot_points,
                                               'attempts'    => $hotspot_attempts,
                                               'domain_id'    => $hotspot_domain_id,
                                               'modal_url'   => $hotspot_modal_url,));

    return $wpdb->insert_id;
}

function create_hotspot_ajax($mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url, $menu_item){
    global $wpdb;
    $hotspot_table_name = get_hotspot_table_name();

    // Insert the pano
    $wpdb->insert( $hotspot_table_name, array( 'mission_id'  => $mission_id,
        'type_id'     => $type_id,
        'menu_item'   =>  $menu_item,
        'name'        => $hotspot_name,
        'menu_name'   => $hotspot_menu_name,
        'description' => $hotspot_description,
        'hotspot_info' => $hotspot_info,
        'hotspot_xml' => $hotspot_xml,
        'action_xml'  => $hotspot_action_xml,
        'points'      => $hotspot_points,
        'attempts'    => $hotspot_attempts,
        'domain_id'    => $hotspot_domain_id,
        'modal_url'   => $hotspot_modal_url,));

    return $wpdb->insert_id;
}

function create_hotspot_type($hotspot_type_name, $hotspot_type_description, $hotspot_type_xml, $hotspot_type_action_xml){
    global $wpdb;
    $hotspot_type_table_name = get_type_table_name();

    // Insert the pano
    $wpdb->insert( $hotspot_type_table_name, array( 'name'        => $hotspot_type_name,
                                                    'description' => $hotspot_type_description,
                                                    'type_xml'    => $hotspot_type_xml,
                                                    'js_function' => $hotspot_type_action_xml));

    return $wpdb->insert_id;
}

function create_domain($domain_name){
    global $wpdb;
    $domain_table_name = get_domain_table_name();

    // Insert the pano
    $wpdb->insert( $domain_table_name, array( 'name' => $domain_name));

    return $wpdb->insert_id;
}

// ***********************************************************
//				    Deleting Panos
// ***********************************************************

function delete_pano($pano_id){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();

    $wpdb->delete( $pano_table_name, array( 'id' => $pano_id ) );
    $wpdb->delete( $text_table_name, array( 'pano_id' => $pano_id ) );
}

function delete_prereq($prereq_id){
    global $wpdb;
    $prereq_table_name = get_prereq_table_name();

    $wpdb->delete( $prereq_table_name, array( 'id' => $prereq_id ) );
}

function delete_quest($pano_id){
    global $wpdb;
    $quest_table_name = get_quest_table_name();

    $wpdb->delete( $quest_table_name, array( 'panno_id' => $pano_id ) );
}

function delete_mission($mission_id){
    global $wpdb;
    $mission_table_name      = get_mission_table_name();
    $mission_text_table_name = get_mission_text_table_name();

    $wpdb->delete( $mission_table_name, array( 'id' => $mission_id ) );
    $wpdb->delete( $mission_text_table_name, array( 'mission_id' => $mission_id ) );
}

function delete_hotspot($hotspot_id){
    global $wpdb;
    $hotspot_table_name = get_hotspot_table_name();

    $wpdb->delete( $hotspot_table_name, array( 'id' => $hotspot_id ) );
}

function delete_hotspot_type($hotspot_type_id){
    global $wpdb;
    $hotspot_type_table_name = get_type_table_name();

    $wpdb->delete( $hotspot_type_table_name, array( 'id' => $hotspot_type_id ) );
}

function delete_domain($domain_id){
    global $wpdb;
    $domain_table_name = get_domain_table_name();
    $wpdb->delete( $domain_table_name, array( 'id' => $domain_id ) );
}


function get_maximum_attempts($hotspot_id){
  global $wpdb;
  $hotspot_table_name  = get_hotspot_table_name();
  $maximum_attempts = $wpdb->get_results("SELECT attempts FROM $hotspot_table_name WHERE id = " . $hotspot_id);
  return $maximum_attempts[0]->attempts;
}

function get_number_of_attemts($hotspot_id){
  global $wpdb;
  $bonus_pts_table = get_user_skill_bonus_pts_table_name();
  $number_of_attempts = $wpdb->get_results("SELECT COUNT(skill_id) AS mynumber FROM $bonus_pts_table WHERE skill_id = " . $hotspot_id);
  return $number_of_attempts[0]->mynumber;
}

function get_regular_points_for_mission_tab($id){
  global $wpdb;

  $hotspot_table_name  = get_hotspot_table_name();
  $user_progress_table = get_user_skill_progress_table_name();

  $regular_points = $wpdb->get_results("SELECT SUM(points) AS regular_points FROM $hotspot_table_name WHERE id IN (SELECT DISTINCT skill_id FROM $user_progress_table WHERE user_id = $id)");
  $regular_points = $regular_points[0]->regular_points;

  if(empty($regular_points)){
    $regular_points = 0;
  }

  return $regular_points;
}

function get_bonus_points_for_mission_tab($id){
  global $wpdb;

  $bonus_pts_table = get_user_skill_bonus_pts_table_name();

  $bonus_points = $wpdb->get_results("SELECT SUM(bonus_points) AS bonus_points FROM $bonus_pts_table WHERE user_id = $id");
  $bonus_points = $bonus_points[0]->bonus_points;

  if(empty($bonus_points)){
    $bonus_points = 0;
  }

  return $bonus_points;
}

function get_user_name($id){
  global $wpdb;

  $username = $wpdb->get_results("SELECT display_name FROM wp_users WHERE id = $id LIMIT 1");
  $username = $username[0]->display_name;

  return $username;
}

function get_all_users(){
  global $wpdb;

  $users = $wpdb->get_results("SELECT id, display_name FROM wp_users");

  return $users;
}

function get_points_name_singular(){
  global $wpdb;

  $points_info_table_name = get_points_info_table_name();

  $points_name_singular = $wpdb->get_results("SELECT singular FROM $points_info_table_name WHERE id = 1 LIMIT 1");
  $points_name_singular = $points_name_singular[0]->singular;

  return $points_name_singular;
}

function get_points_name_plural(){
  global $wpdb;

  $points_info_table_name = get_points_info_table_name();

  $points_name_plural = $wpdb->get_results("SELECT plural FROM $points_info_table_name WHERE id = 1 LIMIT 1");
  $points_name_plural = $points_name_plural[0]->plural;

  return $points_name_plural;
}

function get_points_symbol(){
  global $wpdb;

  $points_info_table_name = get_points_info_table_name();

  $points_symbol = $wpdb->get_results("SELECT symbol FROM $points_info_table_name WHERE id = 1 LIMIT 1");
  $points_symbol = $points_symbol[0]->symbol;

  return $points_symbol;
}

function get_points_multiplier(){
  global $wpdb;

  $points_info_table_name = get_points_info_table_name();

  $points_multiplier = $wpdb->get_results("SELECT multiplier FROM $points_info_table_name WHERE id = 1 LIMIT 1");
  $points_multiplier = $points_multiplier[0]->multiplier;

  return $points_multiplier;
}

function get_points_initial_bonus(){
  global $wpdb;
  $initial_points_table_name = get_points_initial_bonus_table_name();

  $quantity = $wpdb->get_var("SELECT quantity FROM {$initial_points_table_name} WHERE id = 1 LIMIT 1");

  return $quantity;
}

function add_points($user_id, $quantity){
    global $wpdb;

    $available = $wpdb->get_var("SELECT available_currency FROM {get_wallet_table_name()}
        WHERE user_id = {$user_id}");

    $wpdb->query("UPDATE {get_wallet_table_name()} SET(available_currency = {($available + $quantity)})
        WHERE user_id = {$user_id}");
}

function remove_points($user_id, $quantity){
    global $wpdb;

    $available = $wpdb->get_var("SELECT available_currency FROM {get_wallet_table_name()}
        WHERE user_id = {$user_id}");

    $wpdb->query("UPDATE {get_wallet_table_name()} SET(available_currency = {($available - $quantity)})
        WHERE user_id = {$user_id}");
}

//PURCHASES

function get_purchases(){
    global $wpdb;
    $purchases_table = get_purchases_table_name();
    $purchases = $wpdb->get_results("SELECT * FROM ". $purchases_table);

    return $purchases;
}

function get_purchase($id){
    global $wpdb;
    $purchases_table = get_purchases_table_name();
    $purchase = $wpdb->get_row("SELECT * FROM " . $purchases_table . " WHERE id = {$id}");

    return $purchase;
}

function get_purchase_items($id){
    global $wpdb;
    $purchases_table = get_purchases_table_name();
    $line_items_table = get_line_items_table_name();
    $items_table = get_items_table_name();

    $items = $wpdb->get_results("SELECT i.id, i.name, i.description, i.image, l.price, i.type_id " .
                                "FROM {$purchases_table} p " .
                                "INNER JOIN {$line_items_table} l ON p.id = l.purchase_id " .
                                "INNER JOIN {$items_table} i ON l.item_id = i.id " .
                                "WHERE p.id = {$id}");

    return $items;
}

function get_purchase_total($id){
    global $wpdb;
    $purchases_table = get_purchases_table_name();
    $line_items_table = get_line_items_table_name();

    $total = $wpdb->get_var("SELECT SUM(l.price) FROM {$purchases_table} p " .
                            "INNER JOIN {$line_items_table} l ON p.id = l.purchase_id " .
                            "WHERE p.id = {$id}");

    return $total;
}

function get_item_types(){
    global $wpdb;

    $item_types_table = get_item_types_table_name();
    $item_types = $wpdb->get_results("SELECT * FROM {$item_types_table}");


    return $item_types;
}

function get_item_type($id){
    global $wpdb;
    $item_types_table = get_item_types_table_name();
    $item_type = $wpdb->get_row("SELECT * FROM " . $item_types_table . " WHERE id = {$id}");

    return $item_type;
}

function get_items(){
    global $wpdb;
    $items_table = get_items_table_name();
    $items = $wpdb->get_results("SELECT * FROM " . $items_table );

    return $items;
}

function get_item($id){
    global $wpdb;
    $items_table = get_items_table_name();
    $item = $wpdb->get_row("SELECT * FROM " . $items_table . " WHERE id = {$id}");

    return $item;
}

function delete_purchase($id){
    global $wpdb;

    $purchase_table = get_purchases_table_name();

    $wpdb->delete( $purchase_table, array('id' => $id));
}

function delete_item_type($id){
    global $wpdb;

    $item_type_table = get_item_types_table_name();

    $wpdb->delete($item_type_table, array('id' => $id));
}

function delete_item($id){
    global $wpdb;

    $item_table = get_items_table_name();

    $wpdb->delete($item_table, array('id' => $id));
}

function delete_line_item($purchase_id, $item_id){
    global $wpdb;

    $line_item_table = get_line_items_table_name();

    $wpdb->delete($line_item_table, array('purchase_id' => $purchase_id, 'item_id' => $item_id));
}

function create_purchase($date, $user_id){
    global $wpdb;

    $purchase_table = get_purchases_table_name();

    $wpdb->insert($purchase_table, array('date'=>$date, 'user_id' => $user_id));
}

function create_item_type($name, $description){
    global $wpdb;

    $item_type_table = get_item_types_table_name();

    $wpdb->insert($item_type_table, array('name' => $name, 'description' => $description));
}

function create_item($name, $description, $image, $price, $type_id){
    global $wpdb;

    $item_table = get_items_table_name();

    $wpdb->insert($item_table, array('name' => $name, 'description' => $description,
        'image' => $image, 'price' => $price, 'type_id' => $type_id));
}

function create_line_item($purchase_id, $item_id){
    global $wpdb;

    $line_item_table = get_line_items_table_name();

    $wpdb->insert($line_item_table, array('purchase_id' => $purchase_id, 'item_id' => $item_id));
}

function update_purchase($id, $date, $user_id){
    global $wpdb;

    $purchase_table = get_purchases_table_name();

    $wpdb->update($purchase_table, array('date' => $date, 'user_id' => $user_id),
        array('id' => $user_id));
}

function update_item_type($id, $name, $description){
    global $wpdb;

    $item_type_table = get_item_types_table_name();

    $wpdb->update($item_type_table, array('name' => $name, 'description' => $description),
        array('id' => $id));
}

function update_item($id, $name, $description, $image = null, $price, $type_id){
    global $wpdb;

    $item_table = get_items_table_name();

    $params = array('name' => $name,
                    'description' => $description,
                    'price' => $price, 'type_id' => $type_id);

    if(!is_null($image)){
        $params['image'] = $image;
    }

    $wpdb->update($item_table, $params, array('id' => $id));
}
