<?php
   define('DB_HOST','10.132.18.49');
    define('DB_USER','dev1_usr');
    define('DB_PASS','bsd_dev_2015');
    define('DB_NAME','dev1');

function database_connection()
{
    return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}


function get_missions($db, $pano_id){

    $pano_text_table_name    = 'wp_pano_text';
    $mission_table_name      = 'wp_pano_mission';
    $mission_text_table_name = 'wp_pano_mission_text';
    $missions = array();



    $rows = $db->query(
        "SELECT wpm.id as mission_id, wpm.quest_id, wpm.points, wpm.mission_xml, wpmt.*, wpt.name as pano_name
        FROM wp_pano_mission wpm
        INNER JOIN wp_pano_mission_text wpmt ON wpmt.mission_id = wpm.id
        INNER JOIN wp_pano_text wpt ON wpt.id = wpm.pano_id
        WHERE wpm.pano_id =" . $pano_id);


    while($row = $rows->fetch_object())
    {
        array_push($missions, array('id' => $row->id,'quest_id' => $row->quest_id,
            'points' => $row->points, 'mission_xml' => $row->mission_xml, 'name' => $row->name));
    }

    // Return
    return $missions;
}

function get_domains($db){
    $domains = array();
    $domain_table_name = 'wp_pano_domains';

    // Get the schools out of the database
    $rows = $db->query(
        "SELECT * FROM " . $domain_table_name . " wpt ");

    while($row = $rows->fetch_object())
    {
        array_push($domains, array('id' => $row->id,'name' => $row->name));
    }

    return $domains;
}

function get_all_game_words($db, $deck_id){

    $word_table_name = 'wp_wordpleh_dictionary';
    $deck_word_table_name = 'wp_worpleh_deck_words';
    $deck_table_name = 'wp_wordpleh_deck';
    $final = array();

    $rows = $db->query(
        "SELECT wdic.word, wdic.description, wdic.points, wdic.audio, wdic.image
              FROM {$word_table_name} wdic
              INNER JOIN {$deck_word_table_name} wdecw
              ON wdic.id = wdecw.dictionary_id
              INNER JOIN {$deck_table_name} wdec
              ON wdec.id = wdecw.deck_id
              WHERE wdec.id = {$deck_id}");

    while($row = $rows->fetch_object())
    {
        array_push($final, array('word' => $row->word,'description' => $row->description,
            'points' => $row->points, 'audio' => $row->audio, 'image' => $row->image));
    }

    return $final;
}

function get_deck_type($db, $deck_id){

    $deck_table_name = 'wp_wordpleh_deck';
    $final = "";

    $rows = $db->query(
        "SELECT game_type FROM {$deck_table_name}
        WHERE id = $deck_id");

    while($row = $rows->fetch_object())
    {
        $final = $row->game_type;
    }

    return $final;
}

?>
