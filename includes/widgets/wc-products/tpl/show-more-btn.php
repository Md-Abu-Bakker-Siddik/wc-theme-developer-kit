
	<?php if (  $loadmore_show_view_details_button === 'yes' && $the_query->max_num_pages > 1 ) { ?>
		<div class="clearfix"></div>
		<div class="tm-loadmore-container">
			<button 
				id="tm-loadmore-btn-<?php echo esc_attr( $holder_id );?>"
				data-target="<?php echo esc_attr( $holder_id );?>"
			  	class="tm-btn-loadmore <?php echo esc_attr(implode(' - ', $loadmore_btn_classes)); ?>">
			 	<?php echo esc_html( $loadmore_view_details_button_text  ); ?>
			</button>
		</div>
	<?php } ?>