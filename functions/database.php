<?php
// Functions used to build the pano table name and sql

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

function get_user_skill_progress_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_user_skill_progress";
}

function get_user_skill_bonus_pts_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_user_skill_bonus_pts";
}

function get_hotspot_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_hotspot";
}

function get_type_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_hotspot_type";
}

function get_prereq_table_name(){
  global $wpdb;
  return $wpdb->prefix . "pano_prereq";
}

function get_activation_code_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_activation_codes";
}

function get_school_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_schools";
}

function get_ads_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_ads";
}

function get_ads_text_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_ads_text";
}

function get_domain_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_domains";
}

function get_tool_table_name(){
    global $wpdb;
    return $wpdb->prefix . "pano_tools";
}

function get_points_info_table_name(){
  global $wpdb;
  return $wpdb->prefix . "points_info";
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
      `language_code` varchar(2) NOT NULL DEFAULT "",
      `name` varchar(255) NOT NULL DEFAULT "",
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
      `domain_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_quest_text_sql(){
    $table_name = get_quest_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `quest_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT "",
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
      `points` int(10) NOT NULL,
      `mission_xml` text NOT NULL,
      `pano_id` bigint(20) NOT NULL,
      `domain_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_mission_text_sql(){
    $table_name = get_mission_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `mission_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT "",
      `name` varchar(255) NOT NULL DEFAULT "",
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

function build_user_skill_progress_table_sql(){
    $table_name = get_user_skill_progress_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
       `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` bigint(20) NOT NULL,
        `skill_id` int(11) NOT NULL,
        `time_started` timestamp NULL DEFAULT NULL,
        `time_completed` timestamp NULL DEFAULT NULL,
        `domain_id` int(11) DEFAULT NULL,
        `points` int(10) DEFAULT NULL,
        PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_user_skill_bonus_pts_table_sql(){
    $table_name = get_user_skill_bonus_pts_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
       `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
       `user_id` bigint(20) NOT NULL,
       `skill_id` int(11) NOT NULL,
       `domain_id` int(11) DEFAULT NULL,
       `bonus_points` int(10) DEFAULT NULL,
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
      `menu_name` varchar(255) NOT NULL DEFAULT "",
      `description` text,
      `hotspot_info` text,
      `hotspot_xml` text,
      `action_xml` text,
      `points` int(10) NOT NULL,
      `attempts` int(10) NOT NULL,
      `domain_id` int(11) DEFAULT NULL,
      `modal_url` text,
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
      `js_function` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_prereq_sql(){
    $table_name = get_prereq_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `pano_id` int(11) DEFAULT NULL,
      `prereq_id` int(11) DEFAULT NULL,
      `prereq_pts` int(11) NOT NULL,
      `prereq_domain_id` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_activation_code_sql(){
    $table_name = get_activation_code_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `code` varchar(255) NOT NULL,
        `user_id` int(11) DEFAULT NULL,
        `activated` tinyint(2) NOT NULL DEFAULT "0",
        PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_school_sql(){
    $table_name = get_school_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL DEFAULT "",
        PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_domains_sql(){
    $table_name = get_domain_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL DEFAULT "",
        PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_ads_sql(){
    $table_name = get_ads_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `domain_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_ads_text_sql(){
    $table_name = get_ads_text_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `ads_id` int(11) NOT NULL,
      `language_code` varchar(2) NOT NULL DEFAULT "",
      `message` text,
      PRIMARY KEY (`id`)
    );';

    return $sql;
}

function build_tools_sql(){
    $table_name = get_tool_table_name();

    $sql = 'CREATE TABLE ' .$table_name. ' (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `domain_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL DEFAULT "",
        PRIMARY KEY (`id`)
    );';

    return $sql;
}
