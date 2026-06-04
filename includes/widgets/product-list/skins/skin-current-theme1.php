<?php

namespace WC_TDK\Widgets\Product_List\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Skin_Base as Elementor_Skin_Base;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Skin_Current_Theme1 extends Elementor_Skin_Base
{

    protected function _register_controls_actions()
    {
        add_action('elementor/element/tm-ele-product-category/paragraph_opt/after_section_end', [$this, 'register_layout_controls1']);
    }

    public function get_id()
    {
        return 'skin-current-theme1';
    }


    public function get_title()
    {
        return __('Skin - Current Theme1', 'wc-tdk');
    }


    public function register_layout_controls1(Widget_Base $widget)
    {
        $this->parent = $widget;
    }

    public function render()
    {
        $html = '';
        $settings = $this->parent->get_settings_for_display();
        $this->woocommerce_default($settings);
    }

    private function woocommerce_default($settings)
    {
        global $woocommerce;
        $meta_query = '';
        $tax_query = array();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ('recent_products' == $settings['product_type']) {
            $meta_query = WC()->query->get_meta_query();
        }

        if ('featured_products' == $settings['product_type']) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN', // or 'NOT IN' to exclude feature products
            );
        }

        $args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $settings['limit'],
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'paged'               => $paged,
            'meta_query'          => $meta_query,
            'tax_query'          => $tax_query,
        );

        if ('sale_products' == $settings['product_type']) {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['post__in'] = $product_ids_on_sale;
        }

        if ('best_selling_products' == $settings['product_type']) {
            $args['meta_key']   = 'total_sales';
            $args['orderby']    = 'meta_value_num';
        }

        if ('top_rated_products' == $settings['product_type']) {
            $args['meta_key']   = '_wc_average_rating';
            $args['orderby']    = 'meta_value_num';
        }

        //if category selected
        if (! empty($settings['categories'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => implode(',', $settings['categories']),
                )
            );
        }


        $the_query = new \WP_Query($args);
        $settings['the_query'] = $the_query;

        $settings['settings'] = $settings;

        //Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
        $html = wc_tdk_get_shortcode_shop_template_part('product-list-current-theme1', null, 'product-list/tpl', $settings, true);

        wc_tdk_print_template_html( $html );
    }
}
