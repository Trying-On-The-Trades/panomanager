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
	$script .= 'var krpano = document.getElementById("krpanoSWFObject");';
	$script .= 'console.log(krpano);';
	$script .= '</script>';

	return $script;
}