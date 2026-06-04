<div class="tm-widget-search-form">
    <form role="search" method="get" class="search-form-default" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="search" class="form-control search-field" placeholder="<?php echo esc_attr__( $placeholder_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit"><i class="lnr lnr-icon-search"></i></button>
        <?php if($search_type == "product") {?>
        <input type="hidden" name="post_type" value="product">
        <?php } ?>
    </form>
</div>