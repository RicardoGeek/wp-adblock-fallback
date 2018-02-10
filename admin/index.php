<?php
  $zones = get_ad_zones();
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Wp AdBlock Settings</h1>  
  <a href="<?php menu_page_url('wp_adblock_fallback_new_ad'); ?>" class="page-title-action">Add New</a>
  <hr class="wp-header-end">
  <br/>
  <code>
    Remember:<br/>
    in code: do_shortcode('[monetize size="200x200"]');<br/>
    in post: [monetize size="200x200"]<br/>
    Where 200x200 is the size<br/>
  </code>
  <br/>
  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <th scope="col" id="id" class="manage-column">ID</th>
        <th scope="col" id="Banner" class="manage-column">Banner</th>
        <th scope="col" id="Link" class="manage-column">Link</th>
        <th scope="col" id="country" class="manage-column">Country</th>
        <th scope="col" id="Size" class="manage-column">Size</th>
        <th scope="col" id="Size" class="manage-column">Action</th>
      </tr>
    </thead>
	  <tbody id="the-list">
      <?php
        foreach($zones as $zone) {
          ?>
          <tr>
              <td><?php echo $zone->id; ?></td>
              <td><?php echo $zone->banner; ?></td>
              <td><?php echo $zone->link ?></td>
              <td><?php echo $zone->countryId ?></td>
              <td><?php echo $zone->size ?></td>
              <td>
                <button class="btn btn-primary btn-sm btn-edit-zone" data-id="<?php echo $zone->id; ?>">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
                <button class="btn btn-danger btn-sm btn-delete-zone" data-id="<?php echo $zone->id; ?>">
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
              </td>
          </tr>
          <?php
        }
      ?>
		</tbody>
  </table>
</div>