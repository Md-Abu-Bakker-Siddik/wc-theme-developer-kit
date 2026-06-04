<?php
/**
 * Account Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Account extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'account';
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
            'show_avatar' => array(
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
        $show_avatar = isset($attributes['show_avatar']) ? (bool)$attributes['show_avatar'] : true;

        ob_start();
        ?>
        <div class="wc-tdk-account-block wc-tdk-account-<?php echo esc_attr($layout); ?>">
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="wc-tdk-account-link">
                    <?php if ($show_avatar) : ?>
                        <span class="wc-tdk-account-avatar">
                            <?php echo get_avatar(get_current_user_id(), 40); ?>
                        </span>
                    <?php endif; ?>
                    <span class="wc-tdk-account-text"><?php echo esc_html(wp_get_current_user()->display_name); ?></span>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="wc-tdk-account-link">
                    <span class="wc-tdk-account-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="wc-tdk-account-text"><?php esc_html_e('Account', 'wc-tdk'); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
