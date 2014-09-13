<?php

// These functions are where the javascript is built
// They are here because it is confusing to build javascript with PHP

// Build the javascript needed to load the pano into the div
function build_pano_javascript($pano_id){
        $pano_directory = content_url() . "/panos/" . $pano_id;
	$pano_js_location =  $pano_directory . "/tour.js";
	$pano_swf_location = $pano_directory . "/tour.swf";
	$pano_php_location = WP_PLUGIN_URL . "/panomanager.php?return_the_pano=" . $pano_id;

	wp_register_script('pano_js', $pano_js_location, true);
	wp_enqueue_script('pano_js');
        
        // Add the popup css and js
        $script =  "<link rel='stylesheet' href='" . $pano_directory . "magnific-popup/magnific-popup.css'>";
	$script .= "<script src='" . $pano_directory . "magnific-popup/jquery.magnific-popup.js'></script> ";
        
        // Get the menu nav
        $script .= build_menu_nav();
        
        // Get the scripts to build the navigation menu first
        $script .= add_nav_script();
       
        // Get the embed script
        $script .= build_embed_script($pano_swf_location, $pano_swf_location);
        
	return $script;
}

function build_embed_script($pano_swf_location, $pano_swf_location){
    // Now add the embed pano to launch the pano
    $script = '<script type="text/javascript">';
    $script .= 'embedpano({';

            // Script that loads the pano
            $script .= 'swf:"' . $pano_swf_location . '"';
            $script .= ',xml:"' . $pano_swf_location . '"';
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
    $script .=	"var siteAdr = 'http://tot.boldapps.net/test/?pano_id=';\n";
    
    // Build the array of names
    $script .=  "var panoArray = Array(\"scene_hairstyling4\", \"scene_mainpeople_smaller\", \"scene_warroom_mood\", \"scene_kitchenpeople_optimized_0\");\n";
    
    // Build the array of ids
    $script .=	"var panoPointer = Array('1','2', '3', '4');\n";
  
    // The default pointer
    $script .=	"var pointer = 0;\n";	
    
    $script .= build_launch_message();
    $script .= build_find_array();    
    $script .= build_get_scene_name();
    
    $script .= "$(document).ready(function() {\n";
    $script .= "$('#mission-menu').mmenu({\n";
    $script .= "slidingSubmenus: false\n";
    $script .= "});\n";
    $script .= "});\n";
    
    $script .= build_menu_launch();
    $script .= build_leader_launch();
    
    $script .= "</script>";
        
    return $script;
}

function build_names_array(){
    
}

function build_ids_array(){
    
}

function build_launch_message(){
    $script =	"function launchMsg(msg){\n";
        $script .= "if(findArray(msg))\n";
        $script .= "{\n";
            $script .= "if(msg == getSceneName())\n";
        $script .= "{\n";     
        $script .= "$.magnificPopup.open({\n";
            $script .= "items: {\n";
            $script .= "src: '<div class=\"white-popup msg\">You are already on this level.</div>',\n";
            $script .= "type: 'inline',\n";
                $script .= "callbacks: {\n";
                    $script .= "close: function() {\n";
                        $script .= "console.log('Popup removal initiated (after removalDelay timer finished)');\n";
                        $script .= "magnificPopup.close(); \n";
                    $script .= "}\n";	
                $script .= "}\n";	
            $script .= "}\n";
        $script .= "});\n";
        
        $script .= "magnificPopup = $.magnificPopup.instance; \n";
        $script .= "}\n";
        $script .= "else\n";
        $script .= "{\n";
        $script .= "window.location = siteAdr + panoPointer[pointer];\n";
        $script .= "}\n";

        $script .= "}\n";
        $script .= "else\n";
        $script .= "{\n";
        
        $script .= "console.log('False');\n";
        $script .= "$.magnificPopup.open({\n";
            $script .= "items: {\n";
                $script .= "src: '<div class=\"white-popup\">You do not have access to this level. Click anything to close this message</div>',\n";
                $script .= "type: 'inline',\n";
                $script .= "callbacks: {\n";
                    $script .= "close: function() {\n";
                        $script .= "console.log('Popup removal initiated (after removalDelay timer finished)');\n";
                        $script .= "magnificPopup.close();\n"; 
                    $script .= "}\n";
                $script .= "}\n";
            $script .= "}\n";
        $script .= "});\n";
        
        $script .= "magnificPopup = $.magnificPopup.instance;}\n";	
    $script .=	"}\n";
    
    return $script;
}

// The function that finds the id in the array
function build_find_array(){
    $script =	"function findArray(input)";
    $script .=	"{\n";
        $script .=	"var checker = false;\n";			
        $script .=	"for(var i = 0; i < panoArray.length; i++)";
        $script .=	"{\n";
        $script .=	"if(input == panoArray[i])";
        $script .=	"{\n";
            $script .=	"checker = true;\n";
            $script .=	"pointer = i;\n";
            $script .=	"}\n";
        $script .=	"}\n";
        $script .=	"return checker;\n";
    $script .= "}\n";
    
    return $script;
}

function build_get_scene_name(){
    $script =  "function getSceneName()\n";
    $script .= "{\n";
    $script .= "return krpano.get('xml.scene');\n";
    $script .= "}\n";
    return $script;
}

function build_menu_launch(){
    $script =  "function menuLaunch()";
    $script .= "{";
    $script .= "$('#mission-menu').trigger('open.mm');";
    $script .= "}";
    return $script;
}

function build_leader_launch(){
    $script = "function leaderLaunch()\n";
    $script .= "{\n";
    $script .= "$.magnificPopup.open({\n";
    $script .= "items: {\n";
    $script .= "src: 'http://tott.e-apprentice.ca/spotHazzards/Hazzards_serverside.html'\n";
    $script .= "},\n";
    $script .= "type: 'iframe',\n";
    $script .= "closeOnBgClick: true,\n";
    $script .= "closeBtnInside: true,\n";
    $script .= "callbacks: {\n";
    $script .= "close: function() {\n";
    $script .= "console.log('Popup removal initiated (after removalDelay timer finished)');\n";
    $script .= "magnificPopup.close(); \n";
    $script .= "}\n";
    $script .= "}\n";
    $script .= "});\n";
    $script .= "magnificPopup = $.magnificPopup.instance; \n";
    $script .= "console.log('test');\n";
    $script .= "}\n";

return $script;
}


////// HIDDEN MENU NAV
function build_menu_nav(){
    $script = '<nav id="mission-menu">
                <ul >
                    <li class="Label">Missions</li>
                    <a href="#my-page">Close the menu</a>';
      
    // Get the elements needed to build the menu
    $script .= get_mission_tasks();
    
    
   $script .= '</ul>
                </nav>';
   
    return $script;
}

function get_mission_tasks(){
    
    $missiong = '<li><a href="">Find the Clock</a></li>
      <li>
         <a href="">Locate all Braids</a>
         <ul>
            <li><a href="">Braid 1</a></li>
            <li><a href="">Braid 2</a></li>
            <li><a href="">Braid 3</a></li>
         </ul>
      </li>
      <li class="Spacer"><a href="">Where is Guy</a></li>';
    
    
    return $missions;
}