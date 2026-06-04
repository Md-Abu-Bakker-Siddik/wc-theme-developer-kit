
<?php
if (class_exists('Woocommerce')) :
    $term = get_terms(array('taxonomy' => 'product_cat'));
    $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
    $myaccount_page_url = '';
    $myaccount_page_url = get_permalink( $myaccount_page );
    ?>
<div class="tm-widget-search-form">
    <form role="search" method="get" class="search-form-cat" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="product-search-category">
            <select name="product_cat">
                <option value=""><?php esc_html_e('Select a Category', 'wc-tdk'); ?></option>
                <?php
                foreach ($term as $key => $value) {
                    echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                } ?>
            </select>
        </div>
        <div class="product-search-meta">
            <input type="search" class="form-control search-field" placeholder="<?php echo esc_attr__( $placeholder_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <button type="submit" class="search-submit"><i class="lnr lnr-icon-search"></i></button>
            <input type="hidden" name="post_type" value="product">
        </div>
    </form>
</div>
    <?php endif;
?>
