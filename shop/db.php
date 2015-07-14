<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'wordpress');
define('DB_PASS', 'wordpress');
define('DB_NAME', 'wordpress');

function database_connection(){
  return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

function get_points_symbol(){
  $db = database_connection();
  $points_symbol = $db->query("SELECT symbol FROM `wp_points_info` WHERE id = 1 LIMIT 1");
  $final = $points_symbol->fetch_array();
  return $final['symbol'];
}

function get_item($item_id){
    $db = database_connection();
    $item = $db->query("SELECT * FROM wp_pano_items WHERE id = " . $item_id . " LIMIT 1");
    return $item->fetch_array();
}

function create_line_item($purchase_id, $item_id, $price){
    $db = database_connection();
    $db->insert('wp_pano_line_items', array('purchase_id' => $purchase_id, 'item_id' => $item_id, 'price' => $price));
}

function create_purchase($date, $user_id){
    $db = database_connection();
    $db->insert('wp_pano_purchases', array('date'=>$date, 'user_id' => $user_id));

    return $db->insert_id;
}

?>
