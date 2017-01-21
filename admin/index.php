<?php
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
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <div class="row">
                <div class="col-md-12">
                  <br/><br/>
                  <i>Add units will rotate randomly according to size and placement</i>
                  <br/><br/>
                  <button id="show-new-add-unit" class="btn btn-primary">Create Ad Unit</button>
                  <hr/>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
               <br/><br/>
               <i>Save your ad scripts here</i>
               <br/><br/>
               <button id="show-new-add-unit" class="btn btn-primary">Create Ad Script</button>
               <hr/>
               
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>