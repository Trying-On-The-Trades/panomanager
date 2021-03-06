<?php

// Build the settings page
function prereq_settings_page() {
    $semantic        = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_prereq_url  = admin_url() . "admin.php?page=prereq_new_setting";
    $edit_prereq_url = admin_url() . "admin.php?page=prereq_edit_setting";

    $pano_id = null;
    if(isset($_GET['pano_id']) && is_numeric($_GET['pano_id'])){
        $pano_id = $_GET['pano_id'];
    }

    $prereqs = get_pano_prereq($pano_id);
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
    <h2>Create a new prereq!</h2>
    <hr>
    <?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>
    <table class="ui table segment">
      <tr>
        <th>Prereq Points</th>
        <th>Prereq Domain</th>
        <th>Prereq Info</th>
        <th>Prereq Item Qty</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($prereqs as $prereq): ?>

            <?php $domain = get_domain($prereq->prereq_domain_id) ?>

            <tr>
                <td><?php echo $prereq->prereq_pts ?></td>
                <td><?php echo $domain->name ?></td>
                <td><?php echo $prereq->prereq_desc ?></td>
                <td><?php echo count(get_prereq_items($prereq->id)) ?></td>
                <td><a class="ui blue icon button" href="<?php echo $edit_prereq_url ?>&id=<?php echo $prereq->id ?>" style="padding: 7px">Edit</a></td>
                <td>
                    <form method="post" action="admin-post.php" id="delete_prereq_form<?php echo $prereq->id ?>">
                        <!-- pano processing hook -->
                        <input type="hidden" name="action" value="delete_prereq" />
                        <input type="hidden" name="pano_id" value="<?php echo $pano_id ?>" />
                        <input type="hidden" name="prereq_id" value="<?php echo $prereq->id ?>" />

                        <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
    <a class="ui blue icon button" href="<?php echo $new_prereq_url ?>&pano_id=<?php echo $pano_id ?>" style="padding: 7px">New Prereq</a>
    </div>

    <script>
        jQuery(document).ready(function(){
        });
    </script>

<?php }
