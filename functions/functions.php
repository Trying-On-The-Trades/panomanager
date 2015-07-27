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
function load_pano($pano_id){

    $id = $pano_id;

    // Check if the user is aloud to see it
    if(check_user_progress($pano_id)){
        // Make sure the pano exists before trying to load it
	    $id = check_pano_id($pano_id);
    } else {
        //TODO I'd suggest to break the code here, return a error page with redirection.
    }

	$pano  = build_pano($id);
    $quest = build_quest($id);

	$javascript = build_pano_javascript($id, $pano, $quest);

	return $javascript;
}

function check_user_progress($pano_id){
	// Check the user's progress before allowing
	// the user to see the pano
	$allowed      = true;
    $flag_not_set = true;

    $accumulated_points = 0;
    $bonus_points       = 0;
    $total_points       = 0;

    $user_id = get_current_user_id();

	// Check if the pano has a prereq
	$prereqs = get_pano_prereq($pano_id);

	// if it does make sure the user has completed
	// enough skills and missions
    if(count($prereqs) > 0){
        foreach($prereqs as $prereq){
            if (is_null($prereq->prereq_domain_id) || $prereq->prereq_domain_id == 0){
                // Get the accumulated points
                $accumulated_points = get_user_accumulated_points($user_id);

                // Get the bonus points
                $bonus_points = get_user_accumulated_bonus_pts($user_id);
            } else {
                // Get the accumulated points based on the prereq domain
                $accumulated_points = get_user_accumulated_points_for_prereq($user_id, $prereq->prereq_domain_id);

                // Get the bonus points
                $bonus_points = get_user_accumulated_bonus_pts_for_prereq($user_id, $prereq->prereq_domain_id);
            }

            // Ensures the values are not null
            $accumulated_points = $accumulated_points ? $accumulated_points : 0;
            $bonus_points       = $bonus_points ? $bonus_points : 0;

            // Add up the points
            $total_points = $accumulated_points->points + $bonus_points->bonus_points;

            // check if they are enough for the prereq
            if ($total_points < $prereq->prereq_pts){
                if($flag_not_set){
                    $allowed      = false;
                    $flag_not_set = false;
                }
            }
        }
    }

	// If they have, return the pano else return default id
	if ($allowed){
		return true;
	} else {
		return false;
	}
}

function check_user_progress_ajax(){

    $pano_id = $_GET['pano_id'];

    if(check_user_progress($pano_id)){
        echo "allowed";
    } else {
        echo "restricted";
    }
}

