<?php

// Create the admin menu
function pano_create_menu() {
	create_top_menu();
	create_sub_menus();
}

// function to create the top level meny
function create_top_menu(){
	add_menu_page('pano-settings', 
				  'Panos', 
				  'administrator',
				  'pano_menu', 
				  'pano_settings_page',
				  plugins_url('/images/icon.png', __FILE__)
				  );
}

// function to create the sub menus
function create_sub_menus(){

	// Create the sub menu item for new panos
	add_submenu_page(null,
					 "New Pano", 
					 "New Pano", 
					 "administrator",
					 "new_pano_settings", 
					 "new_pano_settings_page");

	// Create the sub menu item for editing panos
	add_submenu_page(null,
					 "Edit Pano",
					 "Edit Pano",
					 "administrator",
					 "edit_pano_settings",
					 "edit_pano_settings_page");

	// Create the sub menu item for quests
	add_submenu_page("pano_menu",
					 "Quests",
					 "Quests",
					 "administrator",
					 "pano_quest_settings",
					 "pano_quest_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
					 "New Quest",
					 "New Quest",
					 "administrator",
					 "new_quest_settings",
					 "new_quest_settings_page");

	// Create the sub menu item for editng quests
	add_submenu_page(null,
					 "Edit Quest",
					 "Edit Quest",
					 "administrator",
					 "edit_quest_settings",
					 "edit_quest_settings_page");

	// Create the sub menu item for quests
	add_submenu_page("pano_menu",
					 "Missions",
					 "Missions",
					 "administrator",
					 "pano_mission_settings",
					 "pano_mission_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
					 "New Mission",
					 "New Mission",
					 "administrator",
					 "new_mission_settings",
					 "new_mission_settings_page");

	// Create the sub menu item for editng quests
	add_submenu_page(null,
					"Edit Mission",
					"Edit Mission",
					"administrator",
					"edit_mission_settings",
					"edit_mission_settings_page");

	// Create the sub menu item for quests
	add_submenu_page("pano_menu",
					 "Hotspots",
					 "Hotspots",
					 "administrator",
					 "pano_hotspot_settings",
					 "pano_hotspot_settings_page");


	// Create the sub menu item for quests
	add_submenu_page(null,
					 "New Hotspot",
					 "New Hotspot",
					 "administrator",
					 "new_hotspot_settings",
					 "new_hotspot_settings_page");


	// Create the sub menu item for editng quests
	add_submenu_page(null,
					"Edit Hotspot",
					"Edit Hotspot",
					"administrator",
					"edit_hotspot_settings",
					"edit_hotspot_settings_page");

}