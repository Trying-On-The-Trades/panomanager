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

// Create a shortcode for the handler
add_shortcode("pano", "pano_handler");

// Create the admin menu from menu.php
add_action('admin_menu', 'pano_create_menu');

// Add the process pano hook
add_action( 'admin_post_pano', 'process_pano' );
add_action( 'create_new_pano', 'process_new_pano' );

// Activation hook to install the DB
register_activation_hook( __FILE__, 'pano_install' );

// Version of the DB used
define( 'PANO_DB_VERSION', '0.0.2' );

// Require the important functions
require_once("functions/database.php");
require_once("functions/functions.php");
require_once("functions/processing.php");
require_once("functions/install.php");
require_once("functions/uninstall.php");
require_once("functions/menu.php");

require_once("functions/js/js_functions.php");

// Require the objects
require_once("includes/pano.php");
require_once("includes/quest.php");
require_once("includes/pano_loader.php");

// Require the admin pages
require_once("admin/admin_page.php");
require_once("admin/quests.php");