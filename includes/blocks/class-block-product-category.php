<?php

/**
 * Product Category Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Product_Category extends WC_TDK_Block_Base
{

    /**
     * Set block name.
     */
    protected function set_block_name()
    {
        $this->block_name = 'product-category';
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
            'content' => array(
                'type' => 'string',
                'default' => '',
            ),
            'skin' => array(
                'type' => 'string',
                'default' => 'skin-current-theme1',
            ),
            'categories' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'product_count' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'columns' => array(
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
    public function render($attributes, $content)
    {
        $title = isset($attributes['title']) ? sanitize_text_field($attributes['title']) : '';
        $content_text = isset($attributes['content']) ? sanitize_textarea_field($attributes['content']) : '';
        $skin = isset($attributes['skin']) ? sanitize_text_field($attributes['skin']) : 'skin-current-theme1';
        $categories = isset($attributes['categories']) ? $attributes['categories'] : array();
        $product_count = isset($attributes['product_count']) ? (bool)$attributes['product_count'] : true;
        $columns = isset($attributes['columns']) ? intval($attributes['columns']) : 4;

        ob_start();
?>
        <div class="wc-tdk-product-category-block">
            <?php if ($title) : ?>
                <h2 class="wc-tdk-product-category-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($content_text) : ?>
                <p class="wc-tdk-product-category-content"><?php echo esc_html($content_text); ?></p>
            <?php endif; ?>
            <div class="wc-tdk-product-categories grid-<?php echo esc_attr($columns); ?>">
                <?php
                if (empty($categories)) {
                    // Get all product categories
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                    ));
                } else {
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'include' => $categories,
                        'hide_empty' => false,
                    ));
                }

                foreach ($product_categories as $category) {
                    $link = get_term_link($category);
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'medium') : wc_placeholder_img_src();
                ?>
                    <div class="wc-tdk-product-category-item">
                        <a href="<?php echo esc_url($link); ?>" class="wc-tdk-product-category-link">
                            <div class="wc-tdk-product-category-image">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" />
                            </div>
                            <h3 class="wc-tdk-product-category-name"><?php echo esc_html($category->name); ?></h3>
                            <?php if ($product_count) : ?>
                                <span class="wc-tdk-product-category-count">
                                    <?php echo esc_html($category->count); ?>
                                    <?php echo esc_html(_n('Product', 'Products', $category->count, 'wc-tdk')); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
