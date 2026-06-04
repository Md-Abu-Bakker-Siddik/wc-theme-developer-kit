<?php
/**
 * Direct checkout (Buy Now) button.
 *
 * @package WC_TDK
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_TDK_Direct_Checkout
 */
class WC_TDK_Direct_Checkout {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_buy_now_button' ) );
		add_action( 'template_redirect', array( $this, 'handle_buy_now_redirect' ) );
	}

	/**
	 * Output Buy Now button on single product pages.
	 */
	public function add_buy_now_button() {
		global $product;

		if ( ! $product instanceof WC_Product || ! $product->is_purchasable() ) {
			return;
		}

		$url = wp_nonce_url(
			add_query_arg(
				array(
					'wc_tdk_buy_now' => $product->get_id(),
				),
				$product->get_permalink()
			),
			'wc_tdk_buy_now_' . $product->get_id(),
			'wc_tdk_buy_now_nonce'
		);

		printf(
			'<a href="%1$s" class="button wc-tdk-buy-now-button">%2$s</a>',
			esc_url( $url ),
			esc_html__( 'Buy now', 'wc-tdk' )
		);
	}

	/**
	 * Handle Buy Now redirect.
	 */
	public function handle_buy_now_redirect() {
		if ( ! isset( $_GET['wc_tdk_buy_now'] ) ) {
			return;
		}

		$product_id = absint( wp_unslash( $_GET['wc_tdk_buy_now'] ) );

		if ( ! $product_id ) {
			return;
		}

		if ( ! isset( $_GET['wc_tdk_buy_now_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['wc_tdk_buy_now_nonce'] ) ), 'wc_tdk_buy_now_' . $product_id ) ) {
			return;
		}

		$product = wc_get_product( $product_id );

		if ( ! $product || ! $product->is_purchasable() ) {
			return;
		}

		if ( null === WC()->cart ) {
			return;
		}

		WC()->cart->empty_cart();
		WC()->cart->add_to_cart( $product_id );

		wp_safe_redirect( wc_get_checkout_url() );
		exit;
	}
}
