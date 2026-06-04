<?php

/**
 * Blocks Registry.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

class WC_TDK_Blocks_Registry
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_block_styles'), 9);
        add_action('init', array($this, 'register_blocks'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_assets'));
        add_action('enqueue_block_assets', array($this, 'enqueue_frontend_assets'));
        add_filter('block_categories_all', array($this, 'register_block_categories'));
    }

    /**
     * Register block categories.
     *
     * @param array $categories Block categories.
     * @return array
     */
    public function register_block_categories($categories)
    {
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'wc-tdk',
                    'title' => __('WooCommerce Theme Developer Kit', 'wc-tdk'),
                ),
            )
        );
    }

    /**
     * Register shared block styles early on init.
     */
    public function register_block_styles()
    {
        if (function_exists('wc_tdk_register_wc_product_block_styles')) {
            wc_tdk_register_wc_product_block_styles();
        }
    }

    /**
     * Enqueue editor assets.
     */
    public function enqueue_editor_assets()
    {
        $asset_file = plugin_dir_path(__FILE__) . '../../assets/js/blocks/index.asset.php';

        if (file_exists($asset_file)) {
            $asset = include $asset_file;
        } else {
            $asset = array(
                'dependencies' => array(
                    'wp-blocks',
                    'wp-i18n',
                    'wp-element',
                    'wp-block-editor',
                    'wp-components',
                ),
                'version' => WC_TDK_VERSION,
            );
        }

        wp_enqueue_script(
            'wc-tdk-blocks-editor',
            plugin_dir_url(__FILE__) . '../../assets/js/blocks/index.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_enqueue_style(
            'wc-tdk-blocks-editor',
            plugin_dir_url(__FILE__) . '../../assets/css/blocks/editor.css',
            array(),
            WC_TDK_VERSION
        );

        $this->register_block_styles();
        wp_enqueue_style('wc-tdk-wc-products');
        wp_enqueue_style('wc-tdk-wc-products-skin-1');
        wp_enqueue_style('wc-tdk-wc-products-skin-2');
        wp_enqueue_style('dashicons');
    }

    /**
     * Enqueue frontend assets.
     */
    public function enqueue_frontend_assets()
    {
        if ( is_admin() || ! $this->current_request_has_plugin_blocks() ) {
            return;
        }

        wp_enqueue_style(
            'wc-tdk-blocks-frontend',
            plugin_dir_url( __FILE__ ) . '../../assets/css/blocks/editor.css',
            array(),
            WC_TDK_VERSION
        );
    }

    /**
     * Check if the current request content includes a WC TDK block.
     *
     * @return bool
     */
    private function current_request_has_plugin_blocks() {
        if ( ! function_exists( 'has_block' ) ) {
            return false;
        }

        $post = get_post();
        if ( ! $post instanceof WP_Post ) {
            return false;
        }

        foreach ( $this->get_registered_block_names() as $block ) {
            if ( has_block( 'wc-tdk/' . $block, $post ) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Block slugs registered by this plugin.
     *
     * @return string[]
     */
    private function get_registered_block_names() {
        return array(
            'product-category',
            'product-list',
            'product-tabs',
            'wc-products',
            'info-banner',
            'header-cart',
            'header-search',
            'account',
            'wishlist',
            'vertical-menu',
        );
    }

    /**
     * Register all blocks.
     */
    public function register_blocks()
    {
        // List of blocks to register
        foreach ( $this->get_registered_block_names() as $block ) {
            $this->register_single_block($block);
        }
    }

    /**
     * Register a single block.
     *
     * @param string $block Block name.
     */
    private function register_single_block($block)
    {
        $class_name = 'WC_TDK_Block_' . str_replace('-', '_', ucwords($block, '-'));
        $file_path = plugin_dir_path(__FILE__) . 'class-block-' . $block . '.php';

        if (file_exists($file_path)) {
            require_once $file_path;
            if (class_exists($class_name)) {
                $block_instance = new $class_name();
                $block_instance->register();
            }
        }
    }
}
