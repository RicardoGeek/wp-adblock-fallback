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

//register the tables
function register_data_tables() {
  global $wpdb;
  global $wp_adblock_fallback_version;
  
  $alternatives_table_name = $wpdb->prefix."alternative_ads";
  $js_adscript_loaders_table_name = $wpdb->prefix."ad_loaders";
	$wp_fallbacks_table = $wpdb->prefix."ad_fallbacks";
  
  $alternatives_table_sql = "CREATE TABLE $alternatives_table_name (
                              id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
															alias VARCHAR(1000) NOT NULL,
                              banner VARCHAR(1000) NOT NULL,
                              src VARCHAR(1000) NOT NULL,
                              width int NOT NULL,
                              height int NOT NULL
                            );";
  
  $js_adscript_loaders_sql = "CREATE TABLE $js_adscript_loaders_table_name (
                                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(20) NOT NULL,
                                script VARCHAR(10000) NOT NULL
                              );";
	
	$wp_fallbacks_sql = "CREATE TABLE $wp_fallbacks_table (
												id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
												script INT NOT NULL,
												banner INT NOT NULL
											)";
  
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $alternatives_table_sql );
  dbDelta( $js_adscript_loaders_sql );
	dbDelta( $wp_fallbacks_sql );
  add_option( 'wp_adblock_fallback_version', $wp_adblock_fallback_version );
}
register_activation_hook( __FILE__, 'register_data_tables' );

//enqueue adBlock detectors
function wp_enqueue_adblock_detectors() {
  wp_register_script('fuckadblock', plugins_url('public/fuckadblock.js', __FILE__));
  wp_register_script('loadme', plugins_url('public/loadme.php', __FILE__));
  wp_enqueue_script('fuckadblock');
  wp_enqueue_script('loadme');
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_adblock_detectors' ); 

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
