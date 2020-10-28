<?php
/**
* Plugin Name: Super Form
* Plugin URI: https://iths-bananbyran.github.io/banana-agency-website/
* Description: Creates a simple contactform you can insert to pages.
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
        first_name text NOT NULL,
        last_name text NOT NULL,
        email text NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
        
    add_option( 'superform_db_version', $superform_db_version );
}
    
function superform_form(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'superform';
        
    if (isset($_POST['superform-submitted'])){
        $first_name = sanitize_text_field( $_POST["first_name"] );
        $last_name = sanitize_text_field( $_POST["last_name"] );
        $email = sanitize_email( $_POST["email"] );
            
        $wpdb->insert($table_name, array(
            'time'=> date("Y-m-d H:i:s"),
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            ));
        
        echo "<p><em>Thank you $first_name</em>, we will get in touch with you!</p>";

    } else {

        echo '<form action="" method="post">';
        echo '<p>';
        echo 'First name (required) <br/>';
        echo '<input type="text" name="first_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["first_name"] ) ? esc_attr( $_POST["first_name"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo 'Last name (required) <br/>';
        echo '<input type="text" name="last_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["last_name"] ) ? esc_attr( $_POST["last_name"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo 'Your Email (required) <br/>';
        echo '<input type="email" name="email" value="' . ( isset( $_POST["email"] ) ? esc_attr( $_POST["email"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p><input type="submit" name="superform-submitted" value="Send"></p>';
        echo '</form>';
    }
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
    echo "<p>Use the short code [superform] to add the form to your page!<p>";
            
    if ($retrieve_entries){
        
        echo "<h2>Your entries so far:</h2>";
        echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th>";
                
        foreach ($retrieve_entries as $entry) {
            
            echo "<tr>";
            echo "<td>$entry->id</td>";
            echo "<td>$entry->first_name</td>";
            echo "<td>$entry->last_name</td>";
            echo "<td>$entry->email</td>";
            echo "</tr>";
        }
                
        echo "</table>";

        } else {
                echo "<p><em>No entries found!</em></p>";
            }
}
        
function superform_shortcode() {
    
    ob_start();
    superform_form();
    return ob_get_clean();
}
        
add_action("admin_menu", "superform_menu");
register_activation_hook( __FILE__, 'superform_install' );
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');
add_shortcode('superform', 'superform_shortcode');
        