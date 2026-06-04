<?php if ( $show_paragraph == 'yes' ) { ?>
<div class="text-paragraph"><?php echo wp_kses( $content, 'post' ); ?></div>
<?php } ?>