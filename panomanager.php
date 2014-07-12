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

add_shortcode("pano", "pano_handler");
add_action('admin_menu', 'pano_create_menu');
add_action( 'admin_post_pano', 'process_pano' );
register_activation_hook( __FILE__, 'pano_install' );
define( 'pano_DB_VERSION', '0.0.1' );

// The function that actually handles replacing the short code
function pano_handler($incomingfrompost) {

  $script_text;

  $incomingfrompost=shortcode_atts(array(
    "headingstart" => $script_text
  ), $incomingfrompost);

  $pano_output = pano_script_output($incomingfrompost);
  return $pano_output;
}

// Create the admin menu
function pano_create_menu() {
  //create new top-level menu
  add_menu_page('pano Settings', 'pano', 'administrator', __FILE__, 'pano_settings_page',plugins_url('/images/icon.png', __FILE__));
}

// Require the important files
require("functions/database.php");
require("functions/functions.php");
require("functions/processing.php");
require("functions/install.php");
require("functions/uninstall.php");
require("functions/admin_page.php");

// Include the objects
require("includes/pano.php");
require("includes/quest.php");
