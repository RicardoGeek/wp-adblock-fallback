<?php
  /**
   * @package WP_AdBlock_Fallback
   * @version 1.1
   */
  /*
  Plugin Name: WP AdBlock Fallback
  Plugin URI: https://github.com/RicardoGeek/wp-adblock-fallback
  Description: This plugin provides a solution to detect adBlock and display alternative ads or offers
  Author: RicardoGeek
  Version: 1.1
  Author URI: http://ricardogeek.com/
  */

global $wp_adblock_fallback_version;
$wp_adblock_fallback_version = 1.1;

//Tables
function register_data_tables() {
  global $wpdb;
  global $wp_adblock_fallback_version;

  $ad_table_name = $wpdb->prefix."ad";
	$click_table_name = $wpdb->prefix."click";
  $impression_table_name = $wpdb->prefix."impression";

  $ad_table_sql = "CREATE TABLE $ad_table_name (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `banner` VARCHAR(500) NOT NULL,
                              `link` VARCHAR(500) NOT NULL,
                              `size` VARCHAR(45) NOT NULL,
                              `countryId` VARCHAR(45) NOT NULL,
                              PRIMARY KEY (`id`));";

  $click_table_sql = "CREATE TABLE $click_table_name (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `adId` INT NOT NULL,
                              `count` INT NOT NULL,
                              PRIMARY KEY (`id`));";

  $impression_table_sql = "CREATE TABLE $impression_table_name (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `adId` INT NOT NULL,
                              `count` INT NOT NULL,
                              PRIMARY KEY (`id`));";


  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $ad_table_sql );
	dbDelta( $click_table_sql );
  dbDelta( $impression_table_sql );
  add_option( 'wp_adblock_fallback_version', $wp_adblock_fallback_version );
}
register_activation_hook( __FILE__, 'register_data_tables' );

//Admin Menus
add_action( 'admin_menu', 'wp_adblock_fallback_menu' );
function wp_adblock_fallback_menu() {
	add_menu_page( 'Dashboard', 'WP AdBlock Fallback', 'manage_options', 'wp-adblock-fallback', 'wp_adblock_fallback_options' );
  add_submenu_page('wp-adblock-fallback', 'New Ad Zone', 'New Ad Zone', 'manage_options', 'wp_adblock_fallback_new_ad', 'wp_adblock_fallback_new_ad');
}

function wp_adblock_fallback_new_ad() {
  if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include('admin/new_ad.php');
}

function wp_adblock_fallback_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include('admin/index.php');
}

//CSS
function custom_css() {
  wp_enqueue_style( 'customcss', plugins_url('css/wp-adblock-fallback.css', __FILE__) );
}
add_action( 'admin_print_styles', 'custom_css');

//JS
function custom_js() {
  wp_enqueue_script( 'customjs', plugins_url('js/custom.js', __FILE__) );
}
add_action('admin_print_scripts', 'custom_js');

//Functions
include("functions.php");
