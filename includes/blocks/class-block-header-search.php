<?php
/**
 * Header Search Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Header_Search extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'header-search';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes() {
        $this->attributes = array(
            'show_categories' => array(
                'type' => 'boolean',
                'default' => false,
            ),
            'placeholder' => array(
                'type' => 'string',
                'default' => 'Search products...',
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
        $show_categories = isset($attributes['show_categories']) ? (bool)$attributes['show_categories'] : false;
        $placeholder = isset($attributes['placeholder']) ? sanitize_text_field($attributes['placeholder']) : 'Search products...';

        ob_start();
        ?>
        <div class="wc-tdk-header-search-block">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="wc-tdk-search-form">
                <input type="hidden" name="post_type" value="product" />
                <?php if ($show_categories) : ?>
                    <select name="product_cat" class="wc-tdk-search-category">
                        <option value=""><?php esc_html_e('All Categories', 'wc-tdk'); ?></option>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                        ));
                        foreach ($categories as $cat) {
                            echo '<option value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</option>';
                        }
                        ?>
                    </select>
                <?php endif; ?>
                <input type="search" class="wc-tdk-search-field" placeholder="<?php echo esc_attr($placeholder); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="wc-tdk-search-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}
