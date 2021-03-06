<?php

// Build the settings page
function prereq_new_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $domains   = get_domains();
  $items = get_items();
  $item_types = get_item_types();
  $pano_id = null;
  if(isset($_GET['pano_id']) && is_numeric($_GET['pano_id'])){
    $pano_id = $_GET['pano_id'];
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new Prereq!</h2>
<hr>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
  <!-- pano processing hook -->
  <input type="hidden" name="action" value="create_new_prereq" />
  <input type="hidden" name="pano_id" value="<?php echo $pano_id ?>" />
  <div class="ui form segment new_prereq_form">
    <div class="ui form">
      <div class="field">
        <div class="ui left labeled icon input">
          <label for="prereq_pts">Prereq Points</label>
          <input type="number" name="prereq_pts" id="prereq_pts" placeholder="100" required />
        </div>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="prereq_domain_id">Select a Prereq Domain</label>
        <select name="prereq_domain_id">
          <option value="NA">...</option>
          <?php foreach($domains as $domain): ?>
          <option value="<?php echo $domain->id ?>"><?php echo $domain->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="prereq_desc">Prereq Info</label>
        <textarea name="prereq_desc" id="prereq_desc"  required ></textarea>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="item_type">Filter by Item Type</label>
        <select name="item_type" id="item_type" class="ui dropdown">
          <option value="">All items</option>
          <?php foreach($item_types as $item_type): ?>
          <option value="<?= $item_type->id ?>"><?= $item_type->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Items</label>
        <ul>
          <?php foreach($items as $item): ?>
          <li class="games_form">
            <input type="checkbox" id="<?= $item->id ?>" name="items[]" value="<?= $item->id ?>">
            <label for="<?= $item->id ?>"><?= $item->name ?></label>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php submit_button(); ?>
  </div>
</form>
<?php }
