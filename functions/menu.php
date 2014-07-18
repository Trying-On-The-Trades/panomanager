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
				  __FILE__, 
				  'pano_settings_page',
				  plugins_url('/images/icon.png', 
				  			  __FILE__)
				  );
}

// function to create the sub menus
function create_sub_menus(){
	add_submenu_page("pano-settings", 
					 "Quests", 
					 "administrator", 
					 0, 
					 "pano_quest_settings", 
					 "pano_quest_settings_page");
}