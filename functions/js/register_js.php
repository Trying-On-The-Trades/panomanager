<?php

    // Trade = field_17
    // Tool  = field_2
    // Color = field_12
    // School = field_6

// Functions for building the registration javascript to manually edit the registration fields
function return_registration_script(){
    
    $registration_script = "var user_name_field = document.getElementById('signup_username');\n";
    
    // Build the code that will change the school selector to the fields in the database
    $registration_script .= build_school_selector();
    
    // Check if the registration input exists
    $registration_script .= "if (user_name_field){\n";
    
    // Disable and make the username read only
    $registration_script .= "user_name_field.disabled = true;\n";
    $registration_script .= "user_name_field.readOnly = true;\n";
    
    // Create variables for the drop downs
    $registration_script .= "var color_field = document.getElementById('field_12');\n";
    $registration_script .= "var tool_field = document.getElementById('field_2');\n";
    
    // Add the on change listeners
    $registration_script .= "if(window.addEventListener) {\n";
    $registration_script .=     "color_field.addEventListener('change', color_check, false);\n";
    $registration_script .= "} else if (window.attachEvent){\n";
    $registration_script .=     "color_field.attachEvent(\"onchange\", color_check);\n";
    $registration_script .= "}";
    
    $registration_script .= "if(window.addEventListener) {\n";
    $registration_script .=     "tool_field.addEventListener('change', tool_check, false);\n";
    $registration_script .= "} else if (window.attachEvent){\n";
    $registration_script .=     "tool_field.attachEvent(\"onchange\", tool_check);\n";
    $registration_script .= "}\n";
    
    // Get the school check
    $registration_script .= build_school_check_function();
    
    // Get the tool check
    $registration_script .= build_tool_check_function();
    
    // Get the trade check
    $registration_script .= build_color_check_function();
    
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
        $script .= "<option value'" . $school->name . "'>" . $school->name . "</option>";
    }
   
//    $script .= ";";
    return $script;
}

function build_school_check_function(){
    $script = "";
    return $script;
}

////// TOOL FUNCTIONS

function build_tool_check_function(){
    $script = "function tool_check(){\n";
        
        $script .= "user_name_field.value = color_field.value + tool_field.value\n";
    
    $script .= "}\n";
    return $script;
}

////// TRADE FUNCTIONS

function build_trade_select(){
    
}

function build_trade_select_options(){
    
}

function check_trade(){
    
}

///// COLOR FUNTIONS

function build_color_check_function(){
    $script = "function color_check(){\n";
        
        $script .= "user_name_field.value = color_field.value + tool_field.value\n";
    
    $script .= "}\n";
    return $script;
}

///// ACTIVATE CODE FUNCTIONS

function build_code_check_function(){
    $script = "";
    return $script;
}