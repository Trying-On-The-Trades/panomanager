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
require_once("functions/db_triggers.php");

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

// Add the process domain type hook
add_action( 'admin_post_create_new_domain', 'process_new_domain' );
add_action( 'admin_post_edit_domain', 'process_edit_domain' );
add_action( 'admin_post_delete_domain', 'process_delete_domain' );

add_action( 'admin_post_create_new_item_type', 'process_new_item_type' );
add_action( 'admin_post_edit_item_type', 'process_edit_item_type');
add_action( 'admin_post_delete_item_type', 'process_delete_item_type');

add_action( 'admin_post_create_new_item', 'process_new_item' );
add_action( 'admin_post_edit_item', 'process_edit_item');
add_action( 'admin_post_delete_item', 'process_delete_item' );

// Handle the XML AJAX return
add_action( 'wp_ajax_return_pano_xml_tott', 'return_pano_xml' );
add_action( 'wp_ajax_nopriv_return_pano_xml_tott', 'return_pano_xml' );

// callback functions
add_action( 'admin_post_get_leaderboard_div', 'get_leaderboard_div' );
add_action( 'admin_post_nopriv_get_leaderboard_div', 'get_leaderboard_div');
add_action( 'admin_post_check_user_progress', 'check_user_progress_ajax' );
add_action( 'admin_post_update_progress', 'update_pano_user_progress' );
add_action( 'admin_post_update_progress_with_bonus', 'update_pano_user_progress_with_bonus' );
add_action( 'admin_post_create_new_hotspot_ajax', 'process_new_hotspot_ajax' );
add_action( 'admin_post_allow_new_attempt', 'allow_new_attempt' );
add_action( 'admin_post_nopriv_allow_new_attempt', 'allow_new_attempt' );
add_action( 'admin_post_get_hotspot_info', 'get_hotspot_info' );
add_action( 'admin_post_nopriv_get_hotspot_info', 'get_hotspot_info' );
add_action( 'admin_post_get_points_name_plural', 'get_points_name_plural_post' );
add_action( 'admin_post_nopriv_get_points_name_plural', 'get_points_name_plural_post' );
add_action( 'admin_post_get_points_name_singular', 'get_points_name_singular_post' );
add_action( 'admin_post_nopriv_get_points_name_singular', 'get_points_name_singular_post' );
add_action( 'admin_post_update_points_info', 'set_points_info' );
add_action( 'admin_post_update_initial_points', 'update_initial_points');
add_action( 'admin_post_description_onload', 'check_description_onload_ajax' );

// Activation hook to install the DB
register_activation_hook( __FILE__, 'pano_install' );
register_uninstall_hook( __DIR__ . "/functions/uninstall.php", 'panno_uninstall' );

// Version of the DB used
define( 'PANO_DB_VERSION', '1.1.6' );

// Require the objects
require_once("includes/pano.php");
require_once("includes/quest.php");
require_once("includes/mission.php");
require_once("includes/hotspot.php");
require_once("includes/hotspotType.php");
require_once("includes/domain.php");
require_once("includes/wallet.php");
require_once("includes/purchase.php");
require_once("includes/item_type.php");
require_once("includes/item.php");
require_once("includes/line_item.php");

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
require_once("admin/domains.php");
require_once("admin/new_domain.php");
require_once("admin/edit_domain.php");
require_once("admin/edit_points_info.php");
require_once("admin/edit_initial_points.php");
require_once("admin/item_types.php");
require_once("admin/new_item_type.php");
require_once("admin/edit_item_type.php");
require_once("admin/items.php");
require_once("admin/new_item.php");
require_once("admin/edit_item.php");
require_once("admin/view_purchases.php");
require_once("admin/view_single_purchase.php");

require_once("admin/view_panos.php");

// Register the table sorter query
$jquery_sortable = WP_PLUGIN_URL . "/panomanager/js/sortable/jquery.tablesorter.js";
wp_register_script('jquery_sortable', $jquery_sortable, array('jquery'));
wp_enqueue_script('jquery_sortable');


// Used to return the XML to build the pano on the page
if (isset($_GET['return_the_pano'])){
    return_pano_xml($_GET['return_the_pano']);
}

// Handle ajaxing to the pano_loaded
function return_pano_xml($id) {

    build_pano_xml($id);
    die(); // this is required to return a proper result
}
