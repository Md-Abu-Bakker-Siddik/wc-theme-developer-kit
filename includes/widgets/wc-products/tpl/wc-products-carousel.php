<?php
if ( ! isset( $settings ) || ! is_array( $settings ) ) {
	$settings = wc_tdk_normalize_template_params( array() );
} else {
	$settings = wc_tdk_normalize_template_params( $settings );
}
$wc_tdk_skin_id         = wc_tdk_get_active_product_skin( $settings );
$wc_tdk_carousel_class  = wc_tdk_get_product_grid_wrapper_class($settings, 'carousel');
$swiper_slide_data_info = wc_tdk_swiper_data_params($settings);
wp_enqueue_style('swiper');
wp_enqueue_script('swiper');
?>
<?php if ($the_query->have_posts()) : ?>
	<div id="<?php echo esc_attr($holder_id); ?>" class="<?php echo esc_attr($wc_tdk_carousel_class); ?> tm-swiper-container" <?php echo html_entity_decode(esc_attr(implode(' ', $swiper_slide_data_info))); ?>>
		<div class="swiper-container-inner carousel-layout products">
			<div class="swiper-wrapper">
				<!-- the loop -->
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div class="swiper-slide">
						<?php wc_tdk_get_shortcode_shop_template_part('each-item', $wc_tdk_skin_id, 'wc-products/tpl', $settings, false); ?>
					</div>
				<?php endwhile; ?>
				<!-- end of the loop -->
				<?php wp_reset_postdata(); ?>
			</div>
		</div>

		<div class="swiper-pagination <?php if( $bullets !== 'yes' ) echo esc_attr( "d-none" ); ?>"></div>

		<div class="tm-swiper-arrow tm-swiper-button-wrap <?php if( $arrow !== 'yes' ) echo esc_attr( "d-none" ); ?>">
			<div class="tm-swiper-arrow tm-swiper-button-prev"><i class="lnr-icon-arrow-left"></i></div>
			<div class="tm-swiper-arrow tm-swiper-button-next"><i class="lnr-icon-arrow-right"></i></div>
		</div>
	</div>

<?php else : ?>
	<?php wc_tdk_no_products_found_text(); ?>
<?php endif; ?>