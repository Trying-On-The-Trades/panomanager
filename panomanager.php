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
$jquery_location = WP_PLUGIN_URL . "/panomanager/js/jquery.js";
wp_register_script('jquery', $jquery_location, true);
wp_enqueue_script('jquery');

// Create a shortcode for the handler
add_shortcode("pano", "pano_handler");

// Create the admin menu from menu.php
add_action('admin_menu', 'pano_create_menu');

// Add the process pano hook
add_action( 'admin_post_pano', 'process_pano' );
add_action( 'create_new_pano', 'process_new_pano' );

// Handle the XML AJAX return
add_action( 'wp_ajax_return_pano_xml_tott', 'return_pano_xml' );
add_action( 'wp_ajax_nopriv_return_pano_xml_tott', 'return_pano_xml' );

// Activation hook to install the DB
register_activation_hook( __FILE__, 'pano_install' );

// Version of the DB used
define( 'PANO_DB_VERSION', '1.1.1' );

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

// Require the objects
require_once("includes/pano.php");
require_once("includes/quest.php");
require_once("includes/mission.php");
require_once("includes/hotspot.php");

// Require the admin pages
require_once("admin/admin_page.php");
require_once("admin/new_pano.php");
require_once("admin/quests.php");

// Require in the registration functions
require_once("functions/register_functions.php");
require_once("functions/js/register_js.php");

// Register the scripts that we need to alter the registration page
$register_location = WP_PLUGIN_URL . "/panomanager.php?registration_js=1";
wp_register_script('pano_register_js', $register_location, false, false, true);
wp_enqueue_script('pano_register_js');
    

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