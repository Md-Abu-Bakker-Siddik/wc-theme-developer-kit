<div class="woocommerce top-nav-mini-cart-icon-container">
	<div class="top-nav-mini-cart-icon-contents">
		<a class="mini-cart-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wc-tdk' ); ?>"><i class="lnr lnr-icon-cart1"></i>
			<?php if ( WC()->cart ) { ?>
			<span class="items-count"><?php echo esc_html( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'wc-tdk' ), WC()->cart->get_cart_contents_count() ) ); ?></span> <span class="cart-quick-info"><?php echo esc_html( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wc-tdk' ), WC()->cart->get_cart_contents_count() ) ); ?> - <?php echo wp_kses_post( WC()->cart->get_cart_total() ); ?></span>
			<?php } ?>
		</a>

		<div class="dropdown-content">
			<?php if ( WC()->cart ) { ?>
			<?php woocommerce_mini_cart(); ?>
			<?php } ?>
		</div>
	</div>
</div>
