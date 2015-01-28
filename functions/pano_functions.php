<?php

// Build up the actual XML to pass to the KRPANO viewer
function build_pano_xml($pano_id){

        
        // Create the actual pano object from the database
        $pano = build_pano($pano_id);
        $quest = build_quest($pano->get_id());
        
        // Get XML
        $main_xml = xml_middle_man($pano);

        // Create object
        $pano_xml_obj = build_simple_xml_obj($main_xml);

        // Fix reference links
        $fixed_xml_object = fix_references($pano_id, $pano_xml_obj);

        // Add the nodes
        $xmk_obj_with_nodes = add_pano_hotspots($fixed_xml_object, $quest, $pano_id);

        // turn object back into XML
        $new_xml = $xmk_obj_with_nodes->saveXML();

        // Output XML
        spit_out_xml($new_xml);
}

// Return the pano to the viewer
function spit_out_xml($xml){
        // We are returning xml
       //header('Content-Type: text/xml');

        echo $xml;
        die();
}

// Create an object out the XML with debugging
function build_simple_xml_obj($xml, $debugging = false){
        $obj = simplexml_load_string($xml);

        // Display the object when manipulating it
        if ($debugging){
                print_r($obj);
                die();
        }

        return $obj;
}

// Return the XML from the pano object
function xml_middle_man($pano){

        return $pano->get_xml();
}

// The Pano XML created by the software doen't have the proper ref links
function fix_references($pano_id, $xml_object){

    // Base url for all references
    $pano_url = get_site_url() . "/wp-content/panos/" . $pano_id . "/";

    // Start looping through the objects and fixing all reference urls
    $include_attribute = 'url';
    foreach ($xml_object->include as $node) {
            foreach ($node->attributes() as $key => $value) {

                    // Make sure we are only editing the thumburl
                    if ($key === $include_attribute){
                            $old_url = $value;
                            $node->attributes()->$key = str_replace("%FIRSTXML%/", "", $pano_url . $old_url);
                    }
            }
    }
    
    // Fix the layers
    if ($xml_object->layer != null){
        foreach ($xml_object->layer as $layer) {
            
            if ($layer->attributes()->name != "skin_logo"){
                $old_asset_url = $layer->attributes()->url;
                $layer->attributes()->url = $pano_url . $old_asset_url;
            }
        }
    }

    // Fix the scenes
    $scene_attribute =   'thumburl';
    $url_attribute   =   'url';

    foreach ($xml_object->scene as $node) {
        foreach ($node->attributes() as $key => $value) {

            // Make sure we are only editing the thumburl
            if ($key === $scene_attribute){
                $old_url = $value;
                $node->attributes()->$key = str_replace("%FIRSTXML%/", "", $pano_url . $old_url);
            }
        }

        // Fix the previews
        if ($node->preview != null){
            foreach ($node->preview as $preview) {
                $old_url = $preview->attributes()->url;
                $preview->attributes()->url = str_replace("%FIRSTXML%/", "", $pano_url . $old_url);
            }
        }

        // Fix the images
        if ($node->image != null){
            foreach ($node->image as $image) {

                    // Loop through the children
                    foreach ($image->children() as $child) {
                        foreach ($child->attributes() as $key => $value){

                            // If the child has a URL element, update it
                            if ($key === $url_attribute){
                                $new_c_url = $pano_url . $value;
                                $child->attributes()->$key = $new_c_url;
                            }
                        }
                    }
                    error_reporting(E_ALL ^ E_WARNING);
                    // Fix all image references
                    if ($image->level != null){
                        foreach ($image->level as $level) {
                            if ($level->cube != null){
                                $old_url = $level->cube->attributes()->url;
                                $level->cube->attributes()->url = $pano_url . $old_url;
                            }

                            if ($level->front != null){
                                $new_front_url = $pano_url . $level->front->attributes()->url;
                                $level->front->attributes()->url = $new_front_url;
                            }

                            if ($level->back != null){
                                $new_back_url = $pano_url . $level->back->attributes()->url;
                                $level->back->attributes()->url = $new_back_url;
                            }

                            if ($level->right != null){
                                $new_right_url = $pano_url . $level->right->attributes()->url;
                                $level->right->attributes()->url = $new_right_url;
                            }

                            if ($level->left != null){
                                $new_left_url = $pano_url . $level->left->attributes()->url;
                                $level->left->attributes()->url = $new_left_url;
                            }

                            if ($level->up != null){
                                $new_up_url = $pano_url . $level->up->attributes()->url;
                                $level->up->attributes()->url = $new_up_url;
                            }

                            if ($level->down != null){
                                $new_down_url = $pano_url . $level->down->attributes()->url;
                                $level->down->attributes()->url = $new_down_url;
                            }
                        }
                    }

                if ($image->mobile != null){
                    foreach ($image->mobile as $mobile){
                        $old_url = $mobile->cube->attributes()->url;
                        $mobile->cube->attributes()->url = $pano_url . $old_url;
                    }
                }
            }
        }
    }

    // print_r($xml_object);
    // die();	

    return $xml_object;
}

