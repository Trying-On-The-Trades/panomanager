<?php

function view_purchase_settings_page(){
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $purchase = build_purchase($_GET['id']);
        $items = get_purchase_items($_GET['id']);
        $total = get_purchase_total($_GET['id']);
    }
?>

<?php }
