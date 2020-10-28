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

function superform_menu() {
    add_menu_page(
        "Superform Dashboard", 
        "Superform Dashboard", 
        "manage_options",
        "superform",
        "display_superform_entries");
}

function display_superform_entries(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'superform';
    $retrieve_entries = $wpdb->get_results( "SELECT * FROM $table_name" );

    echo "<h2>Superform Dashboard</h2>";
    
    if($retrieve_entries){
        echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th>";

        foreach ($retrieve_entries as $entry) {
            echo "<tr>";
            echo "<td>$entry->ID</td>";
            echo "<td>$entry->first_name</td>";
            echo "<td>$entry->last_name</td>";
            echo "<td>$entry->email</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No entries found!</p>";
    }
}

add_action("admin_menu", "superform_menu");

register_activation_hook( __FILE__, 'superform_install' );
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');

