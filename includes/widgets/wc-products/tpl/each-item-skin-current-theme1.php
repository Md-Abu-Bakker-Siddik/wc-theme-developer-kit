<?php
/**
 * Product card – Skin Current Theme 1 (clean vertical card).
 *
 * @package WooCommerce Theme Developer Kit
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product;

if (! $product instanceof WC_Product) {
    $product = wc_get_product(get_the_ID());
}

if (! $product) {
    return;
}

$image_size  = ! empty($image_size) ? $image_size : 'woocommerce_thumbnail';
$excerpt_len = 0;

if (isset($skin_current_theme1_excerpt_length)) {
    $excerpt_len = absint($skin_current_theme1_excerpt_length);
} elseif (isset($excerpt_length)) {
    $excerpt_len = absint($excerpt_length);
}
?>
<div class="tm-woo-product-style1">
    <div class="product-inner">
        <div class="image-box">
            <div class="image">
                <?php woocommerce_show_product_loop_sale_flash(); ?>
                <a class="product-image-link" href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php echo wp_kses_post($product->get_image($image_size)); ?>
                </a>
            </div>
            <div class="product-button-holder">
                <?php wc_tdk_render_product_action_buttons(); ?>
            </div>
        </div>
        <div class="content-box">
            <?php woocommerce_template_loop_rating(); ?>
            <h4 class="product-title">
                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h4>
            <?php if ($excerpt_len > 0) : ?>
                <div class="short-description">
                    <?php wc_tdk_woocommerce_get_product_short_description($excerpt_len); ?>
                </div>
            <?php endif; ?>
            <?php woocommerce_template_loop_price(); ?>
            <?php
            woocommerce_template_loop_add_to_cart(
                array(
                    'class' => 'button',
                )
            );
            ?>
            <?php wc_tdk_woocommerce_time_sale_layout(); ?>
        </div>
    </div>
</div>
