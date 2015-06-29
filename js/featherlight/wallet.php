<?php
    define('DB_HOST','localhost');
   define('DB_USER','root');
   define('DB_PASS','root');
   define('DB_NAME','wordpress');

   $currency_class = 'pos';

   function database_connection()
   {
       return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   }

   function get_currency_available($user_id){
       $db = database_connection();
       $result = $db->query("SELECT available_currency FROM wp_pano_wallet WHERE user_id = {$user_id} LIMIT 1");
       $final = $result->fetch_assoc();
       return $final['available_currency'];
   }

   function get_currency_symbol($user_id){
       $db = database_connection();
       $result = $db->query("SELECT symbol FROM wp_points_info WHERE id = {$user_id} LIMIT 1");
       $final = $result->fetch_assoc();
       return $final['symbol'];
   }

   $x =  get_currency_available(1);

   if($x < 0){
     $currency_class = 'neg';
   }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./wallet.css">
  </head>
  <body>
    <div id="wrapper">
      <h1>Wallet</h1>
      <h2>Your current balance is:</h2>
      <img src="./wallet-icon.png" alt="wallet icon" />
      <p class="<?= $currency_class ?>"><?= get_currency_symbol(1) ?> <?= get_currency_available(1) ?></p>
    </div>
  </body>
</html>
