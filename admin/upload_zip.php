<?php

// Build the settings page
function upload_zip_settings_page() {
    $semantic   = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $view_panos = get_admin_url() . 'admin.php?page=pano_menu';

    $id = null;
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET['id'];
    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new pano!</h2>
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
<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_pano" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	        <label for="zip_file">Choose a zip file to upload: </label>
	      </div>
	    </div>
	    <ul id="filelist"></ul>
        <br />

        <div id="container">
            <a id="browse" href="javascript:;">[Browse...]</a>
            <a id="start-upload" href="javascript:;">[Start Upload]</a>
        </div>
	</div>
</form>

<div>
    <a id="view_pano" class="ui blue icon button redirect" href="<?php echo $view_panos ?>" style="padding: 7px; margin-top: 7px;">Save Changes</a>
</div>


<script>
    jQuery(document).ready(function(){
        var uploader = new plupload.Uploader({
            browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
            url: '<?php echo get_admin_url(); ?>admin-post.php?action=upload_zip&id=<?php echo $id ?>',
            chunk_size: '200kb',
            max_retries: 3
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            var html = '';
            plupload.each(files, function(file) {
                html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
            });
            jQuery('#filelist').html(html);
        });

        uploader.bind('UploadProgress', function(up, file) {
            jQuery("#" + file.id).find('b').html('<span>' + file.percent + "%</span>");

            if(file.percent == 100){
                setTimeout(function() {
                    jQuery(".redirect").removeClass("disabled");
                }, 5000);
            }
        });

        uploader.bind('ChunkUploaded', function(up, file, info) {
            console.log( "Chunk uploaded.", info.offset, "of", info.total, "bytes." );
        });

        uploader.bind('Error', function(up, err) {
            jQuery('#console').html("\nError #" + err.code + ": " + err.message);
        });

        jQuery('#start-upload').click(function() {
            uploader.start();
            jQuery(".redirect").addClass("disabled");
        });

    });
</script>

<?php }