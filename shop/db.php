<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'wordpress');
define('DB_PASS', 'wordpress');
define('DB_NAME', 'wordpress');

require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once('../../../../wp-includes/pluggable.php');

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

function get_currency_available($user_id){
    $db = database_connection();
    $result = $db->query("SELECT available_currency FROM wp_pano_wallet WHERE user_id = " . $user_id . " LIMIT 1");
    $final = $result->fetch_array();
    return $final['available_currency'];
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

function bonus_points_to_wallet($user_id, $points){
  $db = database_connection();
  $total = $db->get_var("SELECT available_currency FROM wp_pano_wallet WHERE user_id = " . $user_id);
  $total -= $points;
  $db->update('wp_pano_wallet', array('available_currency' => $total), array('user_id' => $user_id));

}

function process_purchase($id, $price){
    $user_id = wp_get_current_user()->ID;;
    $currency = get_currency_available($user_id);
    $date = date('Y-m-d H:i:s');
    if($price > $currency){
        return false;
    } else {
        $purchase_id = create_purchase($date, $user_id);
        create_line_item($purchase_id, $id, $price);
        bonus_points_to_wallet($user_id, $price);
        return true;
    }
}

?>
