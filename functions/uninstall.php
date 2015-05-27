<?php

// Uninstall functions to clean up the database if the pano manager plugin is removed

function panno_uninstall() {
  global $wpdb;

  // Get all the table names
  $pano_table_name            = get_pano_table_name();
  $pano_text_table_name       = get_pano_text_table_name();
  $quest_table_name           = get_quest_table_name();
  $quest_text_table_name      = get_quest_text_table_name();
  $mission_table_name         = get_mission_table_name();
  $mission_text_table_name    = get_mission_text_table_name();
  $hotspot_table_name         = get_hotspot_table_name();
  $progress_table_name        = get_user_progress_table_name();
  $skill_progress_table_name  = get_user_skill_progress_table_name();
  $skill_bonus_pts_table_name = get_user_skill_bonus_pts_table_name();
  $type_table_name            = get_type_table_name();
  $prereq_table_name          = get_prereq_table_name();
  $activation_code_table_name = get_activation_code_table_name();
  $ads_table_name             = get_ads_table_name();
  $ads_text_table_name        = get_ads_text_table_name();
  $domain_table_name          = get_domain_table_name();
  $tool_table_name            = get_tool_table_name();

  // Drop all the tables
  $wpdb->query( "DROP TABLE IF EXISTS $pano_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $pano_text_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $quest_text_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $quest_text_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $mission_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $mission_text_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $hotspot_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $progress_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $skill_progress_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $skill_bonus_pts_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $type_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $prereq_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $activation_code_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $ads_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $ads_text_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $domain_table_name" );
  $wpdb->query( "DROP TABLE IF EXISTS $tool_table_name" );

  // Update the db version to 0 so the next time the plugin is run it will reinstall
  update_option( "panno_db_version", PANO_DB_VERSION );
}

// Hook is commented out so we don't lose data for now
// register_uninstall_hook( __FILE__, 'panno_uninstall' );

// End of Uninstall