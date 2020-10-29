<?php
/**
* Plugin Name: Super Form
* Plugin URI: https://iths-bananbyran.github.io/banana-agency-website/
* Description: Creates a simple contactform you can insert to pages.
* Version: 1.0
* Author: Bananbyrån
*/

function enqueue_related_pages_scripts_and_styles(){
    wp_enqueue_style('superform_styles', plugins_url('/css/superform_styles.css', __FILE__));
    wp_enqueue_script('superform_validation', plugins_url( '/scripts/superform_validation.js' , __FILE__ ));
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
        $first_name = sanitize_text_field( $_POST["firstname"] );
        $last_name = sanitize_text_field( $_POST["lastname"] );
        $email = sanitize_email( $_POST["email"] );
            
        $wpdb->insert($table_name, array(
            'time'=> date("Y-m-d H:i:s"),
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            ));
        
        echo "<p><em>Thank you $first_name</em>, we will get in touch with you!</p>";

    } else {

        echo '<form action="" method="post" name="superform">';
        echo '<div class="superform-form-container">';
        echo '<div class="superform-field-container">';
        echo '<label for="firstname">First name</label>';
        echo '<input type="text" id="firstname" name="firstname" value="' . ( isset( $_POST["firstname"] ) ? esc_attr( $_POST["firstname"] ) : '' ) . '" required />';
        echo '<p id="firstname-message" class="message hidden">""</p>';
        echo '</div>';
        echo '<div class="superform-field-container">';
        echo '<label for="lastname">Last name</label>';
        echo '<input type="text" id="lastname" name="lastname" value="' . ( isset( $_POST["lastname"] ) ? esc_attr( $_POST["lastname"] ) : '' ) . '" required />';
        echo '<p id="lastname-message" class="message hidden">""</p>';
        echo '</div>';
        echo '<div class="superform-field-container">';
        echo '<label for="email">Email</label>';
        echo '<input type="email" id="email" name="email" value="' . ( isset( $_POST["email"] ) ? esc_attr( $_POST["email"] ) : '' ) . '" required />';
        echo '<p id="email-message" class="message hidden">""</p>';
        echo '</div>';
        echo '<input type="submit" name="superform-submitted" value="Send">';
        echo '<div>';
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
        echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Action</th>";
                
        foreach ($retrieve_entries as $entry) {
            
            echo "<tr>";
            echo "<td>$entry->id</td>";
            echo "<td>$entry->first_name</td>";
            echo "<td>$entry->last_name</td>";
            echo "<td>$entry->email</td>";
            echo "<td><form action='admin-post.php' method='post'>";
            wp_nonce_field( 'delete_row_event_' . $entry->id );
            echo "<input type='hidden' name='action' value='delete_row_event'>";
            echo "<input type='hidden' name='eventid' value='$entry->id'>";
            echo "<input type='submit' class='delete' value='Delete' /></td>
            </form>";
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
        
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');
add_action("admin_menu", "superform_menu");
register_activation_hook( __FILE__, 'superform_install' );
add_shortcode('superform', 'superform_shortcode');
add_action( 'admin_post_delete_row_event', function () {

    if (!empty($_POST['eventid'])) {
      $event_id = $_POST['eventid'];
      check_admin_referer( 'delete_row_event_' . $event_id );
      global $wpdb;
      $table_name = $wpdb->prefix . 'superform';
      $wpdb->delete($table_name,
                     [ 'id' => $event_id ],
                     [ '%d' ] );
    }

    wp_redirect(admin_url('/admin.php?page=superform'));
    exit;
  });
        