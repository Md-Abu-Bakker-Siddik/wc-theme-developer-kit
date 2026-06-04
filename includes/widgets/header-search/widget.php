<?php
namespace WC_TDK\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Header_Search extends Widget_Base {

    public function get_name() {
        return 'wc-tdk-header-search';
    }

    public function get_title() {
        return esc_html__( 'Header Search', 'wc-tdk' );
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return [ 'wc-tdk' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'search-form-settings',
            [
                'label' => esc_html__( 'Settings', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $this->add_control(
            'search_layout',
            [
                'label'   => esc_html__( 'Layout', 'wc-tdk' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Search Form', 'wc-tdk' ),
                    'form-cat' => esc_html__( 'Search Form with Category', 'wc-tdk' ),
                    'icon'    => esc_html__( 'Icon', 'wc-tdk' ),
                ],
            ]
        );

        $this->add_control(
            'search_type',
            [
                'label'   => esc_html__( 'Search Type', 'wc-tdk' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default Search', 'wc-tdk' ),
                    'product' => esc_html__( 'Product Search', 'wc-tdk' ),
                ],
                'condition' => [
                    'search_layout!' => [ 'form-cat' ]
                ]
            ]
        );

        $this->add_control(
            'search_submit_style',
            [
                'label'   => esc_html__( 'Submit Button Style', 'wc-tdk' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'submit-icon',
                'options' => [
                    'submit-text' => esc_html__( 'Submit Text', 'wc-tdk' ),
                    'submit-icon'    => esc_html__( 'Submit Icon', 'wc-tdk' ),
                ],
                'prefix_class' => 'search-',
                'condition' => [
                    'search_layout!' => [ 'icon' ]
                ]
            ]
        );

        $this->add_responsive_control(
            'search_layout_alignment',
            [
                'label'       => esc_html__( 'Alignment', 'wc-tdk' ),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'left',
                'options'     => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'wc-tdk' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'wc-tdk' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'wc-tdk' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'label_block' => false,
                'selectors'   => [
                    '{{WRAPPER}} .tm-widget-search-form' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'search_layout' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'placeholder_text',
            [
                'label' => esc_html__( "Placeholder Text", 'wc-tdk' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( "Search Product...", 'wc-tdk' ),
                'condition' => [
                    'search_layout!' => 'icon'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'form_cat_search-form-style',
            [
                'label' => esc_html__( 'Style Form', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'form-cat'
                ]
            ]
        );
        $this->add_control(
            'border_color_options',
            [
                'label' => esc_html__( 'Border Option', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'form_cat_border_width',
            [
                'label'      => esc_html__( 'Border width', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .search-form-cat' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .search-form-cat' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_cat_icon_color_form',
            [
                'label'     => esc_html__( 'Color Icon', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_cat_input_field_options',
            [
                'label' => esc_html__( 'Input Field Options', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_background_form',
            [
                'label'     => esc_html__( 'Background', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_input_text_color',
            [
                'label'     => esc_html__( 'Input Text Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_input_placeholder_color',
            [
                'label'     => esc_html__( 'Placeholder Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_cat_submit_button_options',
            [
                'label' => esc_html__( 'Submit Button Options', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_submit_button_bg_theme_colored',
            [
                'label' => esc_html__( "Icon BG Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'form_cat_submit_button_bg_theme_colored_hover',
            [
                'label' => esc_html__( "Icon BG Theme Colored (Hover)", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .search-submit:hover' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'form_cat_submit_button_custom_bg_color',
            [
                'label' => esc_html__( "Icon BG Custom Color", 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'form_cat_submit_button_custom_bg_color_hover',
            [
                'label' => esc_html__( "Icon BG Custom Color (Hover)", 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-submit:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'form_cat_submit_icon_options',
            [
                'label' => esc_html__( 'Submit Search Icon Options', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_submit_icon_color',
            [
                'label' => esc_html__( "Search Icon Color", 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'form_cat_submit_icon_color_hover',
            [
                'label' => esc_html__( "Search Icon Color (Hover)", 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} form button:hover i' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'form_cat_submit_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'search-form-style',
            [
                'label' => esc_html__( 'Style Form', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_responsive_control(
            'border_width',
            [
                'label'      => esc_html__( 'Border width', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form input[type=search]' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'wc-tdk' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}  form input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__( 'Border Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_border_theme_colored',
            [
                'label' => esc_html__( "Border Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'border_color_focus',
            [
                'label'     => esc_html__( 'Border Color Focus', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_border_theme_colored_focus',
            [
                'label' => esc_html__( "Border Focus Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]:focus' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'background_form',
            [
                'label'     => esc_html__( 'Background Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_bg_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'search-form-text-style',
            [
                'label' => esc_html__( 'Style Form - Input Text', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_control(
            'input_text_color',
            [
                'label'     => esc_html__( 'Input Text Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => esc_html__( 'Placeholder Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'search-form-submit-btn-style',
            [
                'label' => esc_html__( 'Style Form - Submit Button', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_responsive_control(
            'form_submit_bg_size',
            [
                'label'     => esc_html__( 'Submit Button Background Size', 'wc-tdk' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_pos_top',
            [
                'label'     => esc_html__( 'Position - Top', 'wc-tdk' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_pos_right',
            [
                'label'     => esc_html__( 'Position - Right', 'wc-tdk' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_form',
            [
                'label'     => esc_html__( 'Color Icon', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_form_hover',
            [
                'label'     => esc_html__( 'Color Icon (Hover)', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_border_width',
            [
                'label'      => esc_html__( 'Border width', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button' => 'border-width: {{SIZE}}{{UNIT}};border-style: solid;',
                ],
            ]
        );
        $this->add_control(
            'icon_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'wc-tdk' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}  form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_theme_colored',
            [
                'label' => esc_html__( "Border Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color (Hover)', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_theme_colored_hover',
            [
                'label' => esc_html__( "Border (Hover) Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_background_color_hover',
            [
                'label'     => esc_html__( 'Background Color (Hover)', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored_hover',
            [
                'label' => esc_html__( "Background Theme Colored (Hover)", 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'search-icon-form-style',
            [
                'label' => esc_html__( 'Style Icon', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'icon'
                ]
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-search-popup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__( 'Icon Color Hover', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-search-popup:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'wc-tdk' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .icon-search-popup' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $search_layout = $settings['search_layout'];
        $placeholder_text = $settings['placeholder_text'];
        $search_type = $settings['search_type'];

        if ($search_layout == 'default') : ?>
            <div class="tm-widget-search-form">
                <form role="search" method="get" class="search-form-default" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="form-control search-field" placeholder="<?php echo esc_attr( $placeholder_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit"><i class="lnr lnr-icon-search"></i></button>
                    <?php if($search_type == "product") {?>
                        <input type="hidden" name="post_type" value="product">
                    <?php } ?>
                </form>
            </div>
        <?php elseif ($search_layout == 'form-cat') : ?>
            <?php if (class_exists('WooCommerce')) :
                $term = get_terms(array('taxonomy' => 'product_cat'));
                ?>
                <div class="tm-widget-search-form">
                    <form role="search" method="get" class="search-form-cat" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="product-search-category">
                            <select name="product_cat">
                                <option value=""><?php esc_html_e('Select a Category', 'wc-tdk'); ?></option>
                                <?php
                                foreach ($term as $key => $value) {
                                    echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="product-search-meta">
                            <input type="search" class="form-control search-field" placeholder="<?php echo esc_attr( $placeholder_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit"><i class="lnr lnr-icon-search"></i></button>
                            <input type="hidden" name="post_type" value="product">
                        </div>
                    </form>
                </div>
            <?php endif;
        elseif ($search_layout == 'icon') : ?>
            <div class="tm-widget-search-form">
                <a aria-label="Search" href="#" class="icon-search-popup"><i class="lnr lnr-icon-search"></i></a>
            </div>
        <?php endif;
    }
}
