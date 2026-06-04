<?php
/**
 * Percentage sale badges for WooCommerce loops.
 *
 * @package WC_TDK
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_TDK_Product_Badges
 */
class WC_TDK_Product_Badges {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'woocommerce_sale_flash', array( $this, 'custom_sale_badge' ), 10, 3 );
	}

	/**
	 * Replace default sale flash with percentage badge.
	 *
	 * @param string     $html    Sale flash HTML.
	 * @param WP_Post    $post    Post object.
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	public function custom_sale_badge( $html, $post, $product ) {
		if ( ! $product instanceof WC_Product ) {
			return $html;
		}

		if ( $product->is_type( 'simple' ) ) {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			if ( $regular_price && $sale_price ) {
				$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

				return sprintf(
					'<span class="onsale wc-tdk-sale-badge">-%s%% %s</span>',
					esc_html( (string) $percentage ),
					esc_html__( 'OFF', 'wc-tdk' )
				);
			}
		} elseif ( $product->is_type( 'variable' ) ) {
			$prices = $product->get_variation_prices( true );

			if ( ! empty( $prices['regular_price'] ) && ! empty( $prices['sale_price'] ) ) {
				$max_percentage = 0;

				foreach ( $prices['regular_price'] as $variation_id => $reg_price ) {
					if ( isset( $prices['sale_price'][ $variation_id ] ) && $prices['sale_price'][ $variation_id ] ) {
						$percentage = round( ( ( $reg_price - $prices['sale_price'][ $variation_id ] ) / $reg_price ) * 100 );
						if ( $percentage > $max_percentage ) {
							$max_percentage = $percentage;
						}
					}
				}

				if ( $max_percentage > 0 ) {
					return sprintf(
						'<span class="onsale wc-tdk-sale-badge">-%s%% %s</span>',
						esc_html( (string) $max_percentage ),
						esc_html__( 'OFF', 'wc-tdk' )
					);
				}
			}
		}

		return $html;
	}
}
