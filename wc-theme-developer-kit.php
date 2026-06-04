<?php
/**
 * Plugin Name:       WooCommerce Theme Developer Kit
 * Plugin URI:        https://wordpress.org/plugins/wc-theme-developer-kit/
 * Description:       WooCommerce utilities and Elementor/Gutenberg blocks for theme developers.
 * Version:           1.0.8
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Requires Plugins:  woocommerce
 * Author:            mdabubakkersiddik
 * Author URI:        https://profiles.wordpress.org/mdabubakkersiddik/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wc-tdk
 * Domain Path:       /languages
 *
 * @package WC_TDK
 */

defined( 'ABSPATH' ) || exit;

define( 'WC_TDK_VERSION', '1.0.8' );
define( 'WC_TDK_PLUGIN_FILE', __FILE__ );
define( 'WC_TDK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WC_TDK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WC_TDK_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load plugin text domain.
 */
function wc_tdk_load_textdomain() {
	load_plugin_textdomain( 'wc-tdk', false, dirname( WC_TDK_PLUGIN_BASENAME ) . '/languages' );
}
add_action( 'init', 'wc_tdk_load_textdomain' );

/**
 * Declare compatibility with WooCommerce features.
 */
function wc_tdk_declare_wc_compatibility() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', WC_TDK_PLUGIN_FILE, true );
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', WC_TDK_PLUGIN_FILE, true );
	}
}
add_action( 'before_woocommerce_init', 'wc_tdk_declare_wc_compatibility' );

/**
 * Bootstrap plugin components.
 */
function wc_tdk_initialize_plugin() {
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-helper-functions.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-elementor-helpers.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-theme-helpers.php';

	new WC_TDK_Theme_Helpers();

	add_action( 'plugins_loaded', 'wc_tdk_register_elementor_widgets', 20 );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wc_tdk_woocommerce_missing_notice' );
		return;
	}

	require_once WC_TDK_PLUGIN_DIR . 'includes/blocks/class-blocks-registry.php';
	new WC_TDK_Blocks_Registry();

	require_once WC_TDK_PLUGIN_DIR . 'includes/class-thank-you-messages.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-checkout-fields.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-ajax-side-cart.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-product-badges.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-quick-view.php';
	require_once WC_TDK_PLUGIN_DIR . 'includes/class-direct-checkout.php';

	new WC_TDK_Thank_You_Messages();
	new WC_TDK_Checkout_Fields();
	new WC_TDK_AJAX_Side_Cart();
	new WC_TDK_Product_Badges();
	new WC_TDK_Quick_View();
	new WC_TDK_Direct_Checkout();
}
add_action( 'plugins_loaded', 'wc_tdk_initialize_plugin' );

/**
 * Admin notice when WooCommerce is inactive.
 */
function wc_tdk_woocommerce_missing_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		esc_html__( 'WooCommerce Theme Developer Kit requires WooCommerce to be installed and active.', 'wc-tdk' )
	);
}

/**
 * Register Elementor widgets when Elementor is available.
 */
function wc_tdk_register_elementor_widgets() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	require_once WC_TDK_PLUGIN_DIR . 'includes/class-elementor-widgets.php';
	new WC_TDK_Elementor_Widgets();
}
