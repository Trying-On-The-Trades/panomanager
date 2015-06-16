<?php

function trigger_points_to_wallet(){
  global $wpdb;
  $points_table_name = get_user_skill_progress_table_name();

  $sql = "CREATE OR REPLACE TRIGGER PointsWallet
  AFTER INSERT ON $points_table_name
  FOR EACH ROW
  BEGIN
    UPDATE Products
    SET QtyOnHand = QtyOnHand - :NEW.Qty
    WHERE(Mfr = :NEW.Mfr
      AND Product = :NEW.Product);
  END;
  /";

}

function trigger_bonus_points_to_wallet(){
  global $wpdb;
  $bonus_points_table_name = get_user_skill_bonus_pts_table_name();
  $wallet_table_name = get_wallet_table_name();

  $sql = "CREATE OR REPLACE TRIGGER BonusPointsWallet
  AFTER INSERT ON $bonus_points_table_name
  FOR EACH ROW
  BEGIN
    UPDATE $wallet_table_name
    SET available_quantity = available_quantity + :NEW.bonus_points
    WHERE(user_id = :NEW.user_id);
  END;
  /";

  return $sql;
}
