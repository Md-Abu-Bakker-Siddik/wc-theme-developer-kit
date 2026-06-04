<?php $settings['settings'] = $settings; ?>
<?php if ( $the_query->have_posts() ) : ?>
	<div class="tm-sc-wc-product-tabs woocommerce columns-<?php echo esc_attr($class) ?>">

		<!-- Isotope Gallery Grid -->
		<ul class="product-list products columns-<?php echo esc_attr($class) ?>">

			<!-- the loop -->
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<?php

				$output = '';
				$product_id    = get_the_ID();
				$post          = get_post( $product_id );
				$product_title = get_the_title();

				$product              = new WC_Product( $product_id );
				$attachment_ids       = $product->get_gallery_image_ids();
				$price                = $product->get_price_html();
				$rating               = wc_get_rating_html($product->get_average_rating());
				$product_var          = new WC_Product_Variable( $product_id );
				$available_variations = $product_var->get_available_variations();

				?>

				<li <?php wc_product_class(); ?>>
					<div class="product-wrapper">
						<div class="product-header">
							<?php
								woocommerce_show_product_loop_sale_flash();
								wc_tdk_woocommerce_get_product_label_stock();
								$product_img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), $image_size);
							?>
							<img src="<?php echo esc_url($product_img[0]) ?>" alt="img"/>
							<div class="product-button-holder">
								<?php wc_tdk_render_product_action_buttons(); ?>
							</div>
						</div>
						<div class="product-footer">
							<h5 class="product-title"><a href="<?php echo esc_url(get_permalink( $product_id ));?>"><?php echo get_the_title();?></a></h5>
							<span class="amount"><?php echo $product->get_price_html();?></span>
							<?php echo wc_get_rating_html($product->get_average_rating());?>
							<?php woocommerce_template_loop_add_to_cart(); ?>
						</div>
					</div>
				</li>

			<?php endwhile; ?>
			<!-- end of the loop -->
		</ul>
		<?php wp_reset_postdata(); ?>
	</div>

<?php else : ?>
	<?php wc_tdk_no_products_found_text(); ?>
<?php endif; ?>