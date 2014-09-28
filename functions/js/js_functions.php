<?php

// These functions are where the javascript is built
// They are here because it is confusing to build javascript with PHP

// Build the javascript needed to load the pano into the div
function build_pano_javascript($pano_id, $pano, $quest){
        $pano_directory = content_url() . "/panos/" . $pano_id;
	$pano_swf_location = $pano_directory . "/tour.swf";
	$pano_php_location = WP_PLUGIN_URL . "/panomanager.php?return_the_pano=" . $pano_id;
       
        //Add the styles and javascript
        register_scripts($pano_directory);
        $script = "<style>" . build_popup_styles() . "</style>";
        
        // Get the menu nav
        $script .= build_menu_nav($quest);
        
        // Get the scripts to build the navigation menu first
        $script .= add_nav_script();
       
        // Get the embed script
        $script .= build_embed_script($pano_swf_location, $pano_php_location);
        
	return $script;
}

function register_scripts($pano_directory){
    $mmenu            = WP_PLUGIN_URL . "/panomanager/js/mmenu/js/jquery.mmenu.min.all.js";
    $mmenu_css        = WP_PLUGIN_URL . "/panomanager/js/mmenu/css/jquery.mmenu.all.css";
    $magnific_js      = $pano_directory . "/magnific-popup/jquery.magnific-popup.js";
    $magnific_css     = $pano_directory . "/magnific-popup/magnific-popup.css";
    $pano_js_location = $pano_directory . "/tour.js";
    $toast_js         = WP_PLUGIN_URL . "/panomanager/js/toast/javascript/jquery.toastmessage.js";
    $toast_css        = WP_PLUGIN_URL . "/panomanager/js/toast/css/jquery.toastmessage.css";
        
    //// JQUERY
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js", false, null);
    wp_enqueue_script('jquery');

    //// KRPANO
    wp_register_script('pano_js', $pano_js_location);
    wp_enqueue_script('pano_js');

    //// MMENU APP SLIDER
    wp_register_script('mmenu', $mmenu);
    wp_enqueue_script('mmenu');
    wp_register_style('mmenu_css', $mmenu_css);
    wp_enqueue_style('mmenu_css');

    //// MAGNIFIC LIGHTVIEW
    wp_register_script('magnific_js', $magnific_js);
    wp_enqueue_script('magnific_js');
    wp_register_style('magnific_css', $magnific_css);
    wp_enqueue_style('magnific_css');

    //// JQUERY TOAST
    wp_register_script('toast_js', $toast_js);
    wp_enqueue_script('toast_js');
    wp_register_style('toast_css', $toast_css);
    wp_enqueue_style('toast_css');
}

function build_embed_script($pano_swf_location, $pano_php_location){
    // Now add the embed pano to launch the pano
    $script = '<script type="text/javascript">';
    $script .= 'embedpano({';

            // Script that loads the pano
            $script .= 'swf:"' . $pano_swf_location . '"';
            $script .= ',xml:"' . $pano_php_location . '"';
            $script .= ',target:"panoDIV"';
            $script .= ',html5:"prefer"';
            $script .= ',passQueryParameters:true';

    $script .= '});';

    // Close the script tag and send it to the page
    $script .= '</script>';

    return $script;
}

function add_nav_script(){
    $script = "\n<script type='text/javascript'>\n";
    
    $script .= "var krpano;\n";
    $script .=	"var siteAdr = 'http://tot.boldapps.net/?pano_id=';\n";
    
    // Build the array of names
    $script .= build_names_array();
            
    // Build the array of ids
    $script .=	build_ids_array();
  
    // The default pointer
    $script .=	"var pointer = 0;\n";
    $script .=  "var defaultVar = 1;\n";
    $script .= "var magnificPopup;";
    
    $script .= build_launch_message();
    $script .= build_find_array();    
    $script .= build_get_scene_name();
    
    $script .= "$(document).ready(function() {\n";
    $script .= "$('#my-menu').mmenu({ slidingSubmenus: false });\n";
    $script .= "krpano = document.getElementById('krpanoSWFObject');\n";
    $script .= "});\n";
    
    $script .= build_menu_launch();
    $script .= build_leader_launch();
    $script .= build_callback_function();
    
    $script .= "</script>";
        
    return $script;
}

function build_names_array(){
    $allowed_panos = list_allowed_panos(get_current_user_id());
    
    $script .=  "var panoArray = Array(";
    
    for ($i = 0; $i < count($allowed_panos); $i++) {
        
        $script .= "'" . $allowed_panos[$i]->name . "'";
        
        if ($i == count($allowed_panos) - 1) {
            
            $script .= '';
        } else {
            $script .= ', ';
        }
    }
    
    $script .= ");\n";
    return $script;
}

function build_ids_array(){
    $allowed_panos = list_allowed_panos(get_current_user_id());
    $script .=  "var panoPointer = Array(";
    
    for ($i = 0; $i < count($allowed_panos); $i++) {
        
        $script .= "'" . $allowed_panos[$i]->id . "'";
        
        if ($i == count($allowed_panos) - 1) {
            
            $script .= '';
        } else {
            $script .= ', ';
        }
    }
    
    $script .= ");\n";
    return $script;
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
        
//        $script .= "console.log('False');\n";
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
    $script =  "function menuLaunch()\n";
    $script .= "{\n";
    $script .= "$('#mission-menu').trigger('open.mm');\n";
    $script .= "}\n";
    return $script;
}

