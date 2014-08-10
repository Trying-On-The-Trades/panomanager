<?php

// These functions are where the javascript is built
// They are here because it is confusing to build javascript with PHP

// Build the javascript needed to load the pano into the div
function build_pano_javascript($pano_id){
	$pano_js_location = content_url() . "/panos/" . $pano_id . "/pano.js";
	$pano_swf_location = content_url() . "/panos/" . $pano_id . "/pano.swf";

	// printf(content_url());

	wp_register_script('pano_js', $pano_js_location, true);
	wp_enqueue_script('pano_js');

	$script = '<script type="text/javascript">';
	$script .= 'embedpano({';

		// Script that loads the pano
		$script .= 'swf:"' . $pano_swf_location . '"';
		$script .= ',target:"panoDIV"';
		$script .= ',passQueryParameters:true';

	$script .= '});';

	// Create the krpano object
	$script .= 'var krpano = document.getElementById("krpanoSWFObject");';

	// We have loaded the correct pano, lets add some nodes
	$nodes = build_pano_nodes();

	// Work with the nodes
	$script .= $nodes;

	// Close the script tag and send it to the page
	$script .= '</script>';
	return $script;
}

function build_pano_nodes(){
	$script = '';
	// $script .= 'console.log(krpano);';

	// Get the side menu to add to the pano
	// $script .= build_menu();
	// $script .= "initiate_menu();";

	// Get the bottom nav to add to the pano
	// $script .= build_bottom_nav();

	// Get the pano quests

	// Get the pano missions

	// Build the hotspots

	return $script;
}

function build_menu(){

	$xmlcontents = '<group name="level_0">' +
	    '<group name="object_1" value="Find all of the Fire Extinguishers" link="" />' +
	    '<group name="object_2" value="Locate French Braid" link="" />' +
	    '<group name="object_3" value="Click on Clock" link="" />' +
	    '<group name="object_4" value="Find Guy" link="" />' +
	    '<group name="object_5" value="Find the Barbacide quiz" link="" />' +
	'</group>';

	$script = "krpano.call('loadxml('" + $xmlcontents + "')');";

	return $script;
}

function build_bottom_nav(){
	$nav  = "";

	return $nav;


}

function build_hot_spots(){

}