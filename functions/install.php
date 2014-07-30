<?php

// These are functions that get called when the plugin is installed for the first time. These are for setting up the database and handlers.

// Create the table to hold the API keys
function pano_install () {
   global $wpdb;

   $installed_ver = get_option( "pano_db_version" );
   $table_name = get_pano_table_name();

  if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name || $installed_ver != pano_DB_VERSION ) {

    // Create tables
    $pano_sql        = build_pano_sql();
    $pano_text_sql   = build_pano_text_sql();
    $quest_sql        = build_quest_sql();
    $quest_text_sql   = build_quest_text_sql();
    $mission_sql      = build_mission_sql();
    $mission_text_sql = build_mission_text_sql();
    $progress_sql     = build_user_progress_sql();
    $hotspot_sql      = build_hotspot_sql();
    $type_sql         = build_type_sql();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Run the sql for the database
    dbDelta( $pano_sql        );
    dbDelta( $pano_text_sql   );
    dbDelta( $quest_sql        );
    dbDelta( $quest_text_sql   );
    dbDelta( $mission_sql      );
    dbDelta( $mission_text_sql );
    dbDelta( $progress_sql     );
    dbDelta( $hotspot_sql      );
    dbDelta( $type_sql         );

    update_option( "pano_db_version", PANO_DB_VERSION );
    // create_first_row();
  }
}

// End of Install functions