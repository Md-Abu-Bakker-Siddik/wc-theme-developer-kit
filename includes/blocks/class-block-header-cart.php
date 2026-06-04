<?php
/**
 * Header Cart Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Header_Cart extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'header-cart';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes() {
        $this->attributes = array(
            'layout' => array(
                'type' => 'string',
                'default' => 'dropdown',
            ),
            'show_count' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'show_total' => array(
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
        $layout = isset($attributes['layout']) ? sanitize_text_field($attributes['layout']) : 'dropdown';
        $show_count = isset($attributes['show_count']) ? (bool)$attributes['show_count'] : true;
        $show_total = isset($attributes['show_total']) ? (bool)$attributes['show_total'] : true;

        $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        $cart_total = WC()->cart ? WC()->cart->get_cart_total() : '';

        ob_start();
        ?>
        <div class="wc-tdk-header-cart-block wc-tdk-header-cart-<?php echo esc_attr($layout); ?>">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="wc-tdk-header-cart-link">
                <span class="wc-tdk-header-cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </span>
                <?php if ($show_count) : ?>
                    <span class="wc-tdk-header-cart-count"><?php echo esc_html($cart_count); ?></span>
                <?php endif; ?>
                <?php if ($show_total) : ?>
                    <span class="wc-tdk-header-cart-total"><?php echo wp_kses_post($cart_total); ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }
}
