
	<?php if ( isset( $show_cat_filter ) && 'yes' === $show_cat_filter ) : ?>
	<?php
		$portfolio_filters = wc_tdk_get_product_cat_filters_from_query( $the_query );
	?>
	<!-- Isotope Filter -->
	<div class="isotope-layout-filter <?php echo esc_attr( $cat_filter_style ?? '' ); ?>" data-link-with="<?php echo esc_attr( $holder_id ); ?>">
		<a href="#" class="active" data-filter="*"><?php echo esc_html( wc_tdk_isotope_filter_all_text() ); ?></a>
		<?php if ( ! empty( $portfolio_filters ) ) { foreach ( $portfolio_filters as $slug => $name ) { ?>
		<a href="#<?php echo esc_attr( $slug ); ?>" class="" data-filter=".<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></a>
		<?php } } ?>
	</div>
	<!-- End Isotope Filter -->
	<?php endif; ?>
