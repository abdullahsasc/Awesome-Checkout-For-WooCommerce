<?php 
/**
 * Plugin Name:       Awesome WooCommerce Checkout 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Redefine your Checkout page for WooCommece
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
*/
defined( 'ABSPATH' ) || exit;

function myplugin_plugin_path() {
    // gets the absolute path to this plugin directory
    return untrailingslashit( plugin_dir_path( __FILE__ ) );
}

  
function myplugin_woocommerce_locate_template( $template, $template_name, $template_path ) {
    global $woocommerce;
  
    $_template = $template;
  
    if ( ! $template_path ) $template_path = $woocommerce->template_url;
  
    $plugin_path  = myplugin_plugin_path() . '/woocommerce/';
  
    // Look within passed path within the theme - this is priority
    $template = locate_template(
  
      array(
        $template_path . $template_name,
        $template_name
      )
    );
  
    // Modification: Get the template from this plugin, if it exists
    if ( ! $template && file_exists( $plugin_path . $template_name ) ){
      $template = $plugin_path . $template_name;
    }
    // Use default template
    if ( ! $template ){
      $template = $_template;
    }
    // Return what we found
    return $template;
}
add_filter( 'woocommerce_locate_template', 'myplugin_woocommerce_locate_template', 10, 3 );
