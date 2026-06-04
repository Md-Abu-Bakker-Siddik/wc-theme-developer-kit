<?php
namespace WC_TDK\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Account extends Widget_Base {

    public function get_name() {
        return 'wc-tdk-account';
    }

    public function get_title() {
        return esc_html__( 'My Account', 'wc-tdk' );
    }

    public function get_icon() {
        return 'eicon-user';
    }

    public function get_categories() {
        return [ 'wc-tdk' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'account_icon_style',
            [
                'label' => esc_html__('Icon', 'wc-tdk'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_account_size',
            [
                'label'     => esc_html__('Size Icon', 'wc-tdk'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-header-account .header-account i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'wc-tdk'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account .header-account:not(:hover) i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Icon Color Hover', 'wc-tdk'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account .header-account:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'account_alignment',
            [
                'label' => esc_html__('Alignment', 'wc-tdk'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wc-tdk'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wc-tdk'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wc-tdk'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'label_block' => false,
                'selectors'   => [
                    '{{WRAPPER}} .site-header-account' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div>
            <?php
            if ( function_exists( 'wc_get_page_id' ) ) :
                $myaccount_url = wc_get_page_permalink( 'myaccount' );
                ?>
                <div class="site-header-account">
                    <a class="header-account" href="<?php echo esc_url( $myaccount_url ); ?>">
                        <i class="lnr lnr-icon-user"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
