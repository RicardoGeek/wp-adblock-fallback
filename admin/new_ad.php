<?php
  $countries = get_countries();
?>

<div class="wrap">
  <h1 class="wp-heading-inline">New Ad Zone</h1>  
  <hr class="wp-header-end">
  <div class="card">
    <div class="form-group">
      Target Country:<br/><br/>
      <select id="ad-country-select" class="form-control">
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
      <input type="text" class="form-control" id="ad-size" />
    </div>
    <div class="form-group">
      Banner Link:<br/><br/>
      <textarea class="form-control" id="ad-banner-link"></textarea>
    </div>
    <div class="form-group">
      Ad Link:<br/><br/>
      <textarea class="form-control" id="ad-link"></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" id="save-ad-zone">Save Ad Zone</button>
    </div>
  </div>
</div>