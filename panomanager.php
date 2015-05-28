<?php

/*
Plugin Name: Pano Manager
Plugin URI: http://dan-blair.ca
Description: Manage your KR Panos
Version: 0.1.5
Author: Trying On The Trades
Author URI: http://www.tott.com
*/

// Originally developed by Dann Blair
// boldinnovationgroup.net

// Add jquery because we need that...
//$jquery_location = WP_PLUGIN_URL . "/panomanager/js/jquery.js";
wp_register_script('jquery', $jquery_location, true);
wp_enqueue_script('jquery');

// Require the important functions
require_once("functions/database.php");
require_once("functions/db_functions.php");
require_once("functions/functions.php");
require_once("functions/pano_functions.php");
require_once("functions/processing.php");
require_once("functions/install.php");
require_once("functions/uninstall.php");
require_once("functions/menu.php");
require_once("functions/js/js_functions.php");

// Create a shortcode for the handler
add_shortcode("pano", "pano_handler");

// Create the admin menu from menu.php
add_action( 'admin_menu', 'pano_create_menu');
add_action( 'admin_enqueue_scripts', 'plu_admin_enqueue');

// Add the process pano hook
add_action( 'admin_post_create_new_pano', 'process_new_pano' );
add_action( 'admin_post_upload_zip', 'process_upload_zip' );
add_action( 'admin_post_create_new_prereq', 'process_new_prereq' );
add_action( 'admin_post_edit_prereq', 'process_edit_prereq' );
add_action( 'admin_post_delete_prereq', 'process_delete_prereq' );
add_action( 'admin_post_edit_pano', 'process_edit_pano' );
add_action( 'admin_post_delete_pano', 'process_delete_pano' );

// Add the process quest hook
add_action( 'admin_post_create_new_quest', 'process_new_quest' );
add_action( 'admin_post_edit_quest', 'process_edit_quest' );
add_action( 'admin_post_delete_quest', 'process_delete_quest' );

// Add the process mission hook
add_action( 'admin_post_create_new_mission', 'process_new_mission' );
add_action( 'admin_post_edit_mission', 'process_edit_mission' );
add_action( 'admin_post_delete_mission', 'process_delete_mission' );

// Add the process hotspot hook
add_action( 'admin_post_create_new_hotspot', 'process_new_hotspot' );
add_action( 'admin_post_edit_hotspot', 'process_edit_hotspot' );
add_action( 'admin_post_delete_hotspot', 'process_delete_hotspot' );

// Add the process hotspot type hook
add_action( 'admin_post_create_new_hotspot_type', 'process_new_hotspot_type' );
add_action( 'admin_post_edit_hotspot_type', 'process_edit_hotspot_type' );
add_action( 'admin_post_delete_hotspot_type', 'process_delete_hotspot_type' );

// Add the process trade type hook
add_action( 'admin_post_create_new_trade', 'process_new_trade' );
add_action( 'admin_post_edit_trade', 'process_edit_trade' );
add_action( 'admin_post_delete_trade', 'process_delete_trade' );

// Handle the XML AJAX return
add_action( 'wp_ajax_return_pano_xml_tott', 'return_pano_xml' );
add_action( 'wp_ajax_nopriv_return_pano_xml_tott', 'return_pano_xml' );

// callback functions
add_action( 'admin_post_get_leaderboard_div', 'get_leaderboard_div' );
add_action( 'admin_post_check_user_progress', 'check_user_progress_ajax' );
add_action( 'admin_post_update_progress', 'update_pano_user_progress' );
add_action( 'admin_post_update_progress_with_bonus', 'update_pano_user_progress_with_bonus' );
add_action( 'admin_post_allow_new_attempt', 'allow_new_attempt' );

// Activation hook to install the DB
register_activation_hook( __FILE__, 'pano_install' );

// Version of the DB used
define( 'PANO_DB_VERSION', '1.1.6' );

// Require the objects
require_once("includes/pano.php");
require_once("includes/quest.php");
require_once("includes/mission.php");
require_once("includes/hotspot.php");
require_once("includes/hotspotType.php");
require_once("includes/trade.php");

// Require the admin pages
require_once("admin/admin_page.php");
require_once("admin/new_pano.php");
require_once("admin/edit_pano.php");
require_once("admin/upload_zip.php");
require_once("admin/prereqs.php");
require_once("admin/new_prereq.php");
require_once("admin/edit_prereq.php");
require_once("admin/quests.php");
require_once("admin/new_quest.php");
require_once("admin/edit_quest.php");
require_once("admin/missions.php");
require_once("admin/new_mission.php");
require_once("admin/edit_mission.php");
require_once("admin/hotspots.php");
require_once("admin/new_hotspot.php");
require_once("admin/edit_hotspot.php");
require_once("admin/hotspot_types.php");
require_once("admin/new_hotspot_type.php");
require_once("admin/edit_hotspot_type.php");
require_once("admin/trades.php");
require_once("admin/new_trade.php");
require_once("admin/edit_trade.php");

// Require in the registration functions
require_once("functions/register_functions.php");
require_once("functions/js/register_js.php");

// Register the scripts that we need to alter the registration page
$register_location = WP_PLUGIN_URL . "/panomanager.php?registration_js=1";
wp_register_script('pano_register_js', $register_location, false, false, true);
wp_enqueue_script('pano_register_js');

// Register the table sorter query
$jquery_sortable = WP_PLUGIN_URL . "/panomanager/js/sortable/jquery.tablesorter.js";
wp_register_script('jquery_sortable', $jquery_sortable, array('jquery'));
wp_enqueue_script('jquery_sortable');


// Used to return the XML to build the pano on the page
if (isset($_GET['return_the_pano'])){
    return_pano_xml($_GET['return_the_pano']);
} else if (isset($_GET['registration_js'])){
    return_registration_script();
}

// Handle ajaxing to the pano_loaded
function return_pano_xml($id) {

    build_pano_xml($id);
    die(); // this is required to return a proper result
}
