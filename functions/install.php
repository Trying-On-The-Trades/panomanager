<?php

// These are functions that get called when the plugin is installed for the first time. These are for setting up the database and handlers.

// Create the table to hold the API keys
function pano_install () {
   global $wpdb;

   $installed_ver = get_option( "pano_db_version" );
   $table_name = get_pano_table_name();

  if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name || $installed_ver != pano_DB_VERSION ) {

    // Create tables
    $pano_sql            = build_pano_sql();
    $pano_text_sql       = build_pano_text_sql();
    $quest_sql           = build_quest_sql();
    $quest_text_sql      = build_quest_text_sql();
    $mission_sql         = build_mission_sql();
    $mission_text_sql    = build_mission_text_sql();
    $progress_sql        = build_user_progress_sql();
    $skill_progress_sql  = build_user_skill_progress_table_sql();
    $skill_bonus_pts_sql = build_user_skill_bonus_pts_table_sql();
    $hotspot_sql         = build_hotspot_sql();
    $type_sql            = build_type_sql();
    $prereq_sql          = build_prereq_sql();
    $activation_sql      = build_activation_code_sql();
    $tool_sql            = build_tools_sql();
    $school_sql          = build_school_sql();
    $domain_sql          = build_domains_sql();
    $ads_sql             = build_ads_sql();
    $ads_text_sql        = build_ads_text_sql();
    $points_info_sql     = build_points_info_sql();
    $wallet_sql          = build_wallet_sql();
    $purchases_sql       = build_purchases_sql();
    $item_types_sql      = build_item_types_sql();
    $items_sql           = build_items_sql();
    $line_items_sql      = build_line_items_sql();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Run the sql for the database
    dbDelta( $pano_sql           );
    dbDelta( $pano_text_sql      );
    dbDelta( $quest_sql          );
    dbDelta( $quest_text_sql     );
    dbDelta( $mission_sql        );
    dbDelta( $mission_text_sql   );
    dbDelta( $progress_sql       );
    dbDelta( $skill_progress_sql );
    dbDelta( $skill_bonus_pts_sql);
    dbDelta( $hotspot_sql        );
    dbDelta( $type_sql           );
    dbDelta( $prereq_sql         );
    dbDelta( $activation_sql     );
    dbDelta( $tool_sql           );
    dbDelta( $school_sql         );
    dbDelta( $domain_sql         );
    dbDelta( $ads_sql            );
    dbDelta( $ads_text_sql       );
    dbDelta( $points_info_sql    );
    dbDelta( $wallet_sql         );
    dbDelta( $purchases_sql      );
    dbDelta( $item_types_sql     );
    dbDelta( $items_sql          );
    dbDelta( $line_items_sql     );

    update_option( "pano_db_version", PANO_DB_VERSION );
    // create_first_row();
  }
}

// End of Install functions
