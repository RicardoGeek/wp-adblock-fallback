<?php

  include("UploadHandler.php");

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    switch($action) {
      case "new_banner":
        create_new_banner();
        break;
      case "new_script":
        create_new_script();
        break;
    }
    header("Location: /wp-admin/admin.php?page=wp-adblock-fallback");
  }
  
  function create_new_banner() {
    require_once($_SERVER['DOCUMENT_ROOT']."/wp-config.php");
  	global $wpdb;
    
    $alternatives_table_name = $wpdb->prefix."alternative_ads";
    
    $banner_link = $_POST['banner_link'];
    $banner_width = $_POST['banner_width'];
    $banner_height = $_POST['banner_height'];
   
    $fuh = new FileUploadHelper();
    $dir = dirname(__FILE__)."/../banners";
    $file = $fuh->handleImageUpload('banner_file', $dir);
    
    //insert
    $wpdb->insert(
				$alternatives_table_name,
				array(
					"banner" => $file,
					"src" => $banner_link,
          "width" => $banner_width,
          "height" => $banner_height
				)
		);
  }

  function create_new_script() {
    require_once($_SERVER['DOCUMENT_ROOT']."/wp-config.php");
  	global $wpdb;
    
    $js_adscript_loaders_table_name = $wpdb->prefix."ad_loaders";
    
    $name = $_POST['name'];
    $script = $_POST['script'];
    
    //insert
    $wpdb->insert(
				$js_adscript_loaders_table_name,
				array(
					"name" => $name,
					"script" => $script,
				)
		);
  }

?>