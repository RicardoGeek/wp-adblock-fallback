<?php
/**
 * @package WP_AdBlock_Fallback
 * @version 1.0
 */
/*
Plugin Name: WP AdBlock Fallback
Plugin URI: https://github.com/RicardoGeek/wp-adblock-fallback
Description: This plugin provides a solution to detect adBlock and display alternative ads or offers
Author: RicardoGeek
Version: 1.0
Author URI: http://ricardogeek.com/
*/

global $wp_adblock_fallback_version;
$wp_adblock_fallback_version = 1.0;

//register the tables
function register_data_tables() {
  global $wpdb;
  global $wp_adblock_fallback_version;
  
  $alternatives_table_name = $wpdb->prefix."alternative_ads";
  
  $alternatives_table_sql = "CREATE TABLE $alternatives_table_name (
                              id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                              banner VARCHAR(1000) NOT NULL,
                              width int NOT NULL,
                              height int NOT NULL
                            )";
  
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $alternatives_table_sql );
  add_option( 'wp_adblock_fallback_version', $wp_adblock_fallback_version );
}
register_activation_hook( __FILE__, 'register_data_tables' );

//hookup admin menu
add_action( 'admin_menu', 'wp_adblock_fallback_menu' );
function wp_adblock_fallback_menu() {
	add_menu_page( 'WP AdBlock Fallback', 'WP AdBlock Fallback', 'manage_options', 'wp-adblock-fallback', 'wp_adblock_fallback_options' );
}


function wp_adblock_fallback_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include('admin/index.php');
}
