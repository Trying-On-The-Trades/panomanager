<?php

function view_purchase_settings_page(){
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $purchase = build_purchase($_GET['id']);
        $date = date( 'm/d/Y', strtotime( $purchase->get_date() ) );
        $items = get_purchase_items($_GET['id']);
        $total = get_purchase_total($_GET['id']);
    }

    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>
<link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
<style>
#wpfooter{
  display: none;
}
</style>
<p>User: <?= get_userdata($purchase->get_user_id())->user_nicename ?></p>
<p>Date: <?= $date ?></p>

<table class="ui table segment">
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Type</th>
</tr>
<?php foreach($items as $key => $item): ?>
    <tr>
        <th><?= $item->name ?></th>
        <th><?= $item->price ?></th>
        <th><?= get_item_type($item->type_id)->name ?></th>
    </tr>
<?php endforeach; ?>

<p>Total: <?= $total ?></p>
<?php }
