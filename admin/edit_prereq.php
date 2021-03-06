<?php

// Build the settings page
function prereq_edit_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $domains   = get_domains();
  $items = get_items();
  $item_types = get_item_types();
  $prereq = null;
  $prereq_id = null;
  if(isset($_GET['pano_id']) && is_numeric($_GET['pano_id'])){
    $prereq = get_pano_prereq($_GET['pano_id']);
    $prereq_id = $prereq->id;
  }
  $prereq_items = get_prereq_items($prereq_id);
  $selected_items = array();
  foreach($prereq_items as $selected_item){
    array_push($selected_items, $selected_item->item_id);
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit your Prereqs!</h2>
<hr>

<form id="form" method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
  <!-- pano processing hook -->
  <input type="hidden" name="action" value="edit_prereq" />
  <input type="hidden" name="id" value="<?php echo $prereq->id ?>" />
  <input type="hidden" name="pano_id" value="<?php echo $prereq->pano_id ?>" />
  <div class="ui form segment new_prereq_form">
    <div class="ui form">
      <div class="field">
        <label for="prereq_pts">Prereq Points</label>
        <input type="number" name="prereq_pts" id="prereq_pts" placeholder="100" value="<?php echo $prereq->prereq_pts ?>"required />
      </div>
    </div>
    <input type="hidden" name="prereq_domain_id" value="NA" />
    <div class="ui form">
      <div class="field">
        <label for="prereq_desc">Prereq Info</label>
        <textarea name="prereq_desc" id="prereq_desc" required ><?php echo $prereq->prereq_desc ?></textarea>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="item_type">Filter by Item Type</label>
        <select name="item_type" id="item_type" class="ui dropdown">
          <option value="NA">All items</option>
          <?php foreach($item_types as $item_type): ?>
          <option value="<?= $item_type->id ?>"><?= $item_type->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Items<span id="item_limit"> - maximum of 5 items</span></label>
        <ul>
          <?php foreach($items as $item): ?>
            <?php if(in_array($item->id, $selected_items)): ?>
            <li class="games_form item <?= $item->type_id ?>">
              <input type="checkbox" id="<?= $item->id ?>" name="items[]" value="<?= $item->id ?>" checked>
              <label for="<?= $item->id ?>"><?= $item->name ?></label>
            </li>
            <?php else: ?>
            <li class="games_form item <?= $item->type_id ?>">
              <input type="checkbox" id="<?= $item->id ?>" name="items[]" value="<?= $item->id ?>">
              <label for="<?= $item->id ?>"><?= $item->name ?></label>
            </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php submit_button(); ?>
  </div>
</form>
<script type="text/javascript">
  // Hiding error message
  jQuery('#item_limit').hide();

  // Event listener
  jQuery('#item_type').change(function(){
    filterTypes();
  });
  jQuery(':checkbox').change(function(){
    restrictItems();
  });
  jQuery('#form').submit(function(e){
    if(!restrictItems()){
      e.preventDefault();
    }
  });

  // Filters items based on user selection of item type.
  function filterTypes(){
    if(jQuery('#item_type').val() == 'NA'){
      jQuery('.item').each(function(){
        jQuery(this).show();
      });
    } else {
      var typeId = jQuery('#item_type').val();
      jQuery('.item').each(function(){
        jQuery(this).hide();
      });
      jQuery('.item').each(function(){
        jQuery('.' + typeId).each(function(){
          jQuery(this).show();
        });
      });
    }
  }

  // Displays a message if user picks more than [qty] items.
  // Prevents form submission if user picks more than [qty] items.
  function restrictItems(){
    var qty = 5;
    var allowSend = false;
    if(jQuery(':checkbox:checked').length > qty){
      jQuery('#item_limit').show();
      jQuery('#item_limit').css({'color': 'red', 'font-weight': 'bold'});
      allowSend = false;
    } else {
      jQuery('#item_limit').hide();
      allowSend = true;
    }
    return allowSend;
  }
</script>
<?php }
