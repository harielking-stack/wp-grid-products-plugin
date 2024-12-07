<?php
class Grid_Products {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            'wp-grid-products',
            plugin_dir_url(dirname(__FILE__)) . 'assets/css/grid-products.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'wp-grid-products',
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/grid-products.js',
            array('jquery'),
            '1.0.0',
            true
        );

        wp_localize_script('wp-grid-products', 'wpGridProducts', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_grid_products_nonce')
        ));
    }
}