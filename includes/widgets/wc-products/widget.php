<?php

namespace WC_TDK\Widgets\WC_Products;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class WC_TDK_WC_Products extends Widget_Base
{
    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'wc-tdk-wc-products';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('WC (WooCommerce) Products', 'wc-tdk');
    }

    /**
     * Widget style dependencies.
     *
     * @return array
     */
    public function get_style_depends()
    {
        return array(
            'wc-tdk-wc-products',
            'wc-tdk-wc-products-skin-1',
            'wc-tdk-wc-products-skin-2',
        );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-products';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['wc-tdk'];
    }

    /**
     * Skins
     */
    protected function register_skins()
    {
        $this->add_skin(new Skins\Skin_Current_Theme1($this));
        $this->add_skin(new Skins\Skin_Current_Theme2($this));
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'tm_general',
            [
                'label' => esc_html__('General', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'custom_css_class',
            [
                'label' => esc_html__("Custom CSS class", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'display_type',
            [
                'label' => esc_html__("Display Type", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'grid'  =>  esc_html__('Grid', 'wc-tdk'),
                    'masonry' =>  esc_html__('Masonry', 'wc-tdk'),
                    'carousel' =>  esc_html__('Carousel/Slider', 'wc-tdk'),
                ],
                'default' => 'grid'
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__("Columns Layout", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1'  =>  '1',
                    '2'  =>  '2',
                    '3'  =>  '3',
                    '4'  =>  '4',
                    '5'  =>  '5',
                    '6'  =>  '6',
                ],
                'default' => '3',
                'condition' => [
                    'display_type!' => array('carousel')
                ]
            ]
        );

        //responsive grid layout
        wc_tdk_elementor_grid_responsive_columns($this);

        $this->add_control(
            'gutter',
            [
                'label' => esc_html__("Gutter", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_isotope_gutter_list_elementor(),
                'default' => 'gutter-10',
                'condition' => [
                    'display_type' => array('grid', 'masonry', 'masonry-tiles')
                ]
            ]
        );




        $options_product_type = [
            'recent_products'      => esc_html__('Recent products', 'wc-tdk'),
            'featured_products'    => esc_html__('Featured Products', 'wc-tdk'),
            'top_rated_products'   => esc_html__('Top Rated Products', 'wc-tdk'),
            'sale_products'        => esc_html__('Products on Sale', 'wc-tdk'),
            'best_selling_products' => esc_html__('Best Selling Products', 'wc-tdk')
        ];

        if (wc_tdk_is_elementor_pro_activated()) {
            $options_product_type['ids'] = esc_html__('Product Ids', 'wc-tdk');
        }

        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'wc-tdk'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent_products',
                'options' => $options_product_type,
            ]
        );

        if (wc_tdk_is_elementor_pro_activated()) {
            $this->add_control(
                'product_ids',
                [
                    'label'        => esc_html__('Product ids', 'wc-tdk'),
                    'type'         => \ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'label_block'  => true,
                    'autocomplete' => [
                        'object' => \ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'product',
                        ],
                    ],
                    'multiple'     => true,
                    'condition'    => [
                        'product_type' => 'ids'
                    ]
                ]
            );
        }

        $this->add_control(
            'limit',
            [
                'label'   => esc_html__('Posts Per Page', 'wc-tdk'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );
        $this->add_control(
            'image_size',
            [
                'label' => esc_html__("Choose Image Size", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_get_available_image_sizes(),
                'default' => 'thumbnail',
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label'     => esc_html__('Advanced', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__('Order By', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'       => esc_html__('Date', 'wc-tdk'),
                    'id'         => esc_html__('Post ID', 'wc-tdk'),
                    'menu_order' => esc_html__('Menu Order', 'wc-tdk'),
                    'popularity' => esc_html__('Number of purchases', 'wc-tdk'),
                    'rating'     => esc_html__('Average Product Rating', 'wc-tdk'),
                    'title'      => esc_html__('Product Title', 'wc-tdk'),
                    'rand'       => esc_html__('Random', 'wc-tdk'),
                ],
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__('Order', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'desc',
                'options'   => [
                    'asc'  => esc_html__('ASC', 'wc-tdk'),
                    'desc' => esc_html__('DESC', 'wc-tdk'),
                ],
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'wc-tdk'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $this->get_product_categories(),
                'label_block' => true,
                'multiple'    => true,
                'condition'   => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => esc_html__('Category Operator', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'wc-tdk'),
                    'IN'     => esc_html__('IN', 'wc-tdk'),
                    'NOT IN' => esc_html__('NOT IN', 'wc-tdk'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'       => esc_html__('Tags', 'wc-tdk'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_tags(),
                'multiple'    => true,
                'condition'   => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'tag_operator',
            [
                'label'     => esc_html__('Tag Operator', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'wc-tdk'),
                    'IN'     => esc_html__('IN', 'wc-tdk'),
                    'NOT IN' => esc_html__('NOT IN', 'wc-tdk'),
                ],
                'condition' => [
                    'tag!' => ''
                ],
            ]
        );
        $this->end_controls_section();



        //Swiper Slider Options
        wc_tdk_get_swiper_slider_arraylist($this, 1, '', array('display_type' => array('carousel')));
        wc_tdk_get_swiper_slider_nav_arraylist($this, 1, '', array('display_type' => array('carousel')));
        wc_tdk_get_swiper_slider_dots_arraylist($this, 1, '', array('display_type' => array('carousel')));







        //Category Filter
        $this->start_controls_section(
            'cat_filter_section',
            [
                'label' => esc_html__('Category Filter', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        wc_tdk_get_cat_filter_arraylist($this, 1, array('display_type' => array('grid', 'masonry', 'masonry-tiles', 'carousel')));
        wc_tdk_get_cat_filter_arraylist($this, 2);
        wc_tdk_get_cat_filter_arraylist($this, 3);
        wc_tdk_get_cat_filter_arraylist($this, 4);

        $this->end_controls_section();





        $this->start_controls_section(
            'button_options',
            [
                'label' => esc_html__('Button Options', 'wc-tdk'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        wc_tdk_get_button_arraylist($this, 1);
        $this->add_control(
            'padding-topbottom',
            [
                'label' => esc_html__("Padding Top Bottom", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'selectors' => [
                    '{{WRAPPER}} .btn' => 'padding-top: {{VALUE}};padding-bottom: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'padding-leftright',
            [
                'label' => esc_html__("Padding Left Right", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'selectors' => [
                    '{{WRAPPER}} .btn' => 'padding-left: {{VALUE}};padding-right: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();





        $this->start_controls_section(
            'loadmore_button_options',
            [
                'label' => esc_html__('Loadmore Button Options', 'wc-tdk'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        wc_tdk_get_viewdetails_button_arraylist($this, 1,  esc_html__("Load More", 'wc-tdk'), 'loadmore_');
        wc_tdk_get_viewdetails_button_arraylist($this, 2,  esc_html__("Load More", 'wc-tdk'), 'loadmore_');
        wc_tdk_get_button_arraylist($this, 1, 'loadmore_');
        $this->end_controls_section();
    }

    protected function get_product_categories()
    {
        $categories = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }

    protected function get_product_tags()
    {
        $tags = get_terms(
            array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $results[$tag->slug] = $tag->name;
            }
        }

        return $results;
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['_skin'])) {
            $settings['_skin'] = 'skin-current-theme1';
        }

        $settings['holder_id'] = wc_tdk_get_isotope_holder_ID('wc-product');
        $this->wc_render_output('', $settings);
    }


    public function wc_render_output($class_instance, $settings)
    {
        if (! class_exists('WooCommerce')) {
            echo '<p class="wc-tdk-notice">' . esc_html__('WooCommerce must be active to display products.', 'wc-tdk') . '</p>';
            return;
        }

        $skin_id = wc_tdk_get_active_product_skin($settings);
        wc_tdk_enqueue_product_skin_assets($skin_id);

        $the_query = wc_tdk_run_products_query($settings);
        $settings['the_query'] = $the_query;


        //button classes
        $settings['btn_classes'] = wc_tdk_prepare_button_classes_from_params($settings);
        $settings['loadmore_btn_classes'] = wc_tdk_prepare_button_classes_from_params($settings, 'loadmore_');

        $settings['params_array'] = $settings;


        //classes
        $classes = array();
        $classes[] = $settings['custom_css_class'];
        $settings['classes'] = $classes;

        $settings['settings'] = $settings;
        $settings = wc_tdk_prepare_widget_skin_for_templates($settings);

        $display_type = ! empty($settings['display_type']) ? $settings['display_type'] : 'grid';

        // Produce HTML using skin template.
        $html = wc_tdk_get_shortcode_shop_template_part('wc-products', $display_type, 'wc-products/tpl', $settings, true);

        // Fallback: always show products if the custom template returns nothing.
        if (empty(trim(wp_strip_all_tags($html))) && $the_query->have_posts()) {
            $html = wc_tdk_render_products_loop_fallback($the_query, $settings);
        }

        if (empty(trim(wp_strip_all_tags($html)))) {
            ob_start();
            wc_tdk_no_products_found_text();
            $html = ob_get_clean();
        }

        wc_tdk_print_template_html( $html );
    }
}
