<?php
define('DB_HOST','10.132.18.49');
define('DB_USER','dev1_usr');
define('DB_PASS','bsd_dev_2015');
define('DB_NAME','dev1');

require_once('../../../../../wp-config.php');
require_once('../../../../../wp-includes/wp-db.php');
require_once('../../../../../wp-includes/pluggable.php');

function database_connection()
{
    return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

function get_pano_description(){
    global $wpdb;
    $pano_table_name = get_pano_table_name();
    $text_table_name = get_pano_text_table_name();
    $language_code = get_user_language();
    //$pano_id = get_current_pano_id();

    $url = $_SERVER['HTTP_REFERER'];
    $parts = explode('?pano_id=', $url);
    $pano_id = $parts[1];

    if ($pano_id == NULL){
        $pano_id = 1;
    }

    // DB query joining the pano table and the pano text table
    $panos = $wpdb->get_results(
        "SELECT wppt.description FROM " . $pano_table_name . " wpp " .
        "INNER JOIN " . $text_table_name . " wppt ON " .
        "wppt.pano_id = " . "'" . $pano_id . "'" .
        "WHERE wppt.language_code = " . $language_code, ARRAY_A);

    return $panos;
}

$pano_desc = get_pano_description();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./pano_info.css">
</head>
<body>
<div id="wrapper">
    <h1><?= $pano_desc[0]['description'] ?></h1>
</div>
</body>
</html>