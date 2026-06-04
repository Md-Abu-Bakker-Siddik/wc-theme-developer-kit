<?php
	$term_slugs_list = array();
	$term_slugs_list = wp_get_post_terms( get_the_ID(), 'product_cat', array("fields" => "slugs") );
	$term_slugs_list_string = '';
	if(is_array($term_slugs_list)) {
		$term_slugs_list_string = implode( ' ', $term_slugs_list );
	}
?>