function get_prereq($prereq_id = 1){
    $prereq = get_db_prereq($prereq_id);

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

function build_domain($domain_id = 1){

    $domain = new domain($domain_id);
    return $domain;
}

function build_item_type($item_type_id = 1){
    $item_type = new item_type($item_type_id);
    return $item_type;
}

function build_item($item_id = 1){
    $item = new item($item_id);
    return $item;
}

function build_purchase($purchase_id){
    $purchase = new purchase($purchase_id);
    return $purchase;
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
	$existing_ids   = array();

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

function get_current_pano_id(){

    global $pano_id;

    return check_pano_id($pano_id);
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

function allow_new_attempt(){
  $hotspot_id = 0;
  if((isset($_POST['hotspot'])) && (is_numeric($_POST['hotspot']))){
    $hotspot_id = $_POST['hotspot'];
  }
  $attempt_allowed = false;
  $maximum_attempts = get_maximum_attempts($hotspot_id);
  $number_of_attempts = get_number_of_attemts($hotspot_id);
  if(($number_of_attempts < $maximum_attempts) || ($maximum_attempts == 0)){
    $attempt_allowed = true;
  }

  echo $attempt_allowed;

  die();
}

function update_pano_user_progress() {
        // Get the user id and hotspot id
        $user_id  = get_current_user_id();
        $points = 0;
        $points_allowed = false;

        // Make sure a numeric id is supplied
        if (is_numeric($_POST['hotspot'])){
            $hotspot_id = $_POST['hotspot'];
        } else {
            $hotspot_id = 0;
        }

        if (is_numeric($_POST['domain_id'])){
            $domain_id = $_POST['domain_id'];
        } else {
            $domain_id = 0;
        }

        // Update the user progress
        if ($user_id == 0){
            // maybe do session stuff?
        } else {
            // Check if the user is allowed to get points
            $points_allowed = check_points($user_id, $hotspot_id);

            // If yes, give them points
            if ($points_allowed){
                $points = add_user_progress($user_id, $hotspot_id, $domain_id);
            }
        }

	// Return the points associated to flash on the screen
        echo $points;

	die(); // this is required to terminate immediately and return a proper response
}

function update_pano_user_progress_with_bonus() {

    // Get the user id and hotspot id
    $user_id      = get_current_user_id();
    $hotspot_id   = 0;
    $bonus_points = $_POST['bonus_points'];
    $points       = 0;

    // Make sure a numeric id is supplied
    if (is_numeric($_POST['hotspot'])){
        $hotspot_id = $_POST['hotspot'];
    }

    if (is_numeric($_POST['domain_id'])){
        $domain_id = $_POST['domain_id'];
    } else {
        $domain_id = 0;
    }

    // Update the user progress
    if ($user_id == 0){
        // maybe do session stuff?
    } else {
        $points = add_user_progress_with_bonus($user_id, $hotspot_id, $domain_id, $bonus_points);
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
        $points       = get_user_accumulated_points($user_id);
        $bonus_points = get_user_accumulated_bonus_pts($user_id);
        $total_points = 0;

        if($points->points > 0 ){
            $total_points += $points->points;
        }

        if($bonus_points->bonus_points > 0 ){
            $total_points += $bonus_points->bonus_points;
        }

        return $total_points;
    }
}

// ***********************************************************
//				    Processing New Panos
// ***********************************************************

function process_new_pano(){

	// Create a new pano using the post data
    $pano_xml         = stripslashes($_POST['pano_xml']);
    $pano_title       = $_POST['pano_title'];
    $pano_description = $_POST['pano_description'];

	// Get the id
    $pano_id = create_pano($pano_xml, $pano_title, $pano_description);

    create_quest($pano_id);

    create_prereq($pano_id, 0, NULL , NULL);

    wp_redirect( admin_url( 'admin.php?page=upload_zip_setting&id=' . $pano_id ) );
}

function process_new_prereq(){

    // Create a new pano using the post data
    $pano_id         = $_POST['pano_id'];
    $prereq_pts      = $_POST['prereq_pts'];
    $prereq_domain_id = ($_POST['prereq_domain_id'] == "NA") ? null : $_POST['prereq_domain_id'];
    $prereq_desc     = $_POST['prereq_desc'];

    $prereq_items = $_POST['items'];

    // Get the id
    $id = create_prereq($pano_id, $prereq_pts, $prereq_domain_id, $prereq_desc);

    foreach($prereq_items as $item){
        create_prereq_item($id, $item);
    }

    wp_redirect( admin_url( 'admin.php?page=prereq_setting&pano_id=' . $pano_id ) );
}

function process_new_quest(){

    // Create a new quest using the post data
    $quest_name        = $_POST['quest_name'];
    $quest_description = trim($_POST['quest_description']);
    $pano_id           = $_POST['pano_id'];
    $domain_id          = ($_POST['domain_id'] == "NA") ? null : $_POST['domain_id'];

    // Get the id
    create_quest($quest_name, $quest_description, $pano_id, $domain_id);

    wp_redirect( admin_url( 'admin.php?page=pano_quest_settings' ) );
}

function process_new_mission(){

    // Create a new mission using the post data
    $mission_name        = $_POST['mission_name'];
    $mission_description = trim($_POST['mission_description']);
    $mission_xml         = trim(stripslashes($_POST['mission_xml']));
    $mission_points      = $_POST['mission_points'];
    $quest_id            = $_POST['quest_id'];
    $pano_id             = $_POST['pano_id'];
    $domain_id            = ($_POST['domain_id'] == "NA") ? null : $_POST['domain_id'];

    // Get the id
    create_mission($mission_name, $mission_description, $mission_xml, $pano_id, $domain_id, $quest_id, $mission_points);

    wp_redirect( admin_url( 'admin.php?page=pano_mission_settings' ) );
}

function process_new_hotspot(){

    // Create a new hotspot using the post data
    $mission_id          = $_POST['mission_id'];
    $type_id             = $_POST['type_id'];
    $hotspot_name        = $_POST['hotspot_name'];
    $hotspot_menu_name   = $_POST['hotspot_menu_name'];
    $hotspot_description = trim($_POST['hotspot_description']);
    $hotspot_info        = trim($_POST['hotspot_info']);
    $hotspot_xml         = trim(stripslashes($_POST['hotspot_xml']));
    $hotspot_action_xml  = trim(stripslashes($_POST['hotspot_action_xml']));
    $hotspot_points      = $_POST['hotspot_points'];
    $hotspot_attempts    = $_POST['hotspot_attempts'];
    $hotspot_domain_id    = ($_POST['hotspot_domain_id'] == "NA") ? null : $_POST['hotspot_domain_id'];
    $hotspot_modal_url   = $_POST['hotspot_modal_url'];

    // Get the id
    create_hotspot($mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url);

    wp_redirect( admin_url( 'admin.php?page=pano_hotspot_settings' ) );
}

function process_new_hotspot_ajax(){

    // Create a new hotspot using the post data
    $mission_id          = $_POST['mission_id'];
    $hotspot_x           = $_POST['hotspot_x'];
    $hotspot_y           = $_POST['hotspot_y'];
    $type_id             = '3';
    $hotspot_name        = $_POST['hotspot_name'];
    $hotspot_menu_name   = $_POST['hotspot_name'];
    $hotspot_description = trim($_POST['hotspot_description']);
    $hotspot_info        = trim($_POST['hotspot_description']);
    $hotspot_icon        = $_POST['hotspot_icon'];
    $hotspot_menu        = $_POST['hotspot_menu'];
    $game_type           = $_POST['game_type'];
    $oppia_id            = $_POST['oppia_id'];

    if($hotspot_icon == 'true'){
        $image = 'url="info.png"';
    }else{
        $image = 'url="Blank.png"';
    }

    if($hotspot_menu == 'true'){
        $menu_item = '1';
    }else{
        $menu_item = '0';
    }

    if($game_type == "website" || $game_type == "image" || $game_type == "video"){
        $url = $_POST['hotspot_url'];
    }

    $hotspot_xml = "";
    $hotspot_action_xml = "";
    $hotspot_points      = $_POST['hotspot_points'];
    $hotspot_attempts    = '0';
    $hotspot_domain_id    = ($_POST['domain_id'] == "NA") ? null : $_POST['domain_id'];
    $hotspot_modal_url   = '';

    $deck_id = $_POST['deck_id'];
    $item_id = $_POST['item_id'];


    // Get the id
    $hotspot_id = create_hotspot_ajax($mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url, $menu_item);

    $hotspot_xml         = '<hotspot name="' . $hotspot_name . "_" . $hotspot_id . '" ' . $image .
        ' ath="'. $hotspot_x .'" atv="' . $hotspot_y . '"' .
        ' width="150" height="128" scale="0.425" zoom="true"'	.
        ' onclick="function_' . $hotspot_id . '"/>';

    if($game_type == "website"){
        $hotspot_action_xml  = '<action name="function_' . $hotspot_id . '">' .
            'js(loadFrame(' . $hotspot_id . ', "' . $url . '"));' .
            '</action>';
    }elseif($game_type == "image"){
        $hotspot_action_xml  = '<action name="function_' . $hotspot_id . '">' .
            'js(loadImage(' . $hotspot_id . ', "' . $url . '"));' .
            '</action>';

    }elseif($game_type == "video"){
        $hotspot_action_xml  = '<action name="function_' . $hotspot_id . '">' .
        'js(loadVideo(' . $hotspot_id . ', "' . $url . '"));' .
        '</action>';

    }elseif(is_numeric($deck_id)){
        $hotspot_action_xml  = '<action name="function_' . $hotspot_id . '">' .
            'js(loadFrame(' . $hotspot_id . ', "../wp-content/plugins/vocabulary-plugin/' . $game_type . '/index.php?id=' . $deck_id . '"' .', "bns"));' .
            '</action>';
    }elseif(strlen(trim($oppia_id)) > 0) {
        $hotspot_action_xml = '<action name="function_' . $hotspot_id . '">' .
            'js(loadOppia(' . $hotspot_id . ', ' . $oppia_id . '));' .
            '</action>';
    }
    else{
        $hotspot_action_xml = '<action name="function_' . $hotspot_id . '">' .
            'js(loadShopItem(' . $hotspot_id . ', ' . $item_id . '));' .
            '</action>';
    }


    update_hotspot($hotspot_id, $mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info,
        $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url);

    echo $hotspot_id;

    die();
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

function process_new_domain(){

    // Create a new quest using the post data
    $domain_name = $_POST['domain_name'];

    // Get the id
    create_domain($domain_name);

    wp_redirect( admin_url( 'admin.php?page=pano_domain_settings' ) );
}

function process_new_item_type(){

    $name = $_POST['item_type_name'];

    $description = $_POST['item_type_description'];

    create_item_type($name, $description);

    wp_redirect( admin_url( 'admin.php?page=item_types_settings&settings-saved'));
}

function process_new_item(){
    $name = $_POST['item_name'];
    $description = $_POST['item_description'];
    $price = $_POST['item_price'];
    $type_id = $_POST['item_type_id'];


    if( !empty( $_FILES['item_image']['name'] ) ){
        $image_file = wp_upload_bits( $_FILES['item_image']['name'], null, @file_get_contents( $_FILES['item_image']['tmp_name'] ) );
        $image_file_name = $image_file['file'];
        $pos = strpos($image_file_name, 'upload');
        $image = substr_replace($image_file_name, '', 0, $pos);
    }

    create_item($name, $description, $image, $price, $type_id);

    wp_redirect( admin_url( 'admin.php?page=items_settings&settings-saved') );
}

// ***********************************************************
//				    Editing Existing Panos
// ***********************************************************
function process_edit_pano(){

    // Create a new pano using the post data
    $pano_id          = $_POST['pano_id'];
    $pano_xml         = trim(stripslashes($_POST['pano_xml']));
    $pano_title        = $_POST['pano_title'];
    $pano_description = trim($_POST['pano_description']);

    // Get the id
    $return = update_pano($pano_id, $pano_xml, $pano_title, $pano_description);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=pano_menu&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_menu&error') );
    }
}

function process_edit_prereq(){

    // Create a new pano using the post data
    $id              = $_POST['id'];
    $pano_id         = $_POST['pano_id'];
    $prereq_pts      = $_POST['prereq_pts'];
    $prereq_domain_id = ($_POST['prereq_domain_id'] == "NA") ? null : $_POST['prereq_domain_id'];
    $prereq_desc     = $_POST['prereq_desc'];
    $prereq_items    = $_POST['items'];

    // Get the id
    $return = update_prereq($id, $pano_id, $prereq_pts, $prereq_domain_id, $prereq_desc);

    delete_prereq_items($id);

    foreach($prereq_items as $item){
        create_prereq_item($id, $item);
    }

    if($return){
        wp_redirect( admin_url( 'admin.php?page=edit_pano_settings&id=' . $pano_id . '&prereq-settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_menu&error') );
    }
}

function process_edit_quest(){

    // Create a new quest using the post data
    $quest_id          = $_POST['quest_id'];
    $quest_name        = $_POST['quest_name'];
    $quest_description = trim($_POST['quest_description']);
    $pano_id           = $_POST['pano_id'];
    $domain_id          = ($_POST['domain_id'] == "NA") ? null : $_POST['domain_id'];

    // Get the id
    $return = update_quest($quest_id, $quest_name, $quest_description, $pano_id, $domain_id);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=pano_quest_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_quest_settings&error') );
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
    $pano_id             = $_POST['pano_id'];
    $domain_id            = ($_POST['domain_id'] == "NA") ? null : $_POST['domain_id'];

    // Get the id
    $return = update_mission($mission_id, $mission_name, $mission_description, $mission_xml, $mission_points, $quest_id, $pano_id, $domain_id);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=pano_mission_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_mission_settings&error') );
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
    $hotspot_info        = trim($_POST['hotspot_info']);
    $hotspot_xml         = trim(stripslashes($_POST['hotspot_xml']));
    $hotspot_action_xml  = trim(stripslashes($_POST['hotspot_action_xml']));
    $hotspot_points      = $_POST['hotspot_points'];
    $hotspot_attempts    = $_POST['hotspot_attempts'];
    $hotspot_domain_id    = ($_POST['hotspot_domain_id'] == "NA") ? null : $_POST['hotspot_domain_id'];
    $hotspot_modal_url   = $_POST['hotspot_modal_url'];

    // Get the id
    $return = update_hotspot($hotspot_id, $mission_id, $type_id, $hotspot_name, $hotspot_menu_name, $hotspot_description, $hotspot_info, $hotspot_xml, $hotspot_action_xml, $hotspot_points, $hotspot_attempts, $hotspot_domain_id, $hotspot_modal_url);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=pano_hotspot_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_hotspot_settings&error') );
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
        wp_redirect( admin_url( 'admin.php?page=pano_hotspot_type_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_hotspot_type_settings&error') );
    }
}

function process_edit_domain(){

    // Create a new hotspot using the post data
    $domain_id   = $_POST['domain_id'];
    $domain_name = $_POST['domain_name'];

    // Get the id
    $return = update_domain($domain_id, $domain_name);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=pano_domain_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=pano_domain_settings&error') );
    }
}

function process_edit_item_type(){

    $item_type_id = $_POST['item_type_id'];

    $item_type_name = $_POST['item_type_name'];

    $item_type_description = $_POST['item_type_description'];

    $return = update_item_type($item_type_id, $item_type_name, $item_type_description);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=items_types_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=item_types_settings&error') );
    }
}

