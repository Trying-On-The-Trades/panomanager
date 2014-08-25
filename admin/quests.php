<?php

// Build the settings page
function pano_quest_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $quests = get_quests();
?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your quests!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="admin_post_pano" />
    
    <table>
      <?php foreach ($quests as $quest): ?>
        <tr>
            <?php print_r($quest); ?>
        </tr>
      <?php endforeach; ?>
    </table>

    <?php submit_button(); ?>

</form>
</div>

<?php }