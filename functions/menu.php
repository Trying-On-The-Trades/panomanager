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
	add_submenu_page("pano_menu",
					 "New Pano", 
					 "New Pano", 
					 "administrator",
					 "new_pano_settings", 
					 "new_pano_settings_page");

	// Create the sub menu item for quests
	add_submenu_page("pano_menu", 
					 "Quests", 
					 "Quests", 
					 "administrator",
					 "pano_quest_settings", 
					 "pano_quest_settings_page");
}