<?php

// reusable functions for the pano manager

function get_panos(){
	global $wpdb;
	$table_name = get_pano_table_name();

	// DB query
	$panos = $wpdb->get_results( "SELECT * FROM " . $table_name );
	return $panos;
}

function get_pano($id){
	global $wpdb;
	$table_name = get_pano_table_name();

	// DB query
	$pano = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $table_name . " WHERE id = %d", $id));
	return $pano;
}

function get_quest($pano_id){
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

function build_pano(){
  $script = "blank pano";
  return $script;
}

// build the script to replace the short code
function pano_script_output($incomingfromhandler) {
  $pano_output = "";
  return $pano_output;
}
