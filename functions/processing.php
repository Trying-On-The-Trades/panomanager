<?php

// This file is where the form data is posted to from the panno setting page

// Process the form data
function process_panno(){
  if ($_POST){

    // Check for post

    // redirect
    wp_redirect(admin_url( 'admin.php?page=panomanager/panomanager.php&settings-saved'));
    exit;
  }
}