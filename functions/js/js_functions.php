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
        $script .= add_nav_script($quest);
       
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
    $jqueryui_js      = WP_PLUGIN_URL . "/panomanager/js/jqueryui/js/jquery-ui.min.js";
    $jqueryui_css     = WP_PLUGIN_URL . "/panomanager/js/jqueryui/css/jquery-ui.css";
    
    $jquery_migrate   = WP_PLUGIN_URL . "/panomanager/js/jquery-migrate-1.2.1.min.js";
    $jquery_bold      = WP_PLUGIN_URL . "/panomanager/js/jquery-bold-1.11.2.js";
        
    //// JQUERY
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
    
    //wp_register_script('jquery_bold', $jquery_bold);
    //wp_enqueue_script('jquery_bold');
    
    wp_register_script('jquery_migrate', $jquery_migrate);
    wp_enqueue_script('jquery_migrate');

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
    
    //// JQUERYUI 
    wp_register_script('jqueryui_js', $jqueryui_js);
    wp_enqueue_script('jqueryui_js');
    wp_register_style('jqueryui_css', $jqueryui_css);
    wp_enqueue_style('jqueryui_css');
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

function add_nav_script($quest){
    $script = "\n<script type='text/javascript'>\n";
    
    $script .= "var krpano;\n";
    $script .=	"var siteAdr = 'http://tott.e-apprentice.ca/?pano_id=';\n";
    
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
    
    //MY SCRIPTS ////////////////////////
	$script .= build_launch_hairstyling($quest);
	$script .= build_launch_image($quest);
	$script .= build_launch_game($quest);
	$script .= build_manage_lightbox($quest);
	$script .= build_launch_quizlet($quest);
	$script .= build_launch_khan($quest);
	$script .= build_launch_hazard($quest);
    
    $script .= "$(document).ready(function() {\n";
    $script .= "$('#my-menu').mmenu({ slidingSubmenus: false });\n";
    $script .= "krpano = document.getElementById('krpanoSWFObject');\n";
    $script .= "pojQuery('.hotspot_tooltip').tooltip();\n";
    $script .= "});\n"; 
    
    $script .= build_menu_launch();
    $script .= build_leader_launch();
    $script .= build_callback_function();
    $script .= build_login_button();
    
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
    $script .= "magnificPopup = $.magnificPopup.instance; \n";
//    $script .= "console.log('test');\n";
    $script .= "}\n";

return $script;
}

function build_login_button(){
    $script  = "function launchLogin(){";
    $script .= "window.location.replace('http://tott.e-apprentice.ca/login');";
    $script .= "}";
    return $script;
}

function build_manage_lightbox($quest){
	$script  = "function launchLogin(){\n";
	$script .= "window.location.replace('tott.e-apprentice.ca/login');\n";
	$script .= "}\n";
	
	$script  = "function manageLightbox(srcName)\n";
	$script  .= "{\n";
	$script  .=		"switch(srcName)\n";
	$script  .=		"{\n";
	$script  .=			"case 'cabinet':\n";
	$script  .=				"launchImage('http://tott.e-apprentice.ca/wp-content/panos/1/TVCAB-5.jpg', 'Cabinet', 1);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'hairblower':\n";
	$script  .=				"launchGame('http://tott.e-apprentice.ca/games/stylehat.1.3.html', 'hairblower', 2);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'speaker':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:khan_00', 'khan', 3);\n";
	//http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises//khan-exercises/indirect/?ity_ef_site=raw&amp;ity_ef_slug=static%3Akhan_02&amp;ity_ef_origin=http%3A%2F%2Ftott.e-apprentice.ca%2Fwp-content%2Fplugins%2Fkhan-exercises%2Fkhan-exercises%2Findirect%2F%3Fity_ef_format%3Diframe%26ity_ef_slug%3Dstatic%3Akhan_02
	$script  .=				"break;\n";
	$script  .=			"case 'clock':\n";
	$script  .=				"//launchHairstyling('http://109.73.239.136/~eapprent/tott/Hardhat-game/stylehat.1.2.html', 'clock', 4);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'braid':\n";
	$script  .=				"//launchHairstyling('http://109.73.239.136/~eapprent/tott/wp-content/uploads/stjames/blogger-image-569397039.jpg', 'braid');\n";
	$script  .=				"launchImage('http://tott.e-apprentice.ca/wp-content/panos/1/blogger-image-569397039.jpg', 'Braid', 5);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'fe_1':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:khan_01', 'khan', 6);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'guy':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:khan_02', 'khan', 7);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'solution':\n";
	$script  .=				"launchHairstyling('https://quizlet.com/52769033/scatter/embedv2', 'solution', 8);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'cody':\n";
	$script  .=				"launchHairstyling('https://www.youtube.com/watch?v=BErPdC0UIK4', 'cody', 9);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'brooke':\n";
	$script  .=				"launchHairstyling('https://www.youtube.com/watch?v=4ITKlmMrs8s', 'brooke', 10);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'gohome':\n";
	$script  .=				"addPts(0,10);\n";
	$script  .= 				"setInterval(function(){ window.location = 'http://tott.e-apprentice.ca/?pano_id=16'; }, 2000);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'whiteboard':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:khan_03', 'khan', 12);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'projector':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:khan_04', 'khan', 13);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'firealarm':\n";
	$script  .=				"launchHazard('http://tott.e-apprentice.ca/games/spotHazzards/Hazzards_serverside.html', 'firealarm', 14);\n";
	$script  .=				"break;\n";
	$script  .=			"case 'khan':\n";
	$script  .=				"launchKhan('http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:guy_decimals_on_the_number_line_1', 'khan', 15);\n";
	$script  .=				"break;\n";
	$script  .=			"default:\n";
	$script  .=				"launchHairstyling('http://109.73.239.136/~eapprent/tott/Hardhat-game/stylehat.1.2.html', 'speaker');\n";
	$script  .=		"}\n";
	$script  .=	"}\n";
	
	return $script;
}


