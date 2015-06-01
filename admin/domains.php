<?php

// Build the settings page
function pano_domain_settings_page() {
    $domains = get_domains();

    $semantic       = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_domain_url  = admin_url() . "admin.php?page=new_domain_settings";
    $edit_domain_url = admin_url() . "admin.php?page=edit_domain_settings";
    ?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your missions!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
    <div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<h2>Domains</h2>
<table class="ui table segment">
  <tr>
    <th>Domain</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($domains as $domain): ?>

    <tr>
        <td><?php echo $domain->name ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_domain_url ?>&id=<?php echo $domain->id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_domain_form<?php echo $domain->id ?>">
                <!-- pano processing hook -->
                <input type="hidden" name="action" value="delete_domain" />
                <input type="hidden" name="domain_id" value="<?php echo $domain->id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

<?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_domain_url ?>" style="padding: 7px">New Domain</a>
</div>

<?php }