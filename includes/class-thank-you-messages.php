<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Thank_You_Messages {
    public function __construct() {
        add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
        add_action( 'woocommerce_settings_tabs_wc_tdk_thank_you', array( $this, 'render_settings_tab' ) );
        add_action( 'woocommerce_update_options_wc_tdk_thank_you', array( $this, 'update_settings' ) );
        add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'custom_thank_you_message' ), 10, 2 );
    }

    public function add_settings_tab( $tabs ) {
        $tabs['wc_tdk_thank_you'] = __( 'Thank You Messages', 'wc-tdk' );
        return $tabs;
    }

    public function render_settings_tab() {
        woocommerce_admin_fields( $this->get_settings() );
    }

    public function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Custom Thank You Messages', 'wc-tdk' ),
                'type'     => 'title',
                'desc'     => __( 'Set custom thank you messages for each payment method.', 'wc-tdk' ),
                'id'       => 'wc_tdk_thank_you_section_title',
            ),
        );

        $payment_gateways = WC_Payment_Gateways::instance();
        $gateways = $payment_gateways->payment_gateways();
        $has_enabled = false;

        foreach ( $gateways as $gateway ) {
            if ( 'yes' === $gateway->enabled ) {
                $has_enabled = true;
                $settings['wc_tdk_message_' . $gateway->id] = array(
                    'name'    => sprintf( __( 'Thank you message for %s', 'wc-tdk' ), $gateway->get_title() ),
                    'type'    => 'text',
                    'desc'    => sprintf( __( 'Custom thank you message for %s payments', 'wc-tdk' ), $gateway->get_title() ),
                    'id'      => 'wc_tdk_message_' . $gateway->id,
                    'default' => '',
                );
            }
        }

        if ( ! $has_enabled ) {
            $settings['no_gateways'] = array(
                'name' => __( 'No payment gateways enabled', 'wc-tdk' ),
                'type' => 'title',
                'desc' => __( 'Please enable at least one payment gateway in WooCommerce > Settings > Payments to configure thank you messages.', 'wc-tdk' ),
                'id'   => 'wc_tdk_no_gateways',
            );
        }

        $settings['section_end'] = array(
            'type' => 'sectionend',
            'id'   => 'wc_tdk_thank_you_section_end',
        );

        return apply_filters( 'wc_tdk_thank_you_settings', $settings );
    }

    public function update_settings() {
        woocommerce_update_options( $this->get_settings() );
    }

    public function custom_thank_you_message( $text, $order ) {
        if ( ! is_a( $order, 'WC_Order' ) ) {
            return $text;
        }

        $payment_method = $order->get_payment_method();
        $custom_message = get_option( 'wc_tdk_message_' . $payment_method );

        if ( ! empty( $custom_message ) ) {
            return wpautop( wp_kses_post( $custom_message ) );
        }

        return $text;
    }
}
