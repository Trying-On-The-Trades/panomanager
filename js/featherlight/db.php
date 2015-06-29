<?php
	define('DB_HOST','10.132.18.49');
    define('DB_USER','dev1_usr');
    define('DB_PASS','bsd_dev_2015');
    define('DB_NAME','dev1');

    function database_connection()
    {
    	return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    function get_hatpleh_words($db, $deck_id)
    {
        $word_table_name = 'wp_wordpleh_dictionary';
        $deck_word_table_name = 'wp_worpleh_deck_words';
        $deck_table_name = 'wp_wordpleh_deck';
        $final = array();

        $rows = $db->query(
            "SELECT wdic.word, wdic.description, wdic.points, wdec.name, wdec.image
              FROM {$word_table_name} wdic
              INNER JOIN {$deck_word_table_name} wdecw
              ON wdic.id = wdecw.dictionary_id
              INNER JOIN {$deck_table_name} wdec
              ON wdec.id = wdecw.deck_id
              WHERE wdec.id = {$deck_id}");

        while($row = $rows->fetch_object())
        {
            array_push($final, array('word' => $row->word,'description' => $row->description, 
                'points' => $row->points, 'name' => $row->name, 'image' => $row->image));
        }

        return $final;
    }

    function get_points_symbol($db){

        $deck_table_name = 'wp_points_info';
        $final = "";

        $rows = $db->query(
            "SELECT symbol FROM {$deck_table_name}
              WHERE id = 1");

        while($row = $rows->fetch_object())
        {
            $final = $row->symbol;
        }

        return $final;
    }

?>