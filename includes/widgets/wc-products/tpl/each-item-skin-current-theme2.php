<?php
/**
 * Product card – Skin 2 (classic bordered shop card).
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

$image_size = ! empty($image_size) ? $image_size : 'woocommerce_thumbnail';
?>
<div class="product-block wc-tdk-skin-2-product">
    <div class="inner-box">
        <div class="image">
            <?php if ($product->is_on_sale()) : ?>
                <span class="tag"><?php esc_html_e('Sale', 'wc-tdk'); ?></span>
            <?php endif; ?>
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <?php echo wp_kses_post($product->get_image($image_size)); ?>
            </a>
        </div>
        <div class="content">
            <h4>
                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h4>
            <?php woocommerce_template_loop_price(); ?>
            <span class="rating">
                <?php woocommerce_template_loop_rating(); ?>
            </span>
        </div>
        <div class="icon-box">
            <button type="button" class="ui-btn like-btn wc-tdk-quick-view-button" data-product-id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Quick view', 'wc-tdk'); ?>">
                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
            </button>
            <?php
            echo apply_filters(
                'woocommerce_loop_add_to_cart_link',
                sprintf(
                    '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s ui-btn add-to-cart product_type_%s" aria-label="%s"><span class="dashicons dashicons-cart" aria-hidden="true"></span></a>',
                    esc_url($product->add_to_cart_url()),
                    esc_attr($product->get_id()),
                    esc_attr($product->get_sku()),
                    esc_attr(
                        implode(
                            ' ',
                            array_filter(
                                array(
                                    'button',
                                    'product_type_' . $product->get_type(),
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                    $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                                )
                            )
                        )
                    ),
                    esc_attr($product->get_type()),
                    esc_attr($product->add_to_cart_description())
                ),
                $product
            );
            ?>
        </div>
    </div>
</div>