function process_edit_item(){
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];

    if ( !empty( $_FILES['item_image']['name'] ) ) {
        $image_file = wp_upload_bits( $_FILES['item_image']['name'], null, @file_get_contents( $_FILES['item_image']['tmp_name'] ) );
        $image_file_name = $image_file['file'];
        $pos = strpos($image_file_name,'upload');
        $item_image = substr_replace($image_file_name,'',0,$pos);
    }

    $item_price = $_POST['item_price'];
    $item_type_id = $_POST['item_type_id'];


    $return = update_item($item_id, $item_name, $item_description, $item_image, $item_price, $item_type_id);

    if($return){
        wp_redirect( admin_url( 'admin.php?page=items_settings&settings-saved') );
    } else {
        wp_redirect( admin_url( 'admin.php?page=items_settings&error') );
    }

}

// ***********************************************************
//			   Deleting Panos
// ***********************************************************
function process_delete_pano(){

    // Delete a pano using the post data
    $pano_id = $_POST['pano_id'];

    delete_pano($pano_id);
    delete_quest($pano_id);

    wp_redirect( admin_url( 'admin.php?page=pano_menu') );
}

function process_delete_quest(){

    // Delete a quest using the post data
    $quest_id = $_POST['quest_id'];

    delete_quest($quest_id);

    wp_redirect( admin_url( 'admin.php?page=pano_quest_settings') );
}

