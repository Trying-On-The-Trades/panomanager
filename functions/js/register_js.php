<?php

// Functions for building the registration javascript to manually edit the registration fields
function return_registration_script(){
    
    $registration_script = "var user_name_field = document.getElementById('signup_username');";
    
    $registration_script .= "user_name_field.disabled = true;";
    
    $registration_script .= "user_name_field.readOnly = true;";
    
    
    // Get the school check
    $registration_script .= build_school_check_function();
    
    // Get the tool check
    $registration_script .= build_tool_check_function();
    
    // Get the trade check
    $registration_script .= build_trade_check_function();
    
    // Output the registration
    echo $registration_script;
    die();
}

function build_school_check_function(){
    $script = "";
    return $script;
}

function build_tool_check_function(){
    $script = "";
    return $script;
}

function build_trade_check_function(){
    $script = "";
    return $script;
}

function build_code_check_function(){
    $script = "";
    return $script;
}