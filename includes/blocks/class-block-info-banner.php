<?php
/**
 * Info Banner Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Info_Banner extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'info-banner';
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
            'subtitle' => array(
                'type' => 'string',
                'default' => '',
            ),
            'content' => array(
                'type' => 'string',
                'default' => '',
            ),
            'button_text' => array(
                'type' => 'string',
                'default' => '',
            ),
            'button_url' => array(
                'type' => 'string',
                'default' => '',
            ),
            'image' => array(
                'type' => 'string',
                'default' => '',
            ),
            'layout' => array(
                'type' => 'string',
                'default' => 'basic',
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
        $subtitle = isset($attributes['subtitle']) ? sanitize_text_field($attributes['subtitle']) : '';
        $content_text = isset($attributes['content']) ? sanitize_textarea_field($attributes['content']) : '';
        $button_text = isset($attributes['button_text']) ? sanitize_text_field($attributes['button_text']) : '';
        $button_url = isset($attributes['button_url']) ? esc_url_raw($attributes['button_url']) : '';
        $image = isset($attributes['image']) ? esc_url_raw($attributes['image']) : '';
        $layout = isset($attributes['layout']) ? sanitize_text_field($attributes['layout']) : 'basic';

        ob_start();
        ?>
        <div class="wc-tdk-info-banner-block wc-tdk-info-banner-<?php echo esc_attr($layout); ?>">
            <?php if ($image) : ?>
                <div class="wc-tdk-info-banner-image">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" />
                </div>
            <?php endif; ?>
            <div class="wc-tdk-info-banner-content">
                <?php if ($subtitle) : ?>
                    <span class="wc-tdk-info-banner-subtitle"><?php echo esc_html($subtitle); ?></span>
                <?php endif; ?>
                <?php if ($title) : ?>
                    <h2 class="wc-tdk-info-banner-title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($content_text) : ?>
                    <p class="wc-tdk-info-banner-text"><?php echo esc_html($content_text); ?></p>
                <?php endif; ?>
                <?php if ($button_text && $button_url) : ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="wc-tdk-info-banner-button">
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
