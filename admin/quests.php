<?php

// Build the settings page
function pano_quest_settings_page() {
  $semantic = WP_PLUGIN_URL . '/mapply/css/semantic.css';
  $quests = get_quests();
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
    
    <table>
      <?php foreach ($quests as $quest): ?>
        <?php if ($quest): ?>

            <tr>
                <?php print_r($quest); ?>
            </tr>


        <?php else : ?>
            <tr><td>No quests yet!</td></tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </table>

    <?php submit_button(); ?>

</form>
</div>

<?php }