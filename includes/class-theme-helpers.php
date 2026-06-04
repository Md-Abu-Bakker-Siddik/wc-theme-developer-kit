<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Theme_Helpers {
    public function __construct() {
        add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
    }

    public function add_theme_supports() {
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}
