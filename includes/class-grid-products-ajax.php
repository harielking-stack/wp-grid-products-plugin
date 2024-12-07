<?php
class Grid_Products_Ajax {
    public function __construct() {
        add_action('wp_ajax_load_more_products', array($this, 'load_more_products'));
        add_action('wp_ajax_nopriv_load_more_products', array($this, 'load_more_products'));
    }

    public function load_more_products() {
        check_ajax_referer('wp_grid_products_nonce', 'nonce');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $shortcode = new Grid_Products_Shortcode();
        
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 9,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $products = new WP_Query($args);
        
        ob_start();
        if ($products->have_posts()) :
            while ($products->have_posts()) : $products->the_post();
                $shortcode->render_product_card();
            endwhile;
        endif;
        wp_reset_postdata();

        wp_send_json_success(array(
            'html' => ob_get_clean(),
            'hasMore' => $page < $products->max_num_pages
        ));
    }
}