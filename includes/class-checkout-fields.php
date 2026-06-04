<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_TDK_Checkout_Fields {
    public function __construct() {
        add_filter( 'woocommerce_checkout_fields', array( $this, 'optimize_checkout_fields' ) );
        add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_alternative_phone' ) );
        add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'display_alternative_phone_admin' ) );
    }

    public function optimize_checkout_fields( $fields ) {
        // Remove unnecessary fields to speed up checkout
        unset( $fields['billing']['billing_company'] );
        unset( $fields['billing']['billing_address_2'] );
        unset( $fields['order']['order_comments'] );

        // Add custom alternative phone field
        $fields['billing']['billing_alternative_phone'] = array(
            'type'        => 'tel',
            'label'       => __( 'Alternative Phone Number', 'wc-tdk' ),
            'placeholder' => __( 'e.g. 017XXXXXXXX', 'wc-tdk' ),
            'required'    => false,
            'class'       => array( 'form-row-wide' ),
            'priority'    => 25,
        );

        return $fields;
    }

    public function save_alternative_phone( $order_id ) {
        if ( isset( $_POST['billing_alternative_phone'] ) && '' !== $_POST['billing_alternative_phone'] ) {
            $order = wc_get_order( $order_id );
            if ( $order ) {
                $phone = sanitize_text_field( wp_unslash( $_POST['billing_alternative_phone'] ) );
                $order->update_meta_data( '_billing_alternative_phone', $phone );
                $order->save();
            }
        }
    }

    public function display_alternative_phone_admin( $order ) {
        $alternative_phone = $order->get_meta( '_billing_alternative_phone', true );
        if ( ! empty( $alternative_phone ) ) {
            echo '<p><strong>' . esc_html__( 'Alternative Phone:', 'wc-tdk' ) . '</strong><br>' . esc_html( $alternative_phone ) . '</p>';
        }
    }
}
