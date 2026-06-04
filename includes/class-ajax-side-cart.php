<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_AJAX_Side_Cart {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'woocommerce_after_footer', array( $this, 'output_side_cart_markup' ) );
        add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_cart_fragments' ) );
    }

    public function enqueue_assets() {
        wp_enqueue_style( 'wc-tdk-side-cart', WC_TDK_PLUGIN_URL . 'assets/side-cart.css', array(), WC_TDK_VERSION );
        wp_enqueue_script( 'wc-tdk-side-cart', WC_TDK_PLUGIN_URL . 'assets/side-cart.js', array( 'jquery' ), WC_TDK_VERSION, true );
        wp_localize_script( 'wc-tdk-side-cart', 'wc_tdk_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ) );
    }

    public function output_side_cart_markup() {
        ?>
        <div id="wc-tdk-side-cart" class="wc-tdk-side-cart">
            <div class="wc-tdk-side-cart-overlay"></div>
            <div class="wc-tdk-side-cart-panel">
                <div class="wc-tdk-side-cart-header">
                    <h3><?php esc_html_e( 'Your Cart', 'wc-tdk' ); ?></h3>
                    <button class="wc-tdk-side-cart-close">&times;</button>
                </div>
                <div class="wc-tdk-side-cart-content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function update_cart_fragments( $fragments ) {
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        $fragments['div.wc-tdk-side-cart-content'] = '<div class="wc-tdk-side-cart-content">' . $mini_cart . '</div>';
        return $fragments;
    }
}