function build_launch_image($quest)
{
    $messages = get_pano_ad_message($quest);
    
	$script  = "function launchImage(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
        
        $script  .=             "var ad_messages = [";
            foreach($messages as $message){
                $script .= "'" . $message.  "',";
            }
        $script  .=             "];\n";
        
	$script  .=		"var message = ad_messages[ Math.floor(Math.random() * " . count($messages) . ") ];\n";
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	$script  .=				"src: '<div class=\"hotspot_img_popup\"><div class=\"ad_message\">' + message + '</div><img src=\"' + msgUrl + '\"></div>'\n";
	$script  .=				"},\n";
	$script  .=			      "type: 'inline',\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=						"addPts(mnuId,10); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_launch_hairstyling($quest)
{
	$script  = "function launchHairstyling(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
        $script  .=             build_ad_message($quest);
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	$script  .=				"src: msgUrl\n";
	$script  .=				"},\n";
	$script  .=			      "type: 'iframe',\n";
	$script  .=				"retina: { \n";
	$script  .=				"ratio: 3 // can also be function that should retun this number \n";
	$script  .=				"} ,\n";
	$script  .=				"iframe: { \n";
	$script  .=					"markup: '<div class=\"mfp-iframe-scaler hotspot_hairstyling hairClass\"><div class=\"mfp-close\"></div><div class=\"ad_message\">' + message + '</div><iframe class=\"mfp-iframe\" frameborder=\"0\" allowfullscreen></iframe></div>'},\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"addPts(mnuId,10); \n";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_launch_hazard($quest)
{
	$script  = "function launchHazard(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
        //$script  .=             build_ad_message($quest);
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	$script  .=				"src: msgUrl\n";
	$script  .=				"},\n";
	$script  .=			      "type: 'iframe',\n";
	$script  .=				"retina: { \n";
	$script  .=				"ratio: 3 // can also be function that should retun this number \n";
	$script  .=				"} ,\n";
	$script  .=				"iframe: { \n";
	$script  .=					"markup: '<div class=\"mfp-iframe-scaler hotspot_hazard hazardClass\"><div class=\"mfp-close\"></div><iframe class=\"mfp-iframe\" frameborder=\"0\" allowfullscreen></iframe></div>'},\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=				"verticalFit: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"addPts(mnuId,10); \n";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_launch_game($quest)
{
	$script  = "function launchGame(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
        $script  .=             build_ad_message($quest);
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	$script  .=				"src: msgUrl\n";
	$script  .=				"},\n";
	$script  .=			      "type: 'iframe',\n";
	$script  .=				"iframe: { \n";
	$script  .=					"markup: '<div class=\"mfp-iframe-scaler hotpot_game your-special-css-class\"><div class=\"mfp-close\"></div><div class=\"ad_message\">' + message + '</div><iframe class=\"mfp-iframe\" frameborder=\"0\" allowfullscreen></iframe></div>'},\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"var iframe = $('.mfp-iframe');";
	$script  .=						"var contents = iframe.contents();";
	$script  .=						"var points = $(contents).find('#points').html();";
	$script  .=						"points = points.replace ( /[^\d.]/g, '' );";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=						"addPts(mnuId,points); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_launch_quizlet($quest)
{       
	$script  = "function launchQuizlet(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	$script  .=				"src: msgUrl\n";
	$script  .=				"},\n";
	$script  .=			      "type: 'iframe',\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"var iframe = $('.mfp-iframe');";
	$script  .=						"var contents = iframe.contents();";
	$script  .=						"var points = $(contents).find('#scorevalue').html();";
	$script  .=						"points = points.replace ( /[^\d.]/g, '' );";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=						"addPts(mnuId,points); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_launch_Khan($quest)
{       
	$script  = "function launchKhan(msgUrl, cnslCode, mnuId)\n";
	$script  .=	"{\n";
        $script  .=             build_ad_message($quest);
	$script  .=		"$.magnificPopup.open({\n";
	$script  .=			"items: {\n";
	//$script  .=				"src: 'http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/khan-exercises/indirect/?ity_ef_format=iframe&ity_ef_slug=static:absolute_value_equations' \n";
	$script  .=				"src: msgUrl \n";
	//$script  .=				"src: '<div class=\"white-popup mfp-hide\"><script type=\"text/javascript\" src=\"http://tott.e-apprentice.ca/wp-content/plugins/khan-exercises/embed.js?static:absolute_value_equations\"></script><\div>' \n";
	$script  .=				"},\n";
	$script  .=			      "type: 'iframe',\n";
	$script  .=				"iframe: { \n";
	$script  .=					"markup: '</div><div class=\"mfp-iframe-scaler khanClass ad_message_close\"><div class=\"mfp-close\"></div><div class=\"ad_message\">' + message + '</div><iframe class=\"mfp-iframe\" frameborder=\"0\" allowfullscreen></iframe></div>'},\n";
	$script  .=			      "titleSrc: cnslCode,\n";
	$script  .=			      "closeOnBgClick: true,\n";
	$script  .=			      "closeBtnInside: true,\n";
	$script  .=			      "callbacks: {\n";
	$script  .=					"close: function() {\n";
	$script  .=						"console.log('Popup removal initiated (after removalDelay timer finished)');\n";
	$script  .=						"var iframe = $('.mfp-iframe');";
	$script  .=						"var contents = iframe.contents();";
	$script  .=						"var khanFrame = $(contents).find('.mfp-iframe').contents();";
	$script  .=						"var points = $(khanFrame).find('#points').html();";
	//$script  .=						"var points = $(contents).find('#points').html();";
	$script  .=						"points = points.replace ( /[^\d.]/g, '' );";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=						"addPts(mnuId,points); \n";
	$script  .=						"magnificPopup.close(); \n";
	$script  .=						"addPts(mnuId,10); \n";
	$script  .=					"}\n";
	$script  .=			     " }\n";
	$script  .=		"});\n";
	$script  .=		"magnificPopup = $.magnificPopup.instance; \n";
	$script  .=		"console.log(cnslCode);\n";
	$script  .=	"}\n";
	
	return $script;
}

function build_ad_message($quest){
    
    $script = "";
    $messages = get_pano_ad_message($quest);
        
    $script  .= "var ad_messages = [";
        foreach($messages as $message){
            $script .= "\" . $message .  \",";
	     //$script .= "'" . $message.  "',";
        }
    $script  .= "];\n";

    $script  .=	"var message = ad_messages[ Math.floor(Math.random() * " . count($messages) . ") ];\n";
    
    return $script;
}

////// HIDDEN MENU NAV
function build_menu_nav($quest){
//    $script = '<div style="display:none" class="slider_menu">';
    $points = calculate_total_user_points();
    
    $script = '<nav id="mission-menu">
                <ul >
                    <li class="Label">
                        <span class="mission_title">Mission</span>
                        <span class="user_points">Total Mission Points <span id="displayed_points" data-points="' . $points . '">' . $points . '</span></span></li>';
      
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
            
            $completed_state = ($item->get_completed_state()) ? "hotspot_done" : "";
            
            $missions .= "<li id='" . 
                     $item->get_id() . "_menu_item' class='" . $completed_state . "'>" . 
                     "<a href='#' class='hotspot_tooltip' title='" . $item->get_description() . "'>" .
                     "<span class='hotspot_name'>" . $item->get_menu_name() . "</span>" .
                     "<span class='hotspot_points'>" . $item->get_points() . "</span>" .
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
    $script  = "function addPts(id, pts){\n";
    $script .= "$('#' + id + '_menu_item').addClass('hotspot_done');\n";
    $script .= "var points = parseInt($('#displayed_points').attr('data-points'));\n";
    
    $script .= "$.ajax({\n";
    $script .= "type: 'POST',\n";
    $script .= "url: '" . get_admin_url() . "admin-post.php',\n";
    $script .= "data: {action: 'update_progress',\n";
    $script .= "hotspot: id},\n";
    $script .= "success: function(d){\n";
    $script .= "var earned_points = parseInt(d);\n";
    $script .= "var total_points = points + earned_points;\n";
    $script .= "$('#displayed_points').attr('data-points', total_points);\n";
    $script .= "$('#displayed_points').html(total_points);\n";
    $script .= "if(earned_points > 0){\n";
    $script .= "$().toastmessage('showSuccessToast', 'You earned ' + d + ' points!');\n";
    $script .= "}\n";
    $script .= "}\n";
    $script .= "});\n";
    
    $script .= "console.log(id);\n"; 
    $script .= "}\n";
    return $script;
}