<?php

function regular_points_to_wallet($user_id, $skill_id){
  global $wpdb;

  $hotspost_table_name = get_hotspot_table_name();
  $points_table_name = get_user_skill_progress_table_name();
  $wallet_table_name = get_wallet_table_name();

  check_create_new_wallet($user_id);

  $currency = $wpdb->get_var("SELECT points FROM {$hotspost_table_name}
      WHERE id = {$skill_id}");

  $total = $wpdb->get_var("SELECT available_currency FROM {$wallet_table_name} WHERE user_id = {$user_id}");
  $total += $currency;

  $wpdb->update($wallet_table_name, array('available_currency' => $total), array('user_id' => $user_id));
}

//   $sql = "DELIMITER $$
//   CREATE TRIGGER PointsWallet
//   AFTER INSERT ON $points_table_name
//   FOR EACH ROW
//   BEGIN
//     DECLARE currency INT(10);
//     CALL CheckCreateWallet(NEW.user_id);
//     SELECT points INTO currency FROM $hotspost_table_name
//       WHERE id = NEW.skill_id;
//     UPDATE $wallet_table_name
//     SET available_currency = available_currency + currency
//     WHERE(user_id = NEW.user_id);
//   END;
//   $$";

//   return $sql;
// }

function bonus_points_to_wallet($user_id, $points){
  global $wpdb;
  $wallet_table_name = get_wallet_table_name();

  check_create_new_wallet($user_id);

  $total = $wpdb->get_var("SELECT available_currency FROM {$wallet_table_name} WHERE user_id = {$user_id}");
  $total += $points;

  $wpdb->update($wallet_table_name, array('available_currency' => $total), array('user_id' => $user_id));
}

//   $sql = "DELIMITER $$
//   CREATE TRIGGER BonusPointsWallet
//   AFTER INSERT ON $bonus_points_table_name
//   FOR EACH ROW
//   BEGIN
//     CALL CheckCreateWallet(NEW.user_id);
//     UPDATE $wallet_table_name
//     SET available_currency = available_currency + NEW.bonus_points
//     WHERE (user_id = NEW.user_id);
//   END;
//   $$";

//   return $sql;
// }

function check_create_new_wallet($user_id){

 global $wpdb;
 $wallet_table_name = get_wallet_table_name();
 $points_initial_bonus_table_name = get_points_initial_bonus_table_name();

 $flag = $wpdb->get_var("SELECT COUNT(*) FROM {$wallet_table_name} WHERE user_id = {$user_id}");
 if($flag === '0'){
   $currency_qty = $wpdb->get_var("SELECT quantity FROM {$points_initial_bonus_table_name} WHERE id = 1");
   $wpdb->insert($wallet_table_name, array('user_id' => $user_id, 'available_currency' => $currency_qty),
       array('%d', '%d'));
 }


}

//   $sql = "DELIMITER $$
//   CREATE PROCEDURE CheckCreateWallet( IN user_id_to_check INT )
//   BEGIN
//     DECLARE flag INT;
//     DECLARE currency_qty INT;
//     SELECT 1 INTO flag FROM {$wallet_table_name} WHERE user_id = user_id_to_check;
//     IF(flag IS NULL) THEN
//       SELECT quantity INTO currency_qty FROM {$points_initial_bonus_table_name};
//       INSERT INTO {$wallet_table_name} (user_id, available_currency) VALUES (user_id_to_check, currency_qty);
//     END IF;
//   END;
//   $$";

//   return $sql;
// }
