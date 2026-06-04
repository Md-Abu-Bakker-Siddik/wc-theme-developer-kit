<?php
if ( ! isset( $settings ) || ! is_array( $settings ) ) {
	$settings = wc_tdk_normalize_template_params( array() );
} else {
	$settings = wc_tdk_normalize_template_params( $settings );
}
$wc_tdk_skin_id    = wc_tdk_get_active_product_skin( $settings );
$wc_tdk_grid_class = wc_tdk_get_product_grid_wrapper_class($settings, 'grid');
?>
<?php if ($the_query->have_posts()) : ?>
	<div class="<?php echo esc_attr($wc_tdk_grid_class); ?>">
		<?php include 'filter.php'; ?>

		<div id="<?php echo esc_attr($holder_id); ?>" class="isotope-layout products grid-<?php echo esc_attr($columns); ?> <?php echo esc_attr($gutter); ?> clearfix">
			<div class="isotope-layout-inner">
				<?php
				while ($the_query->have_posts()) :
					$the_query->the_post();
					include 'filter-term-list-each-post.php';
					?>
				<div class="isotope-item <?php echo esc_attr($term_slugs_list_string); ?>">
					<?php wc_tdk_get_shortcode_shop_template_part('each-item', $wc_tdk_skin_id, 'wc-products/tpl', $settings, false); ?>
				</div>
				<?php endwhile; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
<?php else : ?>
	<?php wc_tdk_no_products_found_text(); ?>
<?php endif; ?>
