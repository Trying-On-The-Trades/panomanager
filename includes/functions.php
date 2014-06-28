<?php

// Create the row to store the keys
function create_first_row(){
  global $wpdb;
  $table_name = get_table_name();
  $wpdb->insert( $table_name, array('mapply_api' => '', 'google_api' => '', 'display_refferal' => '0'), array());
}

// Process the form data
function process_panno(){
  if ($_POST){

    // Check for post

    // redirect
    wp_redirect(admin_url( 'admin.php?page=panomanager/panomanager.php&settings-saved'));
    exit;
  }
}
