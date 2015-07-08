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
	add_submenu_page(null,
					 "Upload Zip",
					 "Upload Zip",
					 "administrator",
					 "upload_zip_setting",
					 "upload_zip_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
					 "Prereqs",
					 "Prereqs",
					 "administrator",
					 "prereq_setting",
					 "prereq_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
					 "New Prereqs",
					 "New Prereqs",
					 "administrator",
					 "prereq_new_setting",
					 "prereq_new_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
					 "Edit Prereqs",
					 "Edit Prereqs",
					 "administrator",
					 "prereq_edit_setting",
					 "prereq_edit_settings_page");

	// Create the sub menu item for quests
	add_submenu_page(null,
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

	// Create the sub menu item for missions
	add_submenu_page("pano_menu",
					 "Missions",
					 "Missions",
					 "administrator",
					 "pano_mission_settings",
					 "pano_mission_settings_page");

	// Create the sub menu item for missions
	add_submenu_page(null,
					 "New Mission",
					 "New Mission",
					 "administrator",
					 "new_mission_settings",
					 "new_mission_settings_page");

	// Create the sub menu item for editng missions
	add_submenu_page(null,
					"Edit Mission",
					"Edit Mission",
					"administrator",
					"edit_mission_settings",
					"edit_mission_settings_page");

	// Create the sub menu item for hotspots
	add_submenu_page("pano_menu",
					 "Hotspots",
					 "Hotspots",
					 "administrator",
					 "pano_hotspot_settings",
					 "pano_hotspot_settings_page");


	// Create the sub menu item for hotspots
	add_submenu_page(null,
					 "New Hotspot",
					 "New Hotspot",
					 "administrator",
					 "new_hotspot_settings",
					 "new_hotspot_settings_page");


	// Create the sub menu item for editng hotspots
	add_submenu_page(null,
					"Edit Hotspot",
					"Edit Hotspot",
					"administrator",
					"edit_hotspot_settings",
					"edit_hotspot_settings_page");

	// Create the sub menu item for hotspot types
	add_submenu_page(null,
					"Hotspots Type",
					"Hotspots Type",
					"administrator",
					"pano_hotspot_type_settings",
					"pano_hotspot_type_settings_page");


	// Create the sub menu item for hotspot types
	add_submenu_page(null,
					"New Hotspot Type",
					"New Hotspot Type",
					"administrator",
					"new_hotspot_type_settings",
					"new_hotspot_type_settings_page");


	// Create the sub menu item for editng hotspot types
	add_submenu_page(null,
					"Edit Hotspot Type",
					"Edit Hotspot Type",
					"administrator",
					"edit_hotspot_type_settings",
					"edit_hotspot_type_settings_page");

	// Create the sub menu item for domains
	add_submenu_page("pano_menu",
					"Domains",
					"Domains",
					"administrator",
					"pano_domain_settings",
					"pano_domain_settings_page");


	// Create the sub menu item for domains
	add_submenu_page(null,
					"New Domain",
					"New Domain",
					"administrator",
					"new_domain_settings",
					"new_domain_settings_page");


	// Create the sub menu item for editng domains
	add_submenu_page(null,
					"Edit Domain",
					"Edit Domain",
					"administrator",
					"edit_domain_settings",
					"edit_domain_settings_page");


					// Create the sub menu item for editng domains
	 add_submenu_page("pano_menu",
						"Points Name",
						"Points Name",
						"administrator",
						"edit_points_info_settings",
						"edit_points_info_settings_page");

		add_submenu_page("pano_menu",
						"Initial Points",
						"Initial Points",
						"administrator",
						"edit_initial_points_settings",
						"edit_initial_points_settings_page");

	add_submenu_page("pano_menu",
					"Item Types",
					"Item Types",
					"administrator",
					"item_type_settings",
					"item_type_settings_page");

	add_submenu_page(null,
					"New Item Type",
					"New Item Type",
					"administrator",
					"new_item_type_settings",
					"new_item_type_settings_page");

	add_submenu_page(null,
					"Edit Item Types",
					"Edit Item Types",
					"administrator",
					"edit_item_type_settings",
					"edit_item_type_settings_page");

    add_submenu_page("pano_menu",
                    "Items",
                    "Items",
                    "administrator",
                    "items_settings",
                    "item_settings_page");
}
