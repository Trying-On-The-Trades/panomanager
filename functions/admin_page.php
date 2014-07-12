<?php

// Build the settings page
function panno_settings_page() {
  $semantic = WP_PLUGIN_URL . '/mapply/css/semantic.css';
  $pannos = get_pannos();
?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Welcome to panno manager!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form method="post" action="admin-post.php">

    <!-- panno processing hook -->
    <input type="hidden" name="action" value="admin_post_panno" />
    
    <table>
      <?php foreach ($pannos as $panno): ?>
        <?php if ($panno): ?>

            <tr>
                print_r($panno);
            </tr>


        <?php else : ?>
            <tr><td>No pannos yet!</td></tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </table>

    <?php submit_button(); ?>

</form>
</div>

<?php }
