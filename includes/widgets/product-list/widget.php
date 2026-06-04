<?php

namespace WC_TDK\Widgets\Product_List;

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
class WC_TDK_Product_List extends Widget_Base
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
        return 'wc-tdk-product-list';
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
        return esc_html__('Product List', 'wc-tdk');
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

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Settings', 'wc-tdk'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'style_list',
            [
                'label'     => esc_html__('List Style', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 1,
                'options'   => [
                    1 => esc_html__('Style 1', 'wc-tdk'),
                    2 => esc_html__('Style 2', 'wc-tdk'),
                ],
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

        $this->add_responsive_control(
            'column',
            [
                'label'          => esc_html__('columns', 'wc-tdk'),
                'type'           => \Elementor\Controls_Manager::SELECT,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options'        => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
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
















        //Content Options
        $this->start_controls_section(
            'title_styling_options',
            [
                'label' => esc_html__('Title Styling', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'wc-tdk'),
                'selector' => '{{WRAPPER}} .product .product-title,{{WRAPPER}} .product .product-title a',
            ]
        );
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__("Title Text Color", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product .product-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product .product-title a' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'title_text_color_hover',
            [
                'label' => esc_html__("Title Text Color (Hover)", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product .product-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product .product-title a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'title_theme_colored',
            [
                'label' => esc_html__("Title Theme Colored", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product .product-title' => 'color: var(--theme-color{{VALUE}});',
                    '{{WRAPPER}} .product .product-title a' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'title_theme_colored_hover',
            [
                'label' => esc_html__("Title Theme Colored (Hover)", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product .product-title:hover' => 'color: var(--theme-color{{VALUE}});',
                    '{{WRAPPER}} .product .product-title a:hover' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product .product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();





        $this->start_controls_section(
            'amount_styling_options',
            [
                'label' => esc_html__('Price Amount Styling', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'amount_typography',
                'label' => esc_html__('Typography', 'wc-tdk'),
                'selector' => '{{WRAPPER}} .product .amount',
            ]
        );
        $this->add_control(
            'amount_text_color',
            [
                'label' => esc_html__("Text Color", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product .amount' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'amount_text_color_hover',
            [
                'label' => esc_html__("Text Color (Hover)", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product:hover .entry-meta' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'amount_theme_colored',
            [
                'label' => esc_html__("Text Theme Colored", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product .amount' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'amount_theme_colored_hover',
            [
                'label' => esc_html__("Text Theme Colored (Hover)", 'wc-tdk'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product:hover .entry-meta' => 'color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'amount_margin',
            [
                'label' => esc_html__('Margin', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product .amount' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();








        //Features
        $this->start_controls_section(
            'list_styling',
            [
                'label' => esc_html__('List Styling', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control(
            'list_margin',
            [
                'label' => esc_html__('Margin', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_padding',
            [
                'label' => esc_html__('Padding', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'list_border',
                'label' => esc_html__('List Border', 'wc-tdk'),
                'selector' => '{{WRAPPER}} .product',
            ]
        );
        $this->end_controls_section();




        $this->start_controls_section(
            'last_item_options',
            [
                'label' => esc_html__('Last Child Styling', 'wc-tdk'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control(
            'last_item_margin',
            [
                'label' => esc_html__('Item Margin', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'last_item_padding',
            [
                'label' => esc_html__('Item Padding', 'wc-tdk'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'last_item_border',
                'label' => esc_html__('Border', 'wc-tdk'),
                'selector' => '{{WRAPPER}} .product:last-child',
            ]
        );
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
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->woocommerce_default($settings);
    }

    private function woocommerce_default($settings)
    {
        if (! class_exists('WooCommerce')) {
            echo '<p class="wc-tdk-notice">' . esc_html__('WooCommerce must be active to display products.', 'wc-tdk') . '</p>';
            return;
        }

        $the_query = wc_tdk_run_products_query($settings);
        $settings['the_query'] = $the_query;

        $settings['settings'] = $settings;

        //Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
        $html = wc_tdk_get_shortcode_shop_template_part('product-list', null, 'product-list/tpl', $settings, true);

        wc_tdk_print_template_html( $html );
    }
}
