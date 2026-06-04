=== WooCommerce Theme Developer Kit ===
Contributors: mdabubakkersiddik
Tags: woocommerce, elementor, gutenberg, products, shop
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Requires Plugins: woocommerce
Stable tag: 1.0.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WooCommerce utilities, product display skins, and optional Elementor widgets / Gutenberg blocks for theme developers.

== Description ==

WooCommerce Theme Developer Kit helps theme developers add common WooCommerce storefront features without bundling proprietary theme frameworks.

**Core features (WooCommerce required):**

* Custom thank you messages per payment gateway (WooCommerce → Settings)
* Optional checkout field tweaks
* AJAX side cart panel
* Percentage sale badges on product loops
* Product quick view modal (AJAX, nonce protected)
* Buy now button (direct to checkout, nonce protected)
* WooCommerce theme support helpers (gallery, wrappers)

**Elementor (optional):** If Elementor is active, additional widgets are registered under the **WC TDK** category (product grids, categories, header cart, search, and more).

**Gutenberg:** Native blocks under the **WooCommerce Theme Developer Kit** block category with server-side rendering.

**WC Products widget/block skins:**

* Skin 1 – Modern Card
* Skin 2 – Classic Shop

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install from the WordPress plugins screen.
2. Activate the plugin.
3. Install and activate [WooCommerce](https://wordpress.org/plugins/woocommerce/).
4. (Optional) Install Elementor for Elementor widgets.
5. Configure thank you messages under **WooCommerce → Settings → Thank You Messages**.

== Frequently Asked Questions ==

= Do I need Elementor? =

No. Core WooCommerce features and Gutenberg blocks work without Elementor. Elementor widgets load only when Elementor is active.

= Does this work with HPOS (custom order tables)? =

Yes. The plugin declares compatibility with WooCommerce custom order tables.

= Does the plugin call external services? =

No. AJAX requests stay on your site (admin-ajax.php) for quick view only.

= What data is stored? =

Thank you message settings are saved in `wp_options` with the `wc_tdk_` prefix. Checkout alternative phone is stored as order meta when enabled. Uninstall removes `wc_tdk_*` options.

== Screenshots ==

1. Thank you messages settings in WooCommerce
2. WC Products widget with Skin 1
3. WC Products widget with Skin 2
4. Gutenberg WC Products block
5. Quick view modal

== Changelog ==

= 1.0.6 =
* Fixed Gutenberg WC Products block ($settings undefined, grid CSS in editor)
* Quick View AJAX 500 fix and faster hover button on product cards
* Template params normalized for all widget/block templates

= 1.0.5 =
* Quick View button layout and icon fix on Skin 1 cards

= 1.0.4 =
* WordPress.org coding standards: security, text domain, uninstall routine
* WooCommerce HPOS compatibility declaration
* Fixed widget template path so product skins load correctly
* Renamed Skin 2 assets (removed third-party theme naming)
* Conditional block asset loading; Buy Now and Quick View nonces

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.6 =
Recommended update for Gutenberg WC Products block and Quick View fixes.
