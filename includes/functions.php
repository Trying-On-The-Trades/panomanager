<?php

// reusable functions for the panno manager

function get_pannos(){
	global $wpdb;
	$table_name = get_panno_table_name();

	// DB query
	$pannos = $wpdb->get_results( "SELECT * FROM " . $table_name );
	return $pannos;
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
