<?php

// Get the table prefix and return the name
function get_panno_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno";
}

function get_mission_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno_mission";
}

function get_quest_table_name(){
  global $wpdb;
  return $wpdb->prefix . "panno_quest";
}

function get_user_progress_table_name(){
  global $wpdb;
  return $wpdb->prefix . "user_progress";
}

function get_hotspot_table_name(){
  global $wpdb;
  return $wpdb->prefix . "hotspot";
}

function get_type_table_name(){
  global $wpdb;
  return $wpdb->prefix . "type";
}

function build_pano_sql(){
    $table_name = get_panno_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL DEFAULT "",
      `description` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_quest_sql(){
    $table_name = get_quest_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `panno_id` bigint(20) NOT NULL,
      `trigger_id` bigint(20) DEFAULT NULL,
      `name` varchar(255) NOT NULL DEFAULT "",
      `description` text,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_mission_sql(){
    $table_name = get_mission_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `quest_id` bigint(20) NOT NULL,
      `name` varchar(255) NOT NULL DEFAULT "",
      `description` text,
      `points` int(10) NOT NULL,
      `mission_xml` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_user_progress_sql(){
    $table_name = get_user_progress_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` bigint(20) NOT NULL,
      `mission_id` int(11) NOT NULL,
      `time_started` timestamp NULL DEFAULT NULL,
      `time_completed` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_hotspot_sql(){
    $table_name = get_hotspot_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `mission_id` int(11) DEFAULT NULL,
      `type_id` int(11) DEFAULT NULL,
      `name` varchar(255) NOT NULL DEFAULT "",
      `description` text,
      `hotspot_xml` text,
  PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_type_sql(){
    $table_name = get_type_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL DEFAULT "",
      `description` text,
      `type_xml` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}