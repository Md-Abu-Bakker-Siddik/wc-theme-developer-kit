<?php
/**
 * Product quick view modal.
 *
 * @package WC_TDK
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue quick view scripts and styles.
 */
function wc_tdk_enqueue_quick_view_assets() {
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script(
		'wc-tdk-quick-view',
		WC_TDK_PLUGIN_URL . 'assets/quick-view.js',
		array( 'jquery' ),
		WC_TDK_VERSION,
		true
	);

	wp_localize_script(
		'wc-tdk-quick-view',
		'wc_tdk_quick_view',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'wc_tdk_quick_view_nonce' ),
			'i18n'     => array(
				'loading' => esc_html__( 'Loading…', 'wc-tdk' ),
				'error'   => esc_html__( 'Could not load product. Please refresh the page and try again.', 'wc-tdk' ),
				'timeout' => esc_html__( 'Request timed out. Check your connection or try again.', 'wc-tdk' ),
				'retry'   => esc_html__( 'Try again', 'wc-tdk' ),
			),
		)
	);

	wp_enqueue_style(
		'wc-tdk-quick-view',
		WC_TDK_PLUGIN_URL . 'assets/quick-view.css',
		array(),
		WC_TDK_VERSION
	);
}

/**
 * Class WC_TDK_Quick_View
 */
class WC_TDK_Quick_View {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_wc_tdk_quick_view', array( $this, 'quick_view_ajax_handler' ) );
		add_action( 'wp_ajax_nopriv_wc_tdk_quick_view', array( $this, 'quick_view_ajax_handler' ) );
		add_action( 'wp_footer', array( $this, 'output_quick_view_modal' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'save_post_product', array( $this, 'clear_product_cache' ) );
	}

	/**
	 * Clear cached quick view HTML when a product is updated.
	 *
	 * @param int $post_id Post ID.
	 */
	public function clear_product_cache( $post_id ) {
		delete_transient( 'wc_tdk_qv_' . absint( $post_id ) );
	}

	/**
	 * Enqueue quick view assets on supported pages.
	 */
	public function enqueue_scripts() {
		if ( ! $this->should_enqueue_assets() ) {
			return;
		}

		wc_tdk_enqueue_quick_view_assets();
	}

	/**
	 * Whether quick view assets should load on this request.
	 *
	 * @return bool
	 */
	private function should_enqueue_assets() {
		if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) {
			return true;
		}

		if ( ! is_singular() ) {
			return false;
		}

		$post = get_post();
		if ( ! $post instanceof WP_Post ) {
			return false;
		}

		if ( function_exists( 'has_block' ) && has_block( 'wc-tdk/wc-products', $post ) ) {
			return true;
		}

		$elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
		if ( is_string( $elementor_data ) && false !== strpos( $elementor_data, 'wc-tdk-wc-products' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * AJAX handler for quick view content.
	 */
	public function quick_view_ajax_handler() {
		if ( function_exists( 'session_status' ) && PHP_SESSION_ACTIVE === session_status() ) {
			session_write_close();
		}

		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}

		if ( ! class_exists( 'WooCommerce' ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'WooCommerce is not active.', 'wc-tdk' ),
				)
			);
		}

		if ( ! check_ajax_referer( 'wc_tdk_quick_view_nonce', 'nonce', false ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Security check failed. Please refresh the page.', 'wc-tdk' ),
				),
				403
			);
		}

		if ( ! isset( $_POST['product_id'] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'No product ID provided.', 'wc-tdk' ),
				)
			);
		}

		$product_id = absint( wp_unslash( $_POST['product_id'] ) );
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Product not found.', 'wc-tdk' ),
				)
			);
		}

		$cache_key = 'wc_tdk_qv_' . $product_id;
		$html      = get_transient( $cache_key );

		if ( false === $html ) {
			$html = $this->build_quick_view_html( $product );
			set_transient( $cache_key, $html, 15 * MINUTE_IN_SECONDS );
		}

		wp_send_json_success(
			array(
				'html' => $html,
			)
		);
	}

	/**
	 * Build quick view HTML for a product.
	 *
	 * @param WC_Product $product Product.
	 * @return string
	 */
	private function build_quick_view_html( $product ) {
		$description = $product->get_short_description();

		ob_start();
		?>
		<div class="wc-tdk-quick-view-product">
			<div class="wc-tdk-quick-view-image">
				<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) ); ?>
			</div>
			<div class="wc-tdk-quick-view-details">
				<h2><?php echo esc_html( $product->get_name() ); ?></h2>
				<div class="wc-tdk-quick-view-price">
					<?php echo wp_kses_post( $product->get_price_html() ); ?>
				</div>
				<?php if ( $description ) : ?>
				<div class="wc-tdk-quick-view-description">
					<?php echo wp_kses_post( wp_trim_words( $description, 40, '…' ) ); ?>
				</div>
				<?php endif; ?>
				<div class="wc-tdk-quick-view-add-to-cart">
					<?php echo wp_kses_post( $this->get_add_to_cart_markup( $product ) ); ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Safe add-to-cart / view-product markup for the modal (no template hooks).
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	private function get_add_to_cart_markup( $product ) {
		if ( ! $product->is_purchasable() ) {
			return sprintf(
				'<a href="%1$s" class="button">%2$s</a>',
				esc_url( get_permalink( $product->get_id() ) ),
				esc_html__( 'Read more', 'wc-tdk' )
			);
		}

		if ( $product->is_type( 'simple' ) && $product->is_in_stock() ) {
			$classes = array(
				'button',
				'product_type_simple',
				'add_to_cart_button',
			);

			if ( $product->supports( 'ajax_add_to_cart' ) ) {
				$classes[] = 'ajax_add_to_cart';
			}

			return sprintf(
				'<a href="%1$s" rel="nofollow" data-product_id="%2$d" data-product_sku="%3$s" data-quantity="1" class="%4$s">%5$s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( implode( ' ', $classes ) ),
				esc_html( $product->add_to_cart_text() )
			);
		}

		return sprintf(
			'<a href="%1$s" class="button">%2$s</a>',
			esc_url( get_permalink( $product->get_id() ) ),
			esc_html__( 'View product', 'wc-tdk' )
		);
	}

	/**
	 * Output modal markup in footer.
	 */
	public function output_quick_view_modal() {
		if ( ! $this->should_enqueue_assets() ) {
			return;
		}
		?>
		<div id="wc-tdk-quick-view-modal" class="wc-tdk-quick-view-modal" hidden>
			<div class="wc-tdk-quick-view-overlay" role="presentation"></div>
			<div class="wc-tdk-quick-view-container" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Quick view', 'wc-tdk' ); ?>">
				<button type="button" class="wc-tdk-quick-view-close" aria-label="<?php esc_attr_e( 'Close', 'wc-tdk' ); ?>">&times;</button>
				<div id="wc-tdk-quick-view-content"></div>
			</div>
		</div>
		<?php
	}
}
