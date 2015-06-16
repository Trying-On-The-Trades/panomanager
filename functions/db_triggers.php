<?php

function trigger_points_to_wallet(){
  global $wpdb;
  $hotspost_table_name = get_hotspot_table_name();
  $points_table_name = get_user_skill_progress_table_name();
  $wallet_table_name = get_wallet_table_name();

  $sql = "DELIMITER //
  CREATE OR REPLACE TRIGGER PointsWallet
  AFTER INSERT ON $points_table_name
  FOR EACH ROW
  BEGIN
    DECLARE points AS INT(10);
    SELECT points INTO points FROM $hotspost_table_name
      WHERE id = :NEW.skill_id;
    UPDATE $wallet_table_name
    SET available_currency = available_currency + points
    WHERE(user_id = :NEW.user_id);
  END;
  DELIMITER ;";

  return $sql;
}

function trigger_bonus_points_to_wallet(){
  global $wpdb;
  $bonus_points_table_name = get_user_skill_bonus_pts_table_name();
  $wallet_table_name = get_wallet_table_name();

  $sql = "DELIMITER //
  CREATE OR REPLACE TRIGGER BonusPointsWallet
  AFTER INSERT ON $bonus_points_table_name
  FOR EACH ROW
  BEGIN
    UPDATE $wallet_table_name
    SET available_currency = available_currency + :NEW.bonus_points
    WHERE (user_id = :NEW.user_id);
  END;
  DELIMITER ;";

  return $sql;
}
