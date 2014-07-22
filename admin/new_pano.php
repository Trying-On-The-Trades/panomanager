<?php

// Build the settings page
function new_pano_settings_page() {
	$semantic = WP_PLUGIN_URL . '/mapply/css/semantic.css';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Welcome to pano manager!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_pano" />
    
    <table>
      	<tr>
      		<td>New Pano</td>
      	</tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php }