<div class="btn-view-details <?php if(isset($button_alignment)) echo esc_attr( $button_alignment );?>">
    <a  
      <?php echo esc_attr($target);?>
      href="<?php echo esc_url( $url );?>"
      class="<?php echo esc_attr(implode(' ', $btn_classes)); ?>">
      <?php if( $add_btnicon_left == "yes" && ! empty( $button_icon_left['value'] ) ) { ?>
      <span class="btn-icon"><?php \Elementor\Icons_Manager::render_icon( $button_icon_left ); ?></span>
      <?php }?>

      <span class="btn-text">
      <?php echo esc_html( $view_details_button_text  ); ?>
      </span>

      <?php if( $add_btnicon_right == "yes" && ! empty( $button_icon_right['value'] ) ) { ?>
      <span class="btn-icon"><?php \Elementor\Icons_Manager::render_icon( $button_icon_right ); ?></span>
      <?php }?>
    </a>
</div>