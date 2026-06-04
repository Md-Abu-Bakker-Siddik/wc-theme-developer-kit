<?php
namespace WC_TDK\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Header_Cart extends Widget_Base {

    public function get_name() {
        return 'wc-tdk-header-cart';
    }

    public function get_title() {
        return esc_html__( 'Header Cart', 'wc-tdk' );
    }

    public function get_icon() {
        return 'eicon-cart';
    }

    public function get_categories() {
        return [ 'wc-tdk' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'cart_count_style',
            [
                'label' => esc_html__( 'General', 'wc-tdk' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'search_dropdown_content_style',
            [
                'label'   => esc_html__( 'Dropdown Content Style', 'wc-tdk' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-dropdown',
                'options' => [
                    'style-dropdown'    => esc_html__( 'Dropdown', 'wc-tdk' ),
                    'style-no-dropdown' => esc_html__( 'No Dropdown Content', 'wc-tdk' ),
                    'style-side-panel'    => esc_html__( 'Side Panel', 'wc-tdk' ),
                ],
                'prefix_class' => 'tm-header-search-content-',
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => esc_html__( 'Hide Price', 'wc-tdk' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-cart-price-',
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label' => esc_html__( 'Hide Count Items Label', 'wc-tdk' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-cart-count-',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_mini_count',
            [
                'label' => esc_html__( 'Hide Mini Count', 'wc-tdk' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-cart-mini-count-',
            ]
        );
        $this->add_control(
            'show_dropdown',
            [
                'label' => esc_html__( 'Hide Dropdown', 'wc-tdk' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-cart-dropdown-',
            ]
        );
        $this->add_responsive_control(
            'cart_alignment',
            [
                'label' => esc_html__( 'Cart Alignment', 'wc-tdk' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'price_text_options',
            [
                'label' => esc_html__( 'Price Text', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control(
            'price_text_font_size',
            [
                'label' => esc_html__( 'Font Size', 'wc-tdk' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .cart-quick-info' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'count_color',
            [
                'label' => esc_html__( 'Count Color', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .cart-quick-info .count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__( 'Price Color', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .cart-quick-info .amount' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mini_cart_options',
            [
                'label' => esc_html__( 'Cart FlatIcon', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_cart_typography',
                'label' => esc_html__( 'Typography', 'wc-tdk' ),
                'selector' => '{{WRAPPER}} .mini-cart-icon',
            ]
        );
        $this->add_responsive_control(
            'icon_cart_size',
            [
                'label' => esc_html__( 'Icon Size', 'wc-tdk' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_color',
            [
                'label' => esc_html__( 'Icon Color', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_color_hover',
            [
                'label' => esc_html__( 'Icon Color (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_theme_colored',
            [
                'label' => esc_html__( 'Icon Theme Colored', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon' => 'color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_theme_colored_hover',
            [
                'label' => esc_html__( 'Icon Theme Colored (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon' => 'color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mini_cart_count_options',
            [
                'label' => esc_html__( 'Mini Count', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mini_cart_count_bg_options',
            [
                'label' => esc_html__( 'Background Color', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mini_cart_count_bg_color',
            [
                'label' => esc_html__( 'Count BG Color', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .items-count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_bg_color_hover',
            [
                'label' => esc_html__( 'Count BG Color (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_bg_theme_colored',
            [
                'label' => esc_html__( 'Count BG Theme Colored', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .items-count' => 'background-color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_bg_theme_colored_hover',
            [
                'label' => esc_html__( 'Count BG Theme Colored (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'background-color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_text_options',
            [
                'label' => esc_html__( 'Text Color Options', 'wc-tdk' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mini_cart_count_color',
            [
                'label' => esc_html__( 'Count Text Color', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .items-count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_color_hover',
            [
                'label' => esc_html__( 'Count Text Color (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_theme_colored',
            [
                'label' => esc_html__( 'Count Text Theme Colored', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-icon .items-count' => 'color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_control(
            'mini_cart_count_theme_colored_hover',
            [
                'label' => esc_html__( 'Item Count Text Theme Colored (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'wishlist-bg-style',
            [
                'label' => esc_html__( 'Background', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_bg_size',
            [
                'label'     => esc_html__( 'Background Size', 'wc-tdk' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_background_theme_colored',
            [
                'label' => esc_html__( 'Background Theme Colored', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents' => 'background-color: var(--theme-color{{VALUE}});',
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
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_background_theme_colored_hover',
            [
                'label' => esc_html__( 'Background Theme Colored (Hover)', 'wc-tdk' ),
                'type' => Controls_Manager::SELECT,
                'options' => wc_tdk_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents:hover' => 'background-color: var(--theme-color{{VALUE}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_background_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'wc-tdk' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .top-nav-mini-cart-icon-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="woocommerce top-nav-mini-cart-icon-container">
            <div class="top-nav-mini-cart-icon-contents">
                <a class="mini-cart-icon" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wc-tdk' ); ?>">
                    <i class="lnr lnr-icon-cart1"></i>
                    <?php if ( WC()->cart ) { ?>
                        <span class="items-count">
                            <?php echo sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'wc-tdk' ), WC()->cart->get_cart_contents_count() ); ?>
                        </span>
                        <span class="cart-quick-info">
                            <?php echo sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wc-tdk' ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>
                        </span>
                    <?php } ?>
                </a>
                <div class="dropdown-content">
                    <?php if ( WC()->cart ) {
                        woocommerce_mini_cart();
                    } ?>
                </div>
            </div>
        </div>
        <?php
    }
}
