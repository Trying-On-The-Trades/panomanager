<?php

// Build the settings page
function pano_settings_page() {
  $semantic = WP_PLUGIN_URL . '/mapply/css/semantic.css';
  $panos = get_panos();

  // New pano url
  $new_pano_url = WP_PLUGIN_URL . "/panomanager/admin/new_pano.php";
?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Welcome to pano manager!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="admin_post_pano" />
    
    <!-- Create new pano button -->
    <a class="button" href="<?php echo $new_pano_url; ?>">New Pano</a>

    <table>
      <?php foreach ($panos as $pano): ?>
        <?php if ($pano): ?>

            <tr>
                <?php print_r($pano); ?>
            </tr>


        <?php else : ?>
            <tr><td>No panos yet!</td></tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </table>

    <?php submit_button(); ?>

</form>
</div>

<?php }
