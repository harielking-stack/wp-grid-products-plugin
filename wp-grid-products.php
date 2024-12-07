<?php
/**
 * Plugin Name: WP Grid Products
 * Description: Display products in a 3-column infinite scroll grid with buy now buttons
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once plugin_dir_path(__FILE__) . 'includes/class-grid-products.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-grid-products-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-grid-products-ajax.php';

// Initialize plugin
function wp_grid_products_init() {
    new Grid_Products();
    new Grid_Products_Shortcode();
    new Grid_Products_Ajax();
}
add_action('plugins_loaded', 'wp_grid_products_init');

// Register activation hook
register_activation_hook(__FILE__, 'wp_grid_products_activate');
function wp_grid_products_activate() {
    // Activation tasks if needed
    flush_rewrite_rules();
}