function process_delete_prereq(){

    // Delete a quest using the post data
    $prereq_id = $_POST['prereq_id'];
    $pano_id   = $_POST['pano_id'];

    delete_prereq($prereq_id);

    wp_redirect( admin_url( 'admin.php?page=prereq_setting&pano_id=' . $pano_id) );
}

function process_delete_mission(){

    // Delete a mission using the post data
    $mission_id = $_POST['mission_id'];

    delete_mission($mission_id);

    wp_redirect( admin_url( 'admin.php?page=pano_mission_settings') );
}

function process_delete_hotspot(){

    // Delete a hotspot using the post data
    $hotspot_id = $_POST['hotspot_id'];

    delete_hotspot($hotspot_id);

    wp_redirect( admin_url( 'admin.php?page=pano_hotspot_settings') );
}

function process_delete_hotspot_type(){

    // Delete a hotspot type using the post data
    $hotspot_type_id = $_POST['hotspot_type_id'];

    delete_hotspot_type($hotspot_type_id);

    wp_redirect( admin_url( 'admin.php?page=pano_hotspot_type_settings') );
}

function process_delete_domain(){

    // Delete a domain using the post data
    $domain_id = $_POST['domain_id'];

    delete_domain($domain_id);

    wp_redirect( admin_url( 'admin.php?page=pano_domain_settings') );
}

