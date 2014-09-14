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
        $fixed_xml_object = fix_references($pano_id, $pano_xml_obj, $quest);

        // turn object back into XML
        $new_xml = $fixed_xml_object->asXML();

        // Output XML
        spit_out_xml($new_xml);
}

// Return the pano to the viewer
function spit_out_xml($xml){
        // We are returning xml
//        header('Content-Type: text/xml');

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
function fix_references($pano_id, $xml_object, $quest){

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
        
        //////////////////// HOTSPOTS
        
        if ($node->hotspot != null){
            foreach ($node->hotspot as $hotspot) {
                $old_alt_url = $hotspot->attributes()->alturl;
                $old_url     = $hotspot->attributes()->url;
                
                $hotspot->attributes()->alturl = $pano_url . $old_alt_url;
                $hotspot->attributes()->url = $pano_url . $old_url;
            }
        }
        
        //////////////////// HOTSPOTS

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

// Return an array of XML objects to add the hot spot nodes from the database
function get_pano_hotspots($quest){
    // Get the appropriate hotspots to add to the pano
    $hotspots = array();
    
//    $quest_mission = get_pano_quest_missions($quest->get_id());
    
    return $hotspots;
}

// Reusable code to make fixing nodes cleaner
function fix_node_url($node, $url){

        $fixed_node = $node;

        return $fixed_node;
}

function add_node(){

}