<?php
/**
 * Product List Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Product_List extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'product-list';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes() {
        $this->attributes = array(
            'title' => array(
                'type' => 'string',
                'default' => '',
            ),
            'product_type' => array(
                'type' => 'string',
                'default' => 'recent',
            ),
            'categories' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'columns' => array(
                'type' => 'number',
                'default' => 4,
            ),
            'limit' => array(
                'type' => 'number',
                'default' => 8,
            ),
            'orderby' => array(
                'type' => 'string',
                'default' => 'date',
            ),
            'order' => array(
                'type' => 'string',
                'default' => 'desc',
            ),
        );
    }

    /**
     * Render callback.
     *
     * @param array $attributes Block attributes.
     * @param string $content Inner content.
     * @return string
     */
    public function render($attributes, $content) {
        $title = isset($attributes['title']) ? sanitize_text_field($attributes['title']) : '';
        $product_type = isset($attributes['product_type']) ? sanitize_text_field($attributes['product_type']) : 'recent';
        $categories = isset($attributes['categories']) ? $attributes['categories'] : array();
        $columns = isset($attributes['columns']) ? intval($attributes['columns']) : 4;
        $limit = isset($attributes['limit']) ? intval($attributes['limit']) : 8;
        $orderby = isset($attributes['orderby']) ? sanitize_text_field($attributes['orderby']) : 'date';
        $order = isset($attributes['order']) ? sanitize_text_field($attributes['order']) : 'desc';

        // Query products
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'orderby' => $orderby,
            'order' => $order,
            'post_status' => 'publish',
        );

        $query_settings = array(
            'product_type' => $product_type,
            'limit'        => $limit,
            'orderby'      => $orderby,
            'order'        => strtoupper($order),
            'categories'   => $categories,
        );

        $products = wc_tdk_run_products_query($query_settings);

        ob_start();
        ?>
        <div class="wc-tdk-product-list-block">
            <?php if ($title) : ?>
                <h2 class="wc-tdk-product-list-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <div class="wc-tdk-products-grid wc-tdk-columns-<?php echo esc_attr($columns); ?>">
                <?php
                if ($products->have_posts()) {
                    while ($products->have_posts()) {
                        $products->the_post();
                        wc_get_template_part('content', 'product');
                    }
                } else {
                    echo '<p class="wc-tdk-no-products">' . esc_html__('No products found', 'wc-tdk') . '</p>';
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
