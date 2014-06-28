<?php

/*
Plugin Name: Pano Manager
Plugin URI: http://dan-blair.ca
Description: Manage your KR Panos
Version: 0.1.1
Author: Trying On The Trades
Author URI: http://www.tott.com
*/

// Originally developed by Dann Blair
// boldinnovationgroup.net

// Shortcodes
add_shortcode("panno", "panno_handler");

// Add actions
add_action('admin_menu', 'panno_create_menu');

// Process the apps
add_action( 'admin_post_panno', 'process_panno' );

// Activiation Hook
register_activation_hook( __FILE__, 'panno_install' );

// Install functions
define( 'PANNOs_DB_VERSION', '1.0' );

// Create the table to hold the API keys
function panno_install () {
   global $wpdb;

   $installed_ver = get_option( "panno_db_version" );
   $table_name = get_table_name();

  if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name || $installed_ver != PANNO_DB_VERSION ) {

    // Create tables

    $sql = 'CREATE TABLE ' .$table_name. ' (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      mapply_api VARCHAR(255) DEFAULT "" NOT NULL,
      google_api VARCHAR(255) DEFAULT "" NOT NULL,
      mapply_link VARCHAR(255) DEFAULT "",
      display_refferal INT(1) DEFAULT "0" NOT NULL,
      UNIQUE KEY id (id)
    );';

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    update_option( "panno_db_version", PANNO_DB_VERSION );
    create_first_row();
  }
}

// Get the table prefix and return the name
function get_panno_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno";
}

function get_mission_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno_mission";
}

function get_step_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno_step";
}

// End of Install functions

// Uninstall
// function panno_uninstall() {
//   global $wpdb;
//   $table_name = get_table_name();
//   $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
// }
// register_uninstall_hook( __FILE__, 'panno_uninstall' );
// End of Uninstall

// The function that actually handles replacing the short code
function panno_handler($incomingfrompost) {

  $script_text;

  $incomingfrompost=shortcode_atts(array(
    "headingstart" => $script_text
  ), $incomingfrompost);

  $demolph_output = script_output($incomingfrompost);
  return $demolph_output;
}

function build_script_text(){

  $script = "blank pano";

  return $script;
}

// build the script to replace the short code
function script_output($incomingfromhandler) {
  $demolp_output = wp_specialchars_decode($incomingfromhandler["headingstart"]);
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["liststart"]);

  for ($demolp_count = 1; $demolp_count <= $incomingfromhandler["categorylist"]; $demolp_count++) {
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemstart"]);
    $demolp_output .= $demolp_count;
    $demolp_output .= " of ";
    $demolp_output .= wp_specialchars($incomingfromhandler["categorylist"]);
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemend"]);
  }

  $demolp_output .= wp_specialchars_decode($incomingfromhandler["listend"]);
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["headingend"]);

  return $demolp_output;
}

// Create the admin menu
function panno_create_menu() {
  //create new top-level menu
  add_menu_page('Panno Settings', 'Panno', 'administrator', __FILE__, 'panno_settings_page',plugins_url('/images/icon.png', __FILE__));
}

// Require the important files
require("includes/functions.php");
require("includes/admin_page.php");
