<?php
  $zones = get_ad_zones();
	$countries = get_countries();
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
    	Where 200x200 is the size
  	</code>
		<br/><br/>
		<table class="wp-list-table widefat fixed striped posts" id="zones-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Banner</th>
					<th>Link</th>
					<th>Country</th>
					<th>Impressions</th>
					<th>Clicks</th>
					<th>Size</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
        foreach($zones as $zone) {
          ?>
					<tr>
						<td>
							<?php echo $zone->id; ?>
						</td>
						<td>
							<?php echo $zone->banner; ?>
						</td>
						<td>
							<?php echo $zone->link ?>
						</td>
						<td>
							<?php echo $zone->countryId ?>
						</td>
						<td>
							<?php echo get_ad_impressions($zone->id);  ?>
						</td>
						<td>
							<?php echo get_clicks($zone->id);  ?>
						</td>
						<td>
							<?php echo $zone->size ?>
						</td>
						<td>
							<button data-remodal-target="modal" class="btn btn-primary btn-sm btn-edit-zone" data-id="<?php echo $zone->id; ?>">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
							<button class="btn btn-danger btn-sm" data-id="<?php echo $zone->id; ?>">
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
						</td>
					</tr>
					<?php
        }
      ?>
			</tbody>
		</table>


		<div class="remodal" data-remodal-id="modal">
			<button data-remodal-action="close" class="remodal-close"></button>
			<input type="hidden" id="edit-zone-id" />
			<div class="form-group">
				Target Country:<br/><br/>
				<select id="edit-ad-country-select" class="form-control">
        <option value="">-- SELECT ONE --</option>
        <option value="default">Any Country</option>
        <?php
          foreach($countries as $country) {
            echo "<option value='$country'>$country</option>";
          }
        ?>
      </select>
			</div>
			<div class="form-group">
				Size:<br/><br/>
				<input type="text" class="form-control" id="edit-ad-size" />
			</div>
			<div class="form-group">
				Banner Link:<br/><br/>
				<textarea class="form-control" id="edit-ad-banner-link"></textarea>
			</div>
			<div class="form-group">
				Ad Link:<br/><br/>
				<textarea class="form-control" id="edit-ad-link"></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-primary" id="save-zone-edits">
					Save Changes
				</button>
			</div>
		</div>
	</div>