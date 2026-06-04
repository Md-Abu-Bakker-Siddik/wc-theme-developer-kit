<?php
/**
 * Wishlist Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Wishlist extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'wishlist';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes() {
        $this->attributes = array(
            'show_count' => array(
                'type' => 'boolean',
                'default' => true,
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
        $show_count = isset($attributes['show_count']) ? (bool)$attributes['show_count'] : true;

        // Simple wishlist implementation (basic version)
        // For now, we'll use a cookie-based approach
        $wishlist_count = isset($_COOKIE['wc_tdk_wishlist']) ? count(json_decode(stripslashes($_COOKIE['wc_tdk_wishlist']), true)) : 0;
        // Note: In a full implementation, you'd want proper storage (meta or user meta)
        $wishlist_page_url = get_permalink(get_option('woocommerce_shop_page_id'));

        ob_start();
        ?>
        <div class="wc-tdk-wishlist-block">
            <a href="<?php echo esc_url($wishlist_page_url); ?>" class="wc-tdk-wishlist-link">
                <span class="wc-tdk-wishlist-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </span>
                <?php if ($show_count) : ?>
                    <span class="wc-tdk-wishlist-count"><?php echo esc_html($wishlist_count); ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }
}
