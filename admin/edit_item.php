<?php

function edit_item_settings_page(){
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $item = null;

    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $item = build_item($_GET['id']);
    }

    $item_types = get_item_types();
?>
<link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
<h2>Edit your item!</h2>
<hr>
<style type="text/css">
    #wpfooter{
        display: none;
    }

    #file_input {
        border: 1px solid #cccccc;
        padding: 5px;
    }

    .new_pano_form{
        width:85%;
        margin: 0px auto;
    }
</style>
<?php if ( isset ( $_GET['settings-saved'] ) ): ?>
    <div class="updated"><p>Item updated successfully.</p></div>
<?php elseif ( isset ( $_GET['error'] ) ): ?>
    <div class="error"><p>Error updating item.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?= get_admin_url() . 'admin-post.php' ?>" >
    <input type="hidden" name="action" value="edit_item"/>
    <input type="hidden" name="item_id" value="<?= $item->get_id() ?>"/>
    <div class="ui form segment new_item_form">
        <div class="ui form ">
            <div class="field">
                <div class="ui left labeled icon input">
                    <label>Item Name</label>
                    <input name="item_name" id="name" placeholder="Name" value="<?= $item->get_name(); ?>" required/>
                </div>
            </div>
        </div>
        <div class="ui form ">
            <div class="field">
                <div class="ui left labeled icon input">
                    <label>Item Info</label>
                    <input name="item_description" id="description" placeholder="Description" value="<?= $item->get_description(); ?>" required />
                </div>
            </div>
        </div>
        <div class="ui form">
            <div class="field">
                <div class="ui left labeled icon input">
                    <label for="image">Choose an image: <b>(Preferably 120x120)</b> </label>
                    <img class="item_image" src="<?= content_url().'/'.$item->get_image() ?>" alt="Image"/>
                    <input type="file" name="item_image" id="image"  />
                </div>
            </div>
        </div>
        <div class="ui form ">
            <div class="field">
                <div class="ui left labeled icon input">
                    <label>Item Price</label>
                    <input name="item_price" id="price" placeholder="Price" value="<?= $item->get_price(); ?>"/>
                </div>
            </div>
        </div>
        <div class="ui form">
            <div class="field">
                <label>Select an item type</label>
                <select name="item_type_id">
                    <option value="NA">...</option>
                    <?php foreach($item_types as $item_type): ?>
                        <option value="<?php echo $item_type->id ?>" <?php echo ($item_type->id === $item->get_type_id()) ? "selected" : "" ?>><?php echo $item_type->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php submit_button(); ?>
    </div>
</form>
<?php }
