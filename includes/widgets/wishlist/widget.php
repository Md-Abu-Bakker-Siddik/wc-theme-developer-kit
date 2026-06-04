<?php
namespace WC_TDK\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Wishlist extends Widget_Base {

    public function get_name() {
        return 'wc-tdk-wishlist';
    }

    public function get_title() {
        return esc_html__( 'Wishlist', 'wc-tdk' );
    }

    public function get_icon() {
        return 'eicon-heart';
    }

    public function get_categories() {
        return [ 'wc-tdk' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'wishlist-icon-style',
            [
                'label' => esc_html__( 'Icon', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_account_size',
            [
                'label'     => esc_html__( 'Size Icon', 'wc-tdk' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tm-header-wishlist .header-wishlist i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tm-header-wishlist .header-wishlist:not(:hover) i' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .tm-header-wishlist:hover .header-wishlist i' => 'color: {{VALUE}};',
                ],
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
                'selectors'   => [
                    '{{WRAPPER}} .site-header-wishlist' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wishlist-count-style',
            [
                'label' => esc_html__( 'Count', 'wc-tdk' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'count_color',
            [
                'label'     => esc_html__( 'Color', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tm-header-wishlist .header-wishlist .count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_background_color',
            [
                'label'     => esc_html__( 'Background', 'wc-tdk' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tm-header-wishlist .header-wishlist .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label'        => esc_html__( 'Hide Count', 'wc-tdk' ),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-count-wishlist-',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'wrapper', 'class', 'wc-tdk-wishlist-wrapper' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php
            if ( function_exists( 'woosw_init' ) ) {
                add_action( 'wp_footer', 'organey_wishlist_canvas', 1 );
                $key = \WPCleverWoosw::get_key();
                ?>
                <div class="tm-header-wishlist woosw-check">
                    <a class="header-wishlist" data-toggle="button-side" data-target=".tm-wishlist-side" href="<?php echo esc_url( \WPCleverWoosw::get_url( $key, true ) ); ?>">
                        <i class="lnr lnr-icon-heart"></i>
                        <span class="count"><?php echo esc_html( \WPCleverWoosw::get_count( $key ) ); ?></span>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
