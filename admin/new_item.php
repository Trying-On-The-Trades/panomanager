<?php

function new_item_settings_page(){
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';

    $item_types = get_item_types();
    ?>
    <link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
    <h2>Create an item!</h2>
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
        <input type="hidden" name="action" value="create_new_item"/>
        <div class="ui form segment new_item_form">
            <div class="ui form ">
                <div class="field">
                    <div class="ui left labeled icon input">
                        <label for="name">Item Name</label>
                        <input name="item_name" id="name" placeholder="Name" required/>
                    </div>
                </div>
            </div>
            <div class="ui form ">
                <div class="field">
                    <div class="ui left labeled icon input">
                        <label for="description">Item Descriptioon</label>
                        <input name="item_description" id=description" placeholder="Description" required />
                    </div>
                </div>
            </div>
            <div class="ui form">
                <div class="field">
                    <div class="ui left labeled icon input">
                        <label for="image">Choose an image <b>(Preferably 120x120)</b></label>
                        <input type="file" name="item_image" id="image"  />
                    </div>
                </div>
            </div>
            <div class="ui form ">
                <div class="field">
                    <div class="ui left labeled icon input">
                        <label for="price">Item Price</label>
                        <input name="item_price" id="price" placeholder="Price" />
                    </div>
                </div>
            </div>
            <div class="ui form">
                <div class="field">
                    <label>Select an item type</label>
                    <select name="item_type_id">
                        <option value="NA">...</option>
                        <?php foreach($item_types as $item_type): ?>
                            <option value="<?php echo $item_type->id ?>"><?php echo $item_type->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php submit_button(); ?>
        </div>
    </form>
<?php }