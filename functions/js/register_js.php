<?php

    // Trade = field_17
    // Tool  = field_2
    // Color = field_12
    // School = field_6

// Functions for building the registration javascript to manually edit the registration fields
function return_registration_script(){
    
    $registration_script = "var user_name_field = document.getElementById('signup_username');\n";
    
    // Check if the registration input exists
    $registration_script .= "if (user_name_field){\n";
    
        // Build the code that will change the school selector to the fields in the database
//        $registration_script .= build_school_selector();
//        $registration_script .= build_tool_select();
//        $registration_script .= build_trade_select();
    // Removed for now because BuddyPress was unhappy

        // Disable and make the username read only
        $registration_script .= "user_name_field.readOnly = true;\n";
        $registration_script .= "user_name_field.placeholder='Select a colour and a tool';\n";

        // Create variables for the drop downs
        $registration_script .= "var color_field = document.getElementById('field_12');\n";
        $registration_script .= "var tool_field = document.getElementById('field_2');\n";
        $registration_script .= "var domain_field = document.getElementById('field_17');\n";

        // Get the school check
        $registration_script .= build_school_check_function();
        $registration_script .= build_tool_check_function();
        $registration_script .= build_color_check_function();
        $registration_script .= check_domain();

        // Add the on change listeners
        $registration_script .= buld_colour_listener();
        $registration_script .= build_tool_listener();
        $registration_script .= build_domain_listener();

    // END IF username field
    $registration_script .= "}";
    
    // Output the registration
    echo $registration_script;
    die();
}

///// SCHOOL FUNCTIONS

function build_school_selector(){
    $script = "var school_selector = document.getElementById('field_6');\n";
    
    $new_elements = build_school_dropdown_list();
    
    $script .= 'school_selector.innerHTML = "' . $new_elements . '";';
    
    return $script;
}

function build_school_dropdown_list(){
    $schools = get_schools();
    
    $script = "<option value=''>----</option>";
    
    foreach ($schools as $school) {
        $script .= "<option value='" . $school->name . "'>" . $school->name . "</option>";
    }
   
//    $script .= ";";
    return $script;
}

function build_school_check_function(){
    $script = "";
    return $script;
}

////// TOOL FUNCTIONS
function build_tool_select(){
    $script = "var tool_selector = document.getElementById('field_2');\n";
    
    $new_elements = build_tool_select_options();
    
    $script .= 'tool_selector.innerHTML = "' . $new_elements . '";';
    
    return $script;
}

// Set the inner html to the first select
function build_tool_select_options(){
    $tools = get_tools();
    
    $script = "<option value=''>----</option>";
    
    foreach ($tools as $tool) {
        $script .= "<option class='" . $tool->domain_name . 
                   " tool" . // generic class for all tool dropdowns
                   "' value='"       . $tool->name . 
                   "'>"              . $tool->name . 
                   "</option>";
    }
    
    return $script;
}

function build_tool_check_function(){
    $script = "function tool_check(){\n";
    
        $script .= "var number = Math.floor((Math.random() * 1000) + 1);";
        $script .= "user_name_field.value = color_field.value + tool_field.value + number\n";
    
    $script .= "}\n";
    return $script;
}

function build_tool_listener(){
    $registration_script =  "if(window.addEventListener) {\n";
    $registration_script .=     "tool_field.addEventListener('change', tool_check, false);\n";
    $registration_script .= "} else if (window.attachEvent){\n";
    $registration_script .=     "tool_field.attachEvent(\"onchange\", tool_check);\n";
    $registration_script .= "}\n";
    return $registration_script;
}

////// DOMAIN FUNCTIONS

function build_domain_listener(){
    $registration_script =  "if(window.addEventListener) {\n";
    $registration_script .=     "domain_field.addEventListener('change', domain_check, false);\n";
    $registration_script .= "} else if (window.attachEvent){\n";
    $registration_script .=     "domain_field.attachEvent(\"onchange\", domain_check);\n";
    $registration_script .= "}\n";
    return $registration_script;
}

function build_domain_select(){
    $script = "var domain_selector = document.getElementById('field_17');\n";
    
    $new_elements = build_domain_select_options();
    
    $script .= 'domain_selector.innerHTML = "' . $new_elements . '";';
    
    return $script;
}

function build_domain_select_options(){
    $domains = get_domains();
    
    $script = "<option value=''>----</option>";
    
    foreach ($domains as $domain) {
        $script .= "<option value='" . $domain->name . "'>" . $domain->name . "</option>";
    }
    
    return $script;
}

// Check the domains, handle displaying the correct tools

function check_domain(){
    $script = "function domain_check(){\n";
    
        $script .= "var domain_selector = document.getElementById('field_17');\n";
        $script .= "var tool_options = document.getElementsByClassName('tool');\n";
        
        $script .= "for (var i = tool_options.length - 1; i >= 0; i--) {\n";
        
            $script .= "var class_name = tool_options[i].className;\n";

            $script .= "if (class_name.indexOf(domain_selector.value) > -1){";
            $script .=    "tool_options[i].style.display='block';";
            $script .= "} else {";
            $script .=    "tool_options[i].style.display='none';";
            $script .= "}";
        
//	$script .= "console.log(class_name);";
        $script .= "};\n";
    
    $script .= "}\n";
    return $script;
}

///// COLOR FUNTIONS

function buld_colour_listener(){
    $registration_script =  "if(window.addEventListener) {\n";
    $registration_script .=     "color_field.addEventListener('change', color_check, false);\n";
    $registration_script .= "} else if (window.attachEvent){\n";
    $registration_script .=     "color_field.attachEvent(\"onchange\", color_check);\n";
    $registration_script .= "}";
    return $registration_script;
}

function build_color_check_function(){
    $script = "function color_check(){\n";
        
        $script .= "var number = Math.floor((Math.random() * 1000) + 1);";
        $script .= "user_name_field.value = color_field.value + tool_field.value + number\n";
    
    $script .= "}\n";
    return $script;
}

///// ACTIVATE CODE FUNCTIONS

function build_code_check_function(){
    $script = "";
    return $script;
}