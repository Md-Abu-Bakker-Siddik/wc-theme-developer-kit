<?php
/**
 * Elementor helper functions used by WC TDK widgets.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('wc_tdk_is_elementor_pro_activated')) {
    function wc_tdk_is_elementor_pro_activated()
    {
        return defined('ELEMENTOR_PRO_VERSION');
    }
}

if (! function_exists('wc_tdk_get_isotope_holder_ID')) {
    function wc_tdk_get_isotope_holder_ID($prefix = 'wc-tdk')
    {
        return sanitize_html_class($prefix . '-' . wp_unique_id());
    }
}

if (! function_exists('wc_tdk_isotope_gutter_list_elementor')) {
    function wc_tdk_isotope_gutter_list_elementor()
    {
        return array(
            'gutter-0'  => esc_html__('None', 'wc-tdk'),
            'gutter-10' => '10px',
            'gutter-20' => '20px',
            'gutter-30' => '30px',
        );
    }
}

if (! function_exists('wc_tdk_elementor_grid_responsive_columns')) {
    function wc_tdk_elementor_grid_responsive_columns($widget)
    {
        $widget->add_responsive_control(
            'columns_responsive',
            array(
                'label'          => esc_html__('Columns', 'wc-tdk'),
                'type'           => \Elementor\Controls_Manager::NUMBER,
                'min'            => 1,
                'max'            => 6,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'condition'      => array(
                    'display_type!' => array('carousel'),
                ),
            )
        );
    }
}

if (! function_exists('wc_tdk_get_swiper_slider_arraylist')) {
    function wc_tdk_get_swiper_slider_arraylist($widget, $part = 1, $prefix = '', $condition = array())
    {
        if (1 !== (int) $part) {
            return;
        }

        $widget->start_controls_section(
            'swiper_slider_options',
            array(
                'label'     => esc_html__('Carousel Options', 'wc-tdk'),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => ! empty($condition) ? $condition : array(),
            )
        );

        $widget->add_control(
            'slides_to_show',
            array(
                'label'   => esc_html__('Slides to Show', 'wc-tdk'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 6,
                'default' => 3,
            )
        );

        $widget->add_control(
            'autoplay',
            array(
                'label'        => esc_html__('Autoplay', 'wc-tdk'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $widget->add_control(
            'speed',
            array(
                'label'   => esc_html__('Autoplay Speed (ms)', 'wc-tdk'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
            )
        );

        $widget->add_control(
            'infinite',
            array(
                'label'        => esc_html__('Infinite Loop', 'wc-tdk'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $widget->add_control(
            'arrow',
            array(
                'label'        => esc_html__('Show Arrows', 'wc-tdk'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $widget->add_control(
            'bullets',
            array(
                'label'        => esc_html__('Show Pagination', 'wc-tdk'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $widget->end_controls_section();
    }
}

if (! function_exists('wc_tdk_get_swiper_slider_nav_arraylist')) {
    function wc_tdk_get_swiper_slider_nav_arraylist($widget, $part = 1, $prefix = '', $condition = array())
    {
        // Controls are registered inside wc_tdk_get_swiper_slider_arraylist().
    }
}

if (! function_exists('wc_tdk_get_swiper_slider_dots_arraylist')) {
    function wc_tdk_get_swiper_slider_dots_arraylist($widget, $part = 1, $prefix = '', $condition = array())
    {
        // Controls are registered inside wc_tdk_get_swiper_slider_arraylist().
    }
}

if (! function_exists('wc_tdk_get_cat_filter_arraylist')) {
    function wc_tdk_get_cat_filter_arraylist($widget, $part = 1, $condition = array())
    {
        if (1 === (int) $part) {
            $widget->add_control(
                'show_cat_filter',
                array(
                    'label'        => esc_html__('Show Category Filter', 'wc-tdk'),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => '',
                    'condition'    => ! empty($condition) ? $condition : array(),
                )
            );
            return;
        }

        if (2 === (int) $part) {
            $widget->add_control(
                'cat_filter_style',
                array(
                    'label'     => esc_html__('Filter Style', 'wc-tdk'),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => 'filter-style-1',
                    'options'   => array(
                        'filter-style-1' => esc_html__('Style 1', 'wc-tdk'),
                        'filter-style-2' => esc_html__('Style 2', 'wc-tdk'),
                    ),
                    'condition' => array(
                        'show_cat_filter' => 'yes',
                    ),
                )
            );
        }
    }
}

if (! function_exists('wc_tdk_get_button_arraylist')) {
    function wc_tdk_get_button_arraylist($widget, $part = 1, $prefix = '')
    {
        if (1 !== (int) $part) {
            return;
        }

        $widget->add_control(
            $prefix . 'show_view_details_button',
            array(
                'label'        => esc_html__('Show Button', 'wc-tdk'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $widget->add_control(
            $prefix . 'view_details_button_text',
            array(
                'label'     => esc_html__('Button Text', 'wc-tdk'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('View Details', 'wc-tdk'),
                'condition' => array(
                    $prefix . 'show_view_details_button' => 'yes',
                ),
            )
        );
    }
}

if (! function_exists('wc_tdk_get_viewdetails_button_arraylist')) {
    function wc_tdk_get_viewdetails_button_arraylist($widget, $part = 1, $default_text = '', $prefix = '')
    {
        if (1 === (int) $part) {
            $widget->add_control(
                $prefix . 'loadmore_show_view_details_button',
                array(
                    'label'        => esc_html__('Show Load More', 'wc-tdk'),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => '',
                )
            );
            return;
        }

        if (2 === (int) $part) {
            $widget->add_control(
                $prefix . 'loadmore_view_details_button_text',
                array(
                    'label'   => esc_html__('Load More Text', 'wc-tdk'),
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $default_text ? $default_text : esc_html__('Load More', 'wc-tdk'),
                )
            );
        }
    }
}

if (! function_exists('wc_tdk_prepare_widget_skin_for_templates')) {
    function wc_tdk_prepare_widget_skin_for_templates($settings)
    {
        $skin = '';

        if (! empty($settings['_skin'])) {
            $skin = $settings['_skin'];
        }

        if (! $skin) {
            $skin = 'skin-current-theme1';
        }

        $settings['_skin']  = $skin;
        $settings['$_skin'] = $skin;

        if (isset($settings['excerpt_length'])) {
            $settings['skin_current_theme1_excerpt_length'] = $settings['excerpt_length'];
            $settings['skin_current_theme2_excerpt_length'] = $settings['excerpt_length'];
        }

        if (empty($settings['columns'])) {
            $settings['columns'] = 3;
        }

        if (empty($settings['gutter'])) {
            $settings['gutter'] = 'gutter-10';
        }

        return $settings;
    }
}

if (! function_exists('wc_tdk_get_active_product_skin')) {
    /**
     * Resolve active Elementor skin id for product item templates.
     *
     * @param array $settings Widget settings.
     * @return string
     */
    function wc_tdk_get_active_product_skin($settings = array())
    {
        $skin = '';

        if (! empty($settings['_skin'])) {
            $skin = (string) $settings['_skin'];
        } elseif (! empty($settings['$_skin'])) {
            $skin = (string) $settings['$_skin'];
        }

        if (! $skin && class_exists('\Elementor\Plugin')) {
            $document = \Elementor\Plugin::$instance->documents->get_current();

            if ($document && method_exists($document, 'get_settings')) {
                $doc_settings = $document->get_settings();
                if (! empty($doc_settings['_skin'])) {
                    $skin = (string) $doc_settings['_skin'];
                }
            }
        }

        if (! $skin) {
            $skin = 'skin-current-theme1';
        }

        return $skin;
    }
}