function add_pano_hotspots($xml_object, $quest, $pano_id){
    
    // Base url for all references
    $pano_url = get_site_url() . "/wp-content/panos/" . $pano_id . "/";
    
    // get all the hotspots
    $hotspots = get_current_pano_hotspots($quest);
    $actions  = get_current_hotspot_actions($quest);

    // Fix all the references
    foreach ($hotspots as $hs){
        if ($hs->attributes()->alturl != null){
            $old_alt_url = $hs->attributes()->alturl;
            $hs->attributes()->alturl = $pano_url . $old_alt_url;
        }

        if ($hs->attributes()->url != null){
            $old_url     = $hs->attributes()->url;
            $hs->attributes()->url = $pano_url . $old_url;
        }
    }

    // Turn the simple xml objects into dom objects and add the nodes
    $main_dom = dom_import_simplexml($xml_object);
    
    $dom = new DOMDocument('1.0');
    $new = $dom->importNode($main_dom, true);
    $dom_sxe = $dom->appendChild($new);
    
    // Get the child node of scene
    $scene = $dom->getElementsByTagName('scene')->item(0);
    $first_action = $dom->getElementsByTagName('action')->item(0);
    // Loop through and append the hotspots as dom objects
    foreach ($hotspots as $hs) {
        $new_dom = dom_import_simplexml($hs);
        $new = $dom->importNode($new_dom, true);
        $scene->appendChild($new);
    }
    
    // Add the actions
    foreach ($actions as $action){
        $new_dom = dom_import_simplexml($action);
        $new = $dom->importNode($new_dom, true);
        $dom->documentElement->insertBefore($new, $first_action);
        // $pano->appendChild($new);
        // ->insertBefore
    }
    
    // Give the dom back
    return $dom;
}

// Return an array of XML objects to add the hot spot nodes from the database
function get_current_pano_hotspots($quest){
    // Get the appropriate hotspots to add to the pano
    $hotspot_ids    = array();
    $hotspots       = array();
    $hotspot_xml_objects = array();
    $missions_array = array();
    
    // Get the missions
    if ($quest->exists){
        
        $missions = $quest->get_missions();

        foreach ($missions as $mission) {
            array_push($missions_array,$mission->id);
        }

        foreach ($missions_array as $mission_id) {
            $current_mission = new mission($mission_id);

            // Get the hotspot ids from the current mission, add them to the array
            $current_hotspots = $current_mission->get_hotspots();

            foreach ($current_hotspots as $ch) {
                array_push($hotspot_ids,$ch->id);
            }
        }

        foreach ($hotspot_ids as $hid) {
            $new_hotspot = new hotspot($hid);
            array_push($hotspots, $new_hotspot);
        }

        // Turn the xml from each of the hotspots into an xml object
        foreach ($hotspots as $xml){
            $new_xml_obj = simplexml_load_string($xml->get_xml());
            array_push($hotspot_xml_objects, $new_xml_obj);
        }
    
    }
    
    return $hotspot_xml_objects;
}

function get_current_hotspot_actions($quest){
    // Get the appropriate hotspots to add to the pano
    $hotspot_ids    = array();
    $hotspots       = array();
    $hotspot_xml_objects = array();
    $missions_array = array();
    
    // Get the missions
    if ($quest->exists){
        
        $missions = $quest->get_missions();

        foreach ($missions as $mission) {
            array_push($missions_array,$mission->id);
        }

        foreach ($missions_array as $mission_id) {
            $current_mission = new mission($mission_id);

            // Get the hotspot ids from the current mission, add them to the array
            $current_hotspots = $current_mission->get_hotspots();

            foreach ($current_hotspots as $ch) {
                array_push($hotspot_ids,$ch->id);
            }
        }

        foreach ($hotspot_ids as $hid) {
            $new_hotspot = new hotspot($hid);
            array_push($hotspots, $new_hotspot);
        }

        // Turn the xml from each of the hotspots into an xml object
        foreach ($hotspots as $xml){
            $new_xml_obj = simplexml_load_string($xml->get_action_xml());
            array_push($hotspot_xml_objects, $new_xml_obj);
        }
    
    }
    
    return $hotspot_xml_objects;
}

// Reusable code to make fixing nodes cleaner
function fix_node_url($node, $url){

        $fixed_node = $node;

        return $fixed_node;
}

function add_node(){

}