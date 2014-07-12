<?php

// Get the table prefix and return the name
function get_pano_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano";
}

function get_pano_text_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_text";
}

function get_mission_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_mission";
}

function get_mission_text_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_mission_text";
}

function get_quest_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_quest";
}

function get_quest_text_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_quest_text";
}

function get_user_progress_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_user_progress";
}

function get_hotspot_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_hotspot";
}

function get_type_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_hotspot_type";
}

function build_pano_sql(){
    $table_name = get_pano_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `pano_xml` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_pano_text_sql(){
    $table_name = get_pano_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `pano_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT '',
      `name` varchar(255) NOT NULL DEFAULT '',
      `description` text,
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
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_quest_text_sql(){
    $table_name = get_quest_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `quest_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT '',
      `name` varchar(255) NOT NULL DEFAULT '',
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
      `points` int(10) NOT NULL,
      `mission_xml` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_mission_text_sql(){
    $table_name = get_mission_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `mission_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT '',
      `name` varchar(255) NOT NULL DEFAULT '',
      `description` text,
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
      `name` varchar(255) NOT NULL DEFAULT '',
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
      `name` varchar(255) NOT NULL DEFAULT '',
      `description` text,
      `type_xml` text NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}