if (! function_exists('wc_tdk_enqueue_product_skin_assets')) {
    /**
     * Enqueue CSS for the active product widget skin.
     *
     * @param string $skin_id Skin identifier.
     */
    function wc_tdk_enqueue_product_skin_assets($skin_id)
    {
        wc_tdk_enqueue_woocommerce_product_styles();

        if ('skin-current-theme2' === $skin_id) {
            wp_enqueue_style('wc-tdk-wc-products-skin-2');
        } else {
            wp_enqueue_style('wc-tdk-wc-products-skin-1');
        }

        if (function_exists('wc_tdk_enqueue_quick_view_assets')) {
            wc_tdk_enqueue_quick_view_assets();
        }
    }
}

if (! function_exists('wc_tdk_get_product_grid_wrapper_class')) {
    /**
     * Wrapper classes for product grid layouts.
     *
     * @param array  $settings Widget settings.
     * @param string $layout   grid|masonry|carousel.
     * @return string
     */
    function wc_tdk_get_product_grid_wrapper_class($settings, $layout = 'grid')
    {
        $skin_id = wc_tdk_get_active_product_skin($settings);
        $classes = array(
            'tm-sc-wc-products',
            'tm-sc-wc-products-' . sanitize_html_class($layout),
            'woocommerce',
        );

        if ('skin-current-theme2' === $skin_id) {
            $classes[] = 'wc-tdk-skin-2-shop';
        } else {
            $classes[] = 'wc-tdk-skin-1-shop';
        }

        if (! empty($settings['classes']) && is_array($settings['classes'])) {
            $classes = array_merge($classes, array_filter($settings['classes']));
        } elseif (! empty($settings['custom_css_class'])) {
            $classes[] = sanitize_html_class($settings['custom_css_class']);
        }

        return implode(' ', array_unique(array_filter($classes)));
    }
}
