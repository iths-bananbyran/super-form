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
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');