<?php

/**
 * Elementor Widgets Manager
 *
 * @package WooCommerce_Theme_Developer_Kit
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class WC_TDK_Elementor_Widgets
 */
class WC_TDK_Elementor_Widgets
{

    /**
     * Constructor
     */
    public function __construct() {
        // Widget category registration
        add_action('elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories'));
        
        // Widget registration (modern Elementor hook)
        add_action('elementor/widgets/register', array($this, 'register_widgets'));
        
        // Register then enqueue assets
        add_action('wp_enqueue_scripts', array($this, 'register_assets'), 5);
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'enqueue_styles'));
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'register_assets'));
        add_action('elementor/preview/enqueue_styles', array($this, 'enqueue_styles'));
    }

    /**
     * Register styles and scripts for Elementor widgets.
     */
    public function register_assets()
    {
        wp_register_style(
            'wc-tdk-header-cart',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/header-cart.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-info-banner',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/info-banner.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-info-banner-advanced',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/info-banner-advanced/info-banner-advanced.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-product-category',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/product-category/product-category-loader.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-product-list',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/product-list/product-list-loader.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-product-tabs',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/product-tabs.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-vertical-menu',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/vertical-menu.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wishlist',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wishlist.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wc-products',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-loader.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wc-products-skin-1',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-skin-1.css',
            array('wc-tdk-wc-products'),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wc-products-skin-2',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-skin-2.css',
            array('wc-tdk-wc-products'),
            WC_TDK_VERSION
        );
    }

    /**
     * Add Elementor Widget Category
     *
     * @param \Elementor\Elements_Manager $elements_manager Elements manager.
     */
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'wc-tdk',
            array(
                'title' => esc_html__('WooCommerce Theme Developer Kit', 'wc-tdk'),
                'icon'  => 'fa fa-plug',
            )
        );
    }

    /**
     * Register Widgets
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager.
     */
    public function register_widgets($widgets_manager) {
        try {
            // Require all widget files.
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/account/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/header-cart/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/header-search/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/info-banner/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-list/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-tabs/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/vertical-menu/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/wc-products/widget.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/wishlist/widget.php';

            // Require skins for product category.
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/skins/skin-current-theme1.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/skins/skin-current-theme2.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/skins/skin-current-theme3.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/skins/skin-current-theme4.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-category/skins/skin-current-theme5.php';

            // Require skins for product list.
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/product-list/skins/skin-current-theme1.php';

            // Require skins for wc products.
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/wc-products/skins/skin-current-theme1.php';
            require_once WC_TDK_PLUGIN_DIR . 'includes/widgets/wc-products/skins/skin-current-theme2.php';

            // Register widgets.
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Account());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Header_Cart());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Header_Search());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Info_Banner());
            $widgets_manager->register(new \WC_TDK\Widgets\Product_Category\WC_TDK_Product_Category());
            $widgets_manager->register(new \WC_TDK\Widgets\Product_List\WC_TDK_Product_List());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Product_Tabs());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Vertical_Menu());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_Products\WC_TDK_WC_Products());
            $widgets_manager->register(new \WC_TDK\Widgets\WC_TDK_Wishlist());
        } catch (\Throwable $e) {
            error_log('WC TDK Elementor Widget Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
        }
    }

    /**
     * Enqueue Styles
     */
    public function enqueue_styles()
    {
        $this->register_assets();

        if ($this->is_elementor_editor_panel()) {
            return;
        }

        wp_enqueue_style('wc-tdk-header-cart');
        wp_enqueue_style('wc-tdk-info-banner');
        wp_enqueue_style('wc-tdk-info-banner-advanced');
        wp_enqueue_style('wc-tdk-product-category');
        wp_enqueue_style('wc-tdk-product-list');
        wp_enqueue_style('wc-tdk-product-tabs');
        wp_enqueue_style('wc-tdk-vertical-menu');
        wp_enqueue_style('wc-tdk-wishlist');
        wp_enqueue_style('wc-tdk-wc-products');
    }

    /**
     * Enqueue Scripts
     */
    public function enqueue_scripts()
    {
        if ($this->is_elementor_editor_panel()) {
            return;
        }

        $this->register_assets();

        wp_enqueue_script(
            'wc-tdk-header-cart',
            WC_TDK_PLUGIN_URL . 'assets/js/woo/header-cart.js',
            array('jquery'),
            WC_TDK_VERSION,
            true
        );

        wp_enqueue_script(
            'wc-tdk-header-search-popup',
            WC_TDK_PLUGIN_URL . 'assets/js/woo/header-search-popup.js',
            array('jquery'),
            WC_TDK_VERSION,
            true
        );

        wp_enqueue_script(
            'wc-tdk-info-banner',
            WC_TDK_PLUGIN_URL . 'assets/js/woo/info-banner.js',
            array('jquery'),
            WC_TDK_VERSION,
            true
        );

        wp_enqueue_script(
            'wc-tdk-product-tabs',
            WC_TDK_PLUGIN_URL . 'assets/js/woo/product-tabs.js',
            array('jquery'),
            WC_TDK_VERSION,
            true
        );

        wp_enqueue_script(
            'wc-tdk-wishlist',
            WC_TDK_PLUGIN_URL . 'assets/js/woo/wishlist.js',
            array('jquery'),
            WC_TDK_VERSION,
            true
        );
    }

    /**
     * True when loading the Elementor sidebar editor (not the preview iframe).
     *
     * @return bool
     */
    private function is_elementor_editor_panel()
    {
        if (! class_exists('\Elementor\Plugin')) {
            return false;
        }

        return \Elementor\Plugin::$instance->editor->is_edit_mode()
            && ! \Elementor\Plugin::$instance->preview->is_preview_mode();
    }
}
