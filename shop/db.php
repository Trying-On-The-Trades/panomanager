<?php



require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once('../../../../wp-includes/pluggable.php');


//function get_points_symbol(){
//  $db = database_connection();
//  $points_symbol = $db->query("SELECT symbol FROM `wp_points_info` WHERE id = 1 LIMIT 1");
//  $final = $points_symbol->fetch_array();
//  return $final['symbol'];
//}
//

//function get_item($item_id){
//    $db = database_connection();
//    $item = $db->query("SELECT * FROM wp_pano_items WHERE id = " . $item_id . " LIMIT 1");
//    return $item->fetch_array();
//}
//
function get_currency_available(){
    global $wpdb;
    $user_id = wp_get_current_user()->ID;
    $result = $wpdb->get_var("SELECT available_currency FROM wp_pano_wallet WHERE user_id = " . $user_id . " LIMIT 1");

    return $result;
}
//
//function create_line_item($purchase_id, $item_id, $price){
//    $db = database_connection();
//    $db->insert('wp_pano_line_items', array('purchase_id' => $purchase_id, 'item_id' => $item_id, 'price' => $price));
//}
//
//function create_purchase($date, $user_id){
//    $db = database_connection();
//    $db->insert('wp_pano_purchases', array('date'=>$date, 'user_id' => $user_id));
//    return $db->insert_id;
//}
//
//function bonus_points_to_wallet($user_id, $points){
//  $db = database_connection();
//  $total = $db->get_var("SELECT available_currency FROM wp_pano_wallet WHERE user_id = " . $user_id);
//  $total -= $points;
//  $db->update('wp_pano_wallet', array('available_currency' => $total), array('user_id' => $user_id));
//
//}

function process_purchase($id, $price){
    $user_id = wp_get_current_user()->ID;
    $currency = get_currency_available();
    $date = date('Y-m-d H:i:s');
    //return $currency;
    if(intval($price) > intval($currency)){

        return false;
    } else {
        $purchase_id = create_purchase($date, $user_id);
        create_line_item($purchase_id, $id, $price);
        $cost = (intval($price) * 1);
        bonus_points_to_wallet($user_id, $cost);
        return true;
  }
}

?>
