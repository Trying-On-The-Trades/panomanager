<?php
	define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','root');
    define('DB_NAME','wordpress');

    function database_connection()
    {
    	return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    function select_word($db, $id)
   {
       $query = "SELECT word, hint, image, profession FROM wp_pano_trade_type AS trade, wp_pano_terms ";
       $query .= "AS terms WHERE trade.id = terms.trade_id AND terms.id = {$id}";
       $result = $db->query($query);
       $row = $result->fetch_object(); 
       return $row;
   }
?>