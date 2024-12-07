<?php
class Grid_Products_Shortcode {
    public function __construct() {
        add_shortcode('grid_products', array($this, 'render_grid'));
    }

    public function render_grid($atts) {
        $atts = shortcode_atts(array(
            'posts_per_page' => 9,
            'category' => '',
        ), $atts);

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $atts['posts_per_page'],
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        );

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => explode(',', $atts['category'])
                )
            );
        }

        $products = new WP_Query($args);
        ob_start();
        ?>
        <div class="wp-grid-products">
            <div class="products-grid">
                <?php
                if ($products->have_posts()) :
                    while ($products->have_posts()) : $products->the_post();
                        $this->render_product_card();
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <?php if ($products->max_num_pages > 1) : ?>
                <div class="load-more-container">
                    <button class="load-more-button" data-page="1" data-max="<?php echo $products->max_num_pages; ?>">
                        Load More
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    private function render_product_card() {
        $product = wc_get_product(get_the_ID());
        ?>
        <div class="product-card">
            <div class="product-image">
                <?php echo $product->get_image(); ?>
            </div>
            <div class="product-details">
                <h3 class="product-title"><?php echo $product->get_name(); ?></h3>
                <div class="product-price"><?php echo $product->get_price_html(); ?></div>
                <button class="buy-now-button" data-product-id="<?php echo $product->get_id(); ?>">
                    Buy Now
                </button>
            </div>
        </div>
        <?php
    }
}