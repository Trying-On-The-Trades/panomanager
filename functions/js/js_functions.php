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
        
        // Get the scripts to build the navigation menu first
        $script = add_nav_script();

        // Now add the embed pano to launch the pano
	$script .= '<script type="text/javascript">';
	$script .= 'embedpano({';

		// Script that loads the pano
		$script .= 'swf:"' . $pano_swf_location . '"';
                $script .= ',xml:"' . $pano_php_location . '"';
		$script .= ',target:"panoDIV"';
                $script .= ',html5:"prefer"';
		$script .= ',passQueryParameters:true';

	$script .= '});';

	// Create the krpano object
	$script .= 'var krpano = document.getElementById("krpanoSWFObject");';


	// Close the script tag and send it to the page
	$script .= '</script>';
	return $script;

}

function add_nav_script(){
    $script = "<script type='text/javascript'>";
    $script .=	"var siteAdr = 'http://tot.boldapps.net/test/?pano_id=';";
    
    // Build the array of names
    $script .=  "var panoArray = Array('scene_hairstyling', 'scene_mainpeople_smaller');";
    
    // Build the array of ids
    $script .=	"var panoPointer = Array('1','2');";
  
    // The default pointer
    $script .=	"var pointer = 0;";	
    
    $script .= build_launch_message();
    $script .= build_find_array();    
    
    $script .= "</script>";
        
    return $script;
}

function build_names_array(){
    
}

function build_ids_array(){
    
}

function build_launch_message(){
    $script =	"function launchMsg(msg)";
    $script .=	"{";
        $script .=	"if(findArray(msg))";
        $script .=	"{";
            $script .=	"window.location = siteAdr + panoPointer[pointer];";
        $script .=	"}";
        $script .=	"else";
        $script .=	"{";
            $script .=	'window.location = siteAdr + 1;';
        $script .=	"}";	
    $script .=	"}";
    
    return $script;
}

// The function that finds the id in the array
function build_find_array(){
    $script =	"function findArray(input)";
    $script .=	"{";
        $script .=	"var checker = false;";			
        $script .=	"for(var i = 0; i < panoArray.length; i++)";
        $script .=	"{";
        $script .=	"if(input == panoArray[i])";
        $script .=	"{";
            $script .=	"checker = true;";
            $script .=	"pointer = i;";
            $script .=	"}";
        $script .=	"}";
        $script .=	"return checker;";
    $script .= "}";
    
    return $script;
}