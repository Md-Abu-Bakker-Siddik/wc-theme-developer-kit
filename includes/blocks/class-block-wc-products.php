<?php

/**
 * WC Products Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Wc_Products extends WC_TDK_Block_Base
{

    /**
     * Register block type with product grid styles for editor and frontend.
     */
    public function register()
    {
        wc_tdk_register_wc_product_block_styles();

        register_block_type(
            'wc-tdk/' . $this->block_name,
            array(
                'attributes'      => $this->attributes,
                'render_callback' => array($this, 'render'),
                'editor_script'   => 'wc-tdk-blocks-editor',
                'editor_style'    => array(
                    'wc-tdk-blocks-editor',
                    'wc-tdk-wc-products',
                    'wc-tdk-wc-products-skin-1',
                    'wc-tdk-wc-products-skin-2',
                ),
                'style'           => array(
                    'wc-tdk-wc-products',
                    'wc-tdk-wc-products-skin-1',
                    'wc-tdk-wc-products-skin-2',
                ),
            )
        );
    }

    /**
     * Set block name.
     */
    protected function set_block_name()
    {
        $this->block_name = 'wc-products';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes()
    {
        $this->attributes = array(
            'title' => array(
                'type' => 'string',
                'default' => '',
            ),
            'layout' => array(
                'type' => 'string',
                'default' => 'grid',
            ),
            'skin' => array(
                'type' => 'string',
                'default' => 'skin-current-theme1',
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
        );
    }

    /**
     * Render callback.
     *
     * @param array $attributes Block attributes.
     * @param string $content Inner content.
     * @return string
     */
    public function render($attributes, $content)
    {
        if (! class_exists('WooCommerce')) {
            return '<p class="wc-tdk-notice">' . esc_html__('WooCommerce must be active to display products.', 'wc-tdk') . '</p>';
        }

        $title        = isset($attributes['title']) ? sanitize_text_field($attributes['title']) : '';
        $layout       = isset($attributes['layout']) ? sanitize_text_field($attributes['layout']) : 'grid';
        $skin         = isset($attributes['skin']) ? sanitize_text_field($attributes['skin']) : 'skin-current-theme1';
        $product_type = isset($attributes['product_type']) ? sanitize_text_field($attributes['product_type']) : 'recent';
        $categories   = isset($attributes['categories']) ? $attributes['categories'] : array();
        $columns      = isset($attributes['columns']) ? intval($attributes['columns']) : 4;
        $limit        = isset($attributes['limit']) ? intval($attributes['limit']) : 8;

        $allowed_layouts = array('grid', 'masonry', 'carousel');
        $allowed_skins   = array('skin-current-theme1', 'skin-current-theme2');

        if (! in_array($layout, $allowed_layouts, true)) {
            $layout = 'grid';
        }
        if (! in_array($skin, $allowed_skins, true)) {
            $skin = 'skin-current-theme1';
        }

        $settings = array(
            '_skin'        => $skin,
            'product_type' => $product_type,
            'limit'        => $limit,
            'orderby'      => 'date',
            'order'        => 'DESC',
            'categories'   => $categories,
            'columns'      => max(1, $columns),
            'gutter'       => 'gutter-10',
            'display_type' => $layout,
            'holder_id'    => wc_tdk_get_isotope_holder_ID('wc-product-block'),
        );

        wc_tdk_register_wc_product_block_styles();
        wc_tdk_enqueue_product_skin_assets(wc_tdk_get_active_product_skin($settings));

        $the_query             = wc_tdk_run_products_query($settings);
        $settings['the_query'] = $the_query;
        $settings              = wc_tdk_prepare_widget_skin_for_templates($settings);
        $settings['settings']  = $settings;

        $html = wc_tdk_get_shortcode_shop_template_part('wc-products', $layout, 'wc-products/tpl', $settings, true);

        if (empty(trim(wp_strip_all_tags($html))) && $the_query->have_posts()) {
            $html = wc_tdk_render_products_loop_fallback($the_query, $settings);
        }

        if (empty(trim(wp_strip_all_tags($html)))) {
            ob_start();
            wc_tdk_no_products_found_text();
            $html = ob_get_clean();
        }

        ob_start();
        ?>
        <div class="wc-tdk-wc-products-block">
            <?php if ($title) : ?>
                <h2 class="wc-tdk-wc-products-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php wc_tdk_print_template_html( $html ); ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
