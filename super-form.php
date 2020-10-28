<?php
/**
 * Plugin Name: Super Form
 * Plugin URI: https://iths-bananbyran.github.io/banana-agency-website/
 * Description: Create a form plugin for wordpress
 * Version: 1.0
 * Author: Bananbyrån
 */

function enqueue_related_pages_scripts_and_styles(){
    // wp_enqueue_style('superform-styles', plugins_url('/css/superform-styles.css', __FILE__));
    wp_enqueue_script('hello', plugins_url( '/scripts/hello.js' , __FILE__ ));
}

function superform_install() {
	global $wpdb;
	global $superform_db_version;

	$table_name = $wpdb->prefix . 'superform';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		first_name tinytext NOT NULL,
		last_name tinytext NOT NULL,
		email text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'superform_db_version', $superform_db_version );
}

register_activation_hook( __FILE__, 'superform_install' );
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');