function build_leader_launch(){
    $script = "function leaderLaunch()\n";
    $script .= "{\n";
    $script .= "$.magnificPopup.open({\n";
    $script .= "items: {\n";
    $script .= "src: '" . build_leaderboard_div() .  "'\n";
    $script .= "},\n";
    $script .= "type: 'inline',\n";
    $script .= "closeOnBgClick: true,\n";
    $script .= "closeBtnInside: true,\n";
    $script .= "callbacks: {\n";
    $script .= "close: function() {\n";
//    $script .= "console.log('Popup removal initiated (after removalDelay timer finished)');\n";
    $script .= "$.magnificPopup.close(); \n";
    $script .= "}\n";
    $script .= "}\n";
    $script .= "});\n";
    $script .= "$.magnificPopup = $.magnificPopup.instance; \n";
//    $script .= "console.log('test');\n";
    $script .= "}\n";

return $script;
}


////// HIDDEN MENU NAV
function build_menu_nav($quest){
//    $script = '<div style="display:none" class="slider_menu">';
    $script = '<nav id="mission-menu">
                <ul >
                    <li class="Label">Missions</li>';
      
    // Get the elements needed to build the menu
    $script .= get_mission_tasks($quest);
    
    $script .= '</ul>
                 </nav>';
//    $script .= '</div>';
    return $script;
}

function get_mission_tasks($quest){
    
    // Get the missions and the hotspot information for the menu
    $menu_missions = get_hotspot_menu_objects($quest);
    
    // Make sure there is atleast some text
    $missions = "";
    
    // Build the menu
    foreach ($menu_missions as $item){
        if ($item->is_menu_item()){
            $missions .= "<li id='" . 
                     $item->get_id() . "_menu_item'>" . 
                     "<a href='#'>" .
                     $item->get_menu_name() . 
                     "</a></li>";
        }
    }
    
    return $missions;
}

/////////// LEADERBOARD FUNCTIONS
function build_leaderboard_div(){

    $board = '<div class="white-popup">';
    $board .= '<h2>Leaderboard</h2>';
    
    // Create the table for schools
    $board .= build_school_table();
    
    // Create the table for individuals
    $board .= build_individual_table();

    // Close the modal
    $board .= '</div>';
    return $board;
}

function build_school_table(){
    $leaderboard_enteries = get_school_leaderboard();
    $count = 0;
   
    $board = '<h3>School Leaderboard</h3>';
    $board .= '<table>';
    $board .= '<tr><th>Place</th><th>School</th><th>Score</th>';
    
    // Fill with content
    foreach ($leaderboard_enteries as $entry) {
        $count += 1;
        
        $board .= '<tr class"entry">';
            $board .= '<td>' . $count . '</td>';
            $board .= '<td class"school">' . $entry->name . '</td>';
            $board .= '<td class"point">' . $entry->score . '</td>';
        $board .= '</tr>';
    }
    
    $board .= '</table>';
    
    return $board;
}

function build_individual_table(){
    $leaderboard_enteries = get_leaderboard();
    $count = 0;
    
    // Create the table for individuals
    $board = '<h3>User Leaderboard</h3>';
    $board .= '<table>';
    $board .= '<tr><th>Place</th><th>Name</th><th>School</th><th>Score</th>';
    
    // Fill with content
    foreach ($leaderboard_enteries as $entry) {
        $count += 1;
        
        $board .= '<tr class"entry">';
            $board .= '<td>' . $count . '</td>';
            $board .= '<td class"nam">' . $entry->name . '</td>';
            $board .= '<td class"school">' . $entry->school . '</td>';
            $board .= '<td class"point">' . $entry->score . '</td>';
        $board .= '</tr>';
    }
    
    $board .= '</table>';
    
    return $board;
}

// Just the css for the popup menu
function build_popup_styles(){
    return '.white-popup {
            position: relative;
            background: #FFF;
            padding: 20px;
            width:auto;
            max-width: 500px;
            margin: 20px auto;
          }';
}

///////////  Points Callback Functions
function build_callback_function(){
    $script  = "function addPts(id){\n";
    $script .= "$('#' + id + '_menu_item').remove();\n";
    
    $script .= "$.ajax({\n";
    $script .= "type: 'POST',\n";
    $script .= "url: '" . get_admin_url() . "admin-post.php',\n";
    $script .= "data: {action: 'update_progress',\n";
    $script .= "hotspot: id},\n";
    $script .= "success: function(d){\n";
    $script .= "console.log(d);\n"; 
    $script .= "$().toastmessage('showWarningToast', 'You earned ' + d + ' points!');\n";
    $script .= "}\n";
    $script .= "});\n";
    
    $script .= "console.log(id);\n"; 
    $script .= "}\n";
    return $script;
}