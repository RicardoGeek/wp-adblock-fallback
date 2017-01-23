<?php
  include("backend.php");
  global $wpdb;
?>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <div class="wrap">
    <h1>WP AdBlock FallBack Settings</h1>
    <hr/>
    <div class="row">
      <div clas="col-md-12">
        <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Custom Ad Units</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Ad Network Loaders</a></li>
            <li role="presentation"><a href="#assign" aria-controls="assign" role="tab" data-toggle="tab">Assign Fallback</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <div class="row">
                <div class="col-md-12">
                  <br/><br/>
                  <i>Ad units will rotate randomly according to size and placement</i>
                  <br/><br/>
                  <button id="show-new-add-unit" class="btn btn-primary" data-toggle="modal" data-target="#adUnitModal">Create Ad Unit</button>
                  <hr/>
                  <table class="table">
                    <tr>
                      <th>Banner</th>
                      <th>Link</th>
                      <th>Width</th>
                      <th>Height</th>
                      <th>Edit</th>
                      <tH>Delete</tH>
                    </tr>
                    <?php
                      $sql = "SELECT * FROM ".$wpdb->prefix."alternative_ads";
                      $rows =  $wpdb->get_results( $sql );

                      foreach($rows as $row) {
                        $url = plugins_url( 'wp-adblock-fallback/banners/'.$row->banner );
                        echo "<tr>";
                          echo "<td><img src='$url' width='$row->width' heigth='$row->height'  /></td>";
                          echo "<td>$row->src</td>";
                          echo "<td>$row->width</td>";
                          echo "<td>$row->height</td>";
                          echo "<td><a data-id='$row->id' class='edit-alt-ad'>Edit</a></td>";
                          echo "<td><a data-id='$row->id' class='delete-alt-ad'>Delete</a></td>";
                        echo "</tr>";
                      }
                    ?>
                  </table>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
               <br/><br/>
               <i>Save your ad scripts here</i>
               <br/><br/>
               <button id="show-new-add-unit" class="btn btn-primary" data-toggle="modal" data-target="#AdLoaderModal">Create Ad Script</button>
               <hr/>
               <table class="table">
                 <tr>
                  <th>Script Name</th>
                  <th>View</th>
                   <th>Edit</th>
                  <th>Delete</th>
                 </tr>
                 <?php
                    $sql = "SELECT * FROM ".$wpdb->prefix."ad_loaders";
                    $rows =  $wpdb->get_results( $sql );
                    foreach($rows as $row) {
                      echo "<tr>";
                        echo "<td>$row->name</td>";
                        echo "<td>$row->script</td>";
                        echo "<td><a data-id='$row->id' class='edit-ad-loader'>Edit</a></td>";
                        echo "<td><a data-id='$row->id' class='delete-ad-loader'>Delete</a></td>";
                      echo "</tr>";
                    }
                 ?>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="assign">
              <h3>Assign Fallback</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="adUnitModal" tabindex="-1" role="dialog" aria-labelledby="adUnitModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="adUnitModalLabel">New Ad Unit</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" action="<?php echo plugins_url( 'admin/backend.php', dirname(__FILE__) ); ?>">
          <input type="hidden" name="action" value="new_banner" />
          <div class="form-group">
            <label>Banner Link</label>
            <input type="text" class="form-control" name="banner_link" />
          </div>
          <div class="form-group">
            <label>Banner</label>
            <input type="file" class="form-control" name="banner_file" />
          </div>
          <div class="form-group">
            <label>Width</label>
            <input type="number" class="form-control" name="banner_width" />
          </div>
          <div class="form-group">
            <label>Height</label>
            <input type="number" class="form-control" name="banner_height" />
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="AdLoaderModal" tabindex="-1" role="dialog" aria-labelledby="AdLoaderModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AdLoaderModalLabel">New Ad Loader</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo plugins_url( 'admin/backend.php', dirname(__FILE__) ); ?>">
          <input type="hidden" name="action" value="new_script" />
          <div class="form-group">
            <label>Script Name</label>
            <input type="text" name="name" class="form-control" />
          </div>
          <div class="form-group">
            <label>Ad Script</label>
            <textarea class="form-control" rows="10" name="script"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>