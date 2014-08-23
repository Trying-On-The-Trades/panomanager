<?php

// These functions are where the javascript is built
// They are here because it is confusing to build javascript with PHP

// Build the javascript needed to load the pano into the div
function build_pano_javascript($pano_id){
	$pano_js_location = content_url() . "/panos/" . $pano_id . "/pano.js";
	$pano_swf_location = content_url() . "/panos/" . $pano_id . "/pano.swf";
	$pano_php_location = WP_PLUGIN_URL . "/panomanager.php?return_the_pano=" . $pano_id;

	// printf(content_url());

	wp_register_script('pano_js', $pano_js_location, true);
	wp_enqueue_script('pano_js');

	$script = '<script type="text/javascript">';
	$script .= 'embedpano({';

		// Script that loads the pano
		$script .= 'swf:"' . $pano_swf_location . '"';
		$script .= ',target:"panoDIV"';
		$script .= ',xml:"' . $pano_php_location . '"';
		$script .= ',passQueryParameters:true';

	$script .= '});';

	// Create the krpano object
	$script .= 'var krpano = document.getElementById("krpanoSWFObject");';


	// Close the script tag and send it to the page
	$script .= '</script>';
	return $script;

}