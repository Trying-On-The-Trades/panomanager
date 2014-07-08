<?php

// Create the row to store the keys
function create_first_row(){
  global $wpdb;
  $table_name = get_table_name();
  $wpdb->insert( $table_name, array('mapply_api' => '', 'google_api' => '', 'display_refferal' => '0'), array());
}

function get_pannos(){
	global $wpdb;
	$table_name = get_panno_table_name();

	// DB query
	// Return
}

function get_quest($panno_id){
	global $wpdb;
	$table_name = get_quest_table_name();

	// DB query
	// Return
}

function get_missions($quest_id){
	global $wpdb;
	$table_name = get_mission_table_name();

	// DB query
	// Return
}

function get_hotspots($mission_id){
	global $wpdb;
	$table_name = get_hotspot_table_name();

	// DB query
	// Return
}

function get_types(){
	global $wpdb;
	$table_name = get_type_table_name();

	// DB query
	// Return
}	

function get_hotspot_type($hotspot_id){
	global $wpdb;
	$table_name = get_type_table_name();

	// DB query
	// Return
}