function process_delete_item_type(){

    $item_type_id = $_POST['item_type_id'];

    delete_item_type($item_type_id);

    wp_redirect( admin_url( 'admin.php?page=item_types_settings') );
}

function process_delete_item(){
    $item_id = $_POST['item_id'];

    delete_item($item_id);

    wp_redirect( admin_url('admin.php?page=items_settings') );
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

function plu_admin_enqueue(){
    wp_enqueue_script('plupload-all');
}

function process_upload_zip(){

    $pano_id = $_GET['id'];

    // Make a pano file at the directory if it doesn't exist
    $pano_directory = ABSPATH . "wp-content/panos/";

    // If the upload directory doesn't exist, make it
    if (!check_file($pano_directory)){

        mkdir($pano_directory, 0755, true);
    }

    // Setting up the file path and target path
    $fileName    = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
    $filePath    = $pano_directory. "pano" . $pano_id. ".zip";;
    $target_path = $pano_directory . $pano_id;

    // Creates the target path if it doesnt exist
    if (!check_file($target_path)){
        mkdir($target_path, 0755, true);
    }

    // Displays an error if the file was not uploaded
    if (empty($_FILES) || $_FILES['file']['error']) {
        die('{"OK": 0, "info": "Failed to move uploaded file."}');
    }

    // Using Plupload Chunks
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

    // Open temp file
    $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
    if ($out) {
        // Read binary input stream and append it to temp file
        $in = @fopen($_FILES['file']['tmp_name'], "rb");

        if ($in) {
            while ($buff = fread($in, 4096))
                fwrite($out, $buff);
        } else
            die('{"OK": 0, "info": "Failed to open input stream."}');

        @fclose($in);
        @fclose($out);

        @unlink($_FILES['file']['tmp_name']);
    } else
        die('{"OK": 0, "info": "Failed to open output stream."}');


    // Check if file has been uploaded
    if (!$chunks || $chunk == $chunks - 1) {
        // Strip the temp .part suffix off
        rename("{$filePath}.part", $filePath);

        // Unzips the file and moves it to the target path
        $zip = new ZipArchive();
        $x = $zip->open($filePath, ZIPARCHIVE::CREATE | ZIPARCHIVE::CREATE);
        if ($x === true) {
            $zip->extractTo($target_path); // change this to the correct site path
            $zip->close();

            unlink($filePath);
        }
    }

    die('{"OK": 1, "info": "Upload successful."}');
}

// Function for checking if the directory exists
function check_file($file){
	if (file_exists($file))
		return true;

    return false;
}

function get_hotspot_info(){
    $hotspot_id = $_POST['hotspot_id'];

    $hotspot = get_hotspot($hotspot_id);

    echo $hotspot->hotspot_info;
  }

function get_points_name_plural_post(){
  $points_name_plural = '';

  $points_name_plural = get_points_name_plural();

  echo $points_name_plural;
  die();
}

function get_points_name_singular_post(){
  $points_name_singular = '';

  $points_name_singular = get_points_name_singular();

  echo $points_name_singular;
  die();
}

function set_points_info(){
  $symbol = '';
  $singular = '';
  $plural = '';

  if(isset($_POST['symbol'])){
    $symbol = $_POST['symbol'];
  }

  if(isset($_POST['singular'])){
    $singular = $_POST['singular'];
  }

  if(isset($_POST['plural'])){
    $plural = $_POST['plural'];
  }

  $status = update_points_info($symbol, $singular, $plural);

  if($status){
    wp_redirect( admin_url( 'admin.php?page=edit_points_info_settings&settings-saved=true' ) );
  } else {
    wp_redirect( admin_url( 'admin.php?page=edit_points_info_settings&error=true' ) );
  }

}

function update_initial_points(){

  if(isset($_POST['quantity'])){
    $quantity = $_POST['quantity'];
  }

  $status = update_points_initial_bonus($quantity);

  if($status){
    wp_redirect( admin_url( 'admin.php?page=edit_initial_points_settings&settings-saved=true' ) );
  } else {
    wp_redirect( admin_url( 'admin.php?page=eedit_initial_points_settings&error=true' ) );
  }

}
