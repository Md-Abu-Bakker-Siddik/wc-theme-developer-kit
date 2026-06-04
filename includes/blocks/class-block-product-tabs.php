<?php
/**
 * Product Tabs Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Product_Tabs extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'product-tabs';
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
            'tabs' => array(
                'type' => 'array',
                'default' => array(
                    array(
                        'title' => 'Featured',
                        'type' => 'featured',
                    ),
                    array(
                        'title' => 'New Arrivals',
                        'type' => 'recent',
                    ),
                    array(
                        'title' => 'On Sale',
                        'type' => 'on_sale',
                    ),
                ),
            ),
            'columns' => array(
                'type' => 'number',
                'default' => 4,
            ),
            'limit' => array(
                'type' => 'number',
                'default' => 4,
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
        $tabs = isset($attributes['tabs']) ? $attributes['tabs'] : array();
        $columns = isset($attributes['columns']) ? intval($attributes['columns']) : 4;
        $limit = isset($attributes['limit']) ? intval($attributes['limit']) : 4;

        ob_start();
        ?>
        <div class="wc-tdk-product-tabs-block">
            <?php if ($title) : ?>
                <h2 class="wc-tdk-product-tabs-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <div class="wc-tdk-product-tabs-nav">
                <?php
                foreach ($tabs as $index => $tab) :
                    $tab_title = isset($tab['title']) ? sanitize_text_field($tab['title']) : '';
                    ?>
                    <button class="wc-tdk-tab-button <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($index); ?>">
                        <?php echo esc_html($tab_title); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="wc-tdk-product-tabs-content">
                <?php
                foreach ($tabs as $index => $tab) :
                    $product_type = isset($tab['type']) ? sanitize_text_field($tab['type']) : 'recent';
                    $tab_class = $index === 0 ? 'active' : '';

                    // Query products for this tab
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $limit,
                        'orderby' => 'date',
                        'order' => 'desc',
                        'post_status' => 'publish',
                    );

                    switch ($product_type) {
                        case 'featured':
                            $args['tax_query'][] = array(
                                'taxonomy' => 'product_visibility',
                                'field' => 'name',
                                'terms' => 'featured',
                            );
                            break;
                        case 'top_rated':
                            add_filter('posts_clauses', array('WC_Shortcode_Products', 'order_by_rating_post_clauses'));
                            break;
                        case 'on_sale':
                            $args['post__in'] = wc_get_product_ids_on_sale();
                            break;
                        case 'best_selling':
                            $args['meta_key'] = 'total_sales';
                            $args['orderby'] = 'meta_value_num';
                            break;
                    }

                    $products = new WP_Query($args);
                    ?>
                    <div class="wc-tdk-tab-content <?php echo esc_attr($tab_class); ?>" data-tab-content="<?php echo esc_attr($index); ?>">
                        <div class="wc-tdk-products-grid wc-tdk-columns-<?php echo esc_attr($columns); ?>">
                            <?php
                            if ($products->have_posts()) {
                                while ($products->have_posts()) {
                                    $products->the_post();
                                    wc_get_template_part('content', 'product');
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
