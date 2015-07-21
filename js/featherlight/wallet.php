<?php
define('DB_HOST','10.132.18.49');
define('DB_USER','dev1_usr');
define('DB_PASS','bsd_dev_2015');
define('DB_NAME','dev1');

$currency_class = 'pos';

// $user = get_current_user();
// $user = $user->ID;

require_once('../../../../../wp-config.php');
require_once('../../../../../wp-includes/wp-db.php');
require_once('../../../../../wp-includes/pluggable.php');

$user = wp_get_current_user()->ID;

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

function get_currency_symbol(){
    $db = database_connection();
    $result = $db->query("SELECT symbol FROM wp_points_info WHERE id = 1 LIMIT 1");
    $final = $result->fetch_assoc();
    return $final['symbol'];
}

$x =  get_currency_available($user);

if($x < 0){
    $currency_class = 'neg';
}

$symbol = get_currency_symbol();
$currency = get_currency_available($user);
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
    <p class="<?= $currency_class ?>"><?= $symbol ?> <?= $currency ?></p>
    <p id="history" style="cursor: pointer;" onclick="window.location.replace('purchases.php');">View Purchase History</p>
</div>
</body>
</html>
