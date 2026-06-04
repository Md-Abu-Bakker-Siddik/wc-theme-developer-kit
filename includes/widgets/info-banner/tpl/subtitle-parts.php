
		<?php 
		foreach (  $subtitle_list as $item ) {
			$subtitle_part_classes = array();
			$subtitle_part_classes[] = 'elementor-repeater-item-'.$item['_id'];
			?>
			<span class="<?php echo esc_attr(implode(' ', $subtitle_part_classes)); ?>"><?php echo esc_html( $item['subtitle_other_text'] );?></span>
		<?php } ?>