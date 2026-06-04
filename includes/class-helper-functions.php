<?php
if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('wc_tdk_theme_color_list')) {
    function wc_tdk_theme_color_list()
    {
        $theme_color_list = array(
            ''  => esc_html__('No', 'wc-tdk'),
            '1' => esc_html__('Theme Color 1', 'wc-tdk'),
            '2' => esc_html__('Theme Color 2', 'wc-tdk'),
            '3' => esc_html__('Theme Color 3', 'wc-tdk'),
            '4' => esc_html__('Theme Color 4', 'wc-tdk')
        );
        return $theme_color_list;
    }
}

if (! function_exists('wc_tdk_heading_tag_list')) {
    function wc_tdk_heading_tag_list()
    {
        $heading_tag_list = array(
            ''   => '',
            'h1' => 'h1',
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'h5' => 'h5',
            'h6' => 'h6',
            'p'  => 'p',
            'a'  => 'a',
            'span' => 'span',
            'div' => 'div',
        );
        return $heading_tag_list;
    }
}

if (! function_exists('wc_tdk_disply_flex_vertical_align_elementor')) {
    function wc_tdk_disply_flex_vertical_align_elementor()
    {
        $list = array(
            '' => esc_html__('Default', 'wc-tdk'),
            'flex-start' => esc_html__('Top', 'wc-tdk'),
            'center' => esc_html__('Middle', 'wc-tdk'),
            'flex-end' => esc_html__('Bottom', 'wc-tdk'),
            'stretch' => esc_html__('Stretch', 'wc-tdk'),
        );
        return $list;
    }
}

if (! function_exists('wc_tdk_disply_flex_horizontal_align_elementor')) {
    function wc_tdk_disply_flex_horizontal_align_elementor()
    {
        $list = array(
            '' => esc_html__('Default', 'wc-tdk'),
            'flex-start' => esc_html__('Left', 'wc-tdk'),
            'center' => esc_html__('Center', 'wc-tdk'),
            'flex-end' => esc_html__('Right', 'wc-tdk'),
            'space-between' => esc_html__('Space Between', 'wc-tdk'),
            'space-around' => esc_html__('Space Around', 'wc-tdk'),
        );
        return $list;
    }
}

if (! function_exists('wc_tdk_disply_type_list_elementor')) {
    function wc_tdk_disply_type_list_elementor()
    {
        $list = array(
            '' => esc_html__('Default', 'wc-tdk'),
            'block' => esc_html__('Block', 'wc-tdk'),
            'inline-block' => esc_html__('Inline Block', 'wc-tdk'),
            'inline' => esc_html__('Inline', 'wc-tdk'),
            'flex' => esc_html__('Flex', 'wc-tdk'),
            'inline-flex' => esc_html__('Inline Flex', 'wc-tdk'),
        );
        return $list;
    }
}

if (! function_exists('wc_tdk_get_available_image_sizes')) {
    function wc_tdk_get_available_image_sizes()
    {
        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        foreach ($get_intermediate_image_sizes as $size) {
            $sizes[$size] = $size;
        }
        $sizes['full'] = esc_html__('Full', 'wc-tdk');
        return $sizes;
    }
}

if (! function_exists('wc_tdk_prepare_button_classes_from_params')) {
    function wc_tdk_prepare_button_classes_from_params($params = array(), $prefix = '')
    {
        $btn_classes = array();
        $btn_classes[] = 'btn';
        return $btn_classes;
    }
}

if ( ! function_exists( 'wc_tdk_print_template_html' ) ) {
	/**
	 * Echo sanitized HTML from WooCommerce/widget templates.
	 *
	 * @param string $html Template HTML.
	 */
	function wc_tdk_print_template_html( $html ) {
		// Templates use esc_* helpers; assembled markup includes WooCommerce data attributes.
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'wc_tdk_get_allowed_html' ) ) {
	/**
	 * Allowed HTML tags for frontend template output.
	 *
	 * @return array<string, array<string, bool>>
	 */
	function wc_tdk_get_allowed_html() {
		$allowed = wp_kses_allowed_html( 'post' );

		$allowed['button'] = array(
			'type'             => true,
			'class'            => true,
			'data-product-id'  => true,
			'aria-label'       => true,
			'aria-hidden'      => true,
		);

		$allowed['span']['aria-hidden'] = true;
		$allowed['span']['class']       = true;

		/**
		 * Filter allowed HTML for WC TDK template output.
		 *
		 * @param array $allowed Allowed tags and attributes.
		 */
		return apply_filters( 'wc_tdk_allowed_html', $allowed );
	}
}

if (! function_exists('wc_tdk_get_widget_template_base_dir')) {
    /**
     * Resolve widget template directory (supports folder "widget" or "widget/tpl").
     *
     * @param string $folder Widget folder under includes/widgets/.
     * @return string Absolute path with trailing slash.
     */
    function wc_tdk_get_widget_template_base_dir($folder = '')
    {
        $folder = trim(str_replace('\\', '/', (string) $folder), '/');

        if ('' === $folder) {
            return WC_TDK_PLUGIN_DIR . 'includes/widgets/';
        }

        if (substr($folder, -4) === '/tpl' || 'tpl' === $folder) {
            return WC_TDK_PLUGIN_DIR . 'includes/widgets/' . $folder . '/';
        }

        return WC_TDK_PLUGIN_DIR . 'includes/widgets/' . $folder . '/tpl/';
    }
}

if (! function_exists('wc_tdk_normalize_template_params')) {
    /**
     * Normalize params passed into widget/block templates.
     *
     * Ensures $settings exists after extract() for Gutenberg, Elementor, and shortcodes.
     *
     * @param array $params Raw parameters.
     * @return array
     */
    function wc_tdk_normalize_template_params($params = array())
    {
        if (! is_array($params)) {
            $params = array();
        }

        if (isset($params['settings']) && is_array($params['settings'])) {
            $settings = $params['settings'];
        } else {
            $settings = $params;
        }

        $settings['settings'] = $settings;

        return $settings;
    }
}

if (! function_exists('wc_tdk_register_wc_product_block_styles')) {
    /**
     * Register styles used by the WC Products widget and block.
     */
    function wc_tdk_register_wc_product_block_styles()
    {
        if (wp_style_is('wc-tdk-wc-products', 'registered')) {
            return;
        }

        wp_register_style(
            'wc-tdk-wc-products',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-loader.css',
            array(),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wc-products-skin-1',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-skin-1.css',
            array('wc-tdk-wc-products'),
            WC_TDK_VERSION
        );

        wp_register_style(
            'wc-tdk-wc-products-skin-2',
            WC_TDK_PLUGIN_URL . 'assets/css/woo/wc-products/wc-products-skin-2.css',
            array('wc-tdk-wc-products'),
            WC_TDK_VERSION
        );
    }
}

if (! function_exists('wc_tdk_get_shortcode_shop_template_part')) {
    function wc_tdk_get_shortcode_shop_template_part($slug, $name = null, $folder = '', $params = array(), $shortcode_ob_start = false)
    {
        $output_html = '';
        $settings    = wc_tdk_normalize_template_params($params);

        if (! empty($settings)) {
            extract($settings, EXTR_SKIP); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
        }
        $template_base = wc_tdk_get_widget_template_base_dir($folder);
        $templates = array();
        $name = (string) $name;
        if ('' !== $name) {
            $templates[] = $template_base . $slug . '-' . $name . '.php';
        }
        $templates[] = $template_base . $slug . '.php';

        foreach ($templates as $template) {
            if (file_exists($template)) {
                if ($shortcode_ob_start) {
                    ob_start();
                    include $template;
                    $output_html = ob_get_clean();
                } else {
                    include $template;
                }
                break;
            }
        }
        return $output_html;
    }
}

if (! function_exists('wc_tdk_no_products_found_text')) {
    function wc_tdk_no_products_found_text()
    {
        echo '<p class="woocommerce-info">' . esc_html__('No products were found matching your selection.', 'wc-tdk') . '</p>';
    }
}

if (! function_exists('wc_tdk_get_shop_catalog_layout')) {
    function wc_tdk_get_shop_catalog_layout()
    {
        return apply_filters('wc_tdk_shop_catalog_layout', 'default');
    }
}

if (! function_exists('wc_tdk_isotope_filter_all_text')) {
    function wc_tdk_isotope_filter_all_text()
    {
        return apply_filters('wc_tdk_isotope_filter_all_text', esc_html__('All', 'wc-tdk'));
    }
}

if (! function_exists('wc_tdk_swiper_data_params')) {
    function wc_tdk_swiper_data_params($settings = array())
    {
        $slides   = isset($settings['slides_to_show']) ? absint($settings['slides_to_show']) : 3;
        $autoplay = (! empty($settings['autoplay']) && 'yes' === $settings['autoplay']) ? 'true' : 'false';
        $speed    = isset($settings['speed']) ? absint($settings['speed']) : 3000;
        $loop     = (! empty($settings['infinite']) && 'yes' === $settings['infinite']) ? 'true' : 'false';

        return array(
            'data-slides-per-view="' . esc_attr($slides) . '"',
            'data-autoplay="' . esc_attr($autoplay) . '"',
            'data-speed="' . esc_attr($speed) . '"',
            'data-loop="' . esc_attr($loop) . '"',
        );
    }
}

if (! function_exists('wc_tdk_quickview_button')) {
    /**
     * Output quick view icon button for product cards.
     */
    function wc_tdk_quickview_button()
    {
        global $product;

        if (! $product instanceof \WC_Product) {
            return;
        }

        printf(
            '<button type="button" class="wc-tdk-quick-view-button" data-product-id="%1$d" aria-label="%2$s"><span class="wc-tdk-quick-view-icon" aria-hidden="true"></span></button>',
            (int) $product->get_id(),
            esc_attr__('Quick view', 'wc-tdk')
        );
    }
}

if (! function_exists('wc_tdk_woocommerce_get_product_label_stock')) {
    function wc_tdk_woocommerce_get_product_label_stock()
    {
        global $product;

        if ($product instanceof \WC_Product && ! $product->is_in_stock()) {
            echo '<span class="stock out-of-stock">' . esc_html__('Out of stock', 'wc-tdk') . '</span>';
        }
    }
}

if (! function_exists('wc_tdk_render_product_action_buttons')) {
    function wc_tdk_render_product_action_buttons()
    {
        wc_tdk_quickview_button();
    }
}

if (! function_exists('wc_tdk_woocommerce_get_product_short_description')) {
    function wc_tdk_woocommerce_get_product_short_description($length = 0)
    {
        global $product;

        if (! $product instanceof \WC_Product) {
            $product = wc_get_product(get_the_ID());
        }

        if (! $product) {
            return;
        }

        $excerpt = $product->get_short_description();

        if (! $excerpt) {
            return;
        }

        if ($length) {
            $excerpt = wp_trim_words(wp_strip_all_tags($excerpt), absint($length));
        }

        echo '<div class="woocommerce-product-details__short-description">' . wp_kses_post($excerpt) . '</div>';
    }
}

if (! function_exists('wc_tdk_run_products_query')) {
    /**
     * Build a WP_Query for WooCommerce products from Elementor/widget settings.
     *
     * @param array $settings Widget or block settings.
     * @return \WP_Query
     */
    function wc_tdk_run_products_query($settings = array())
    {
        $limit = max(1, absint($settings['limit'] ?? 8));
        $product_type = $settings['product_type'] ?? 'recent_products';
        $orderby = $settings['orderby'] ?? 'date';
        $order = strtoupper($settings['order'] ?? 'DESC');

        if (! class_exists('WooCommerce')) {
            return new \WP_Query(array('post__in' => array(0)));
        }

        $wc_args = array(
            'limit'   => $limit,
            'orderby' => $orderby,
            'order'   => $order,
            'status'  => 'publish',
            'return'  => 'ids',
        );

        switch ($product_type) {
            case 'featured_products':
            case 'featured':
                $wc_args['featured'] = true;
                break;
            case 'sale_products':
            case 'on_sale':
                $wc_args['on_sale'] = true;
                break;
            case 'best_selling_products':
            case 'best_selling':
                $wc_args['orderby'] = 'popularity';
                break;
            case 'top_rated_products':
            case 'top_rated':
                $wc_args['orderby'] = 'rating';
                break;
            case 'ids':
                if (! empty($settings['product_ids'])) {
                    $wc_args['include'] = wp_parse_id_list($settings['product_ids']);
                    unset($wc_args['orderby'], $wc_args['order']);
                }
                break;
            case 'recent_products':
            case 'recent':
            default:
                break;
        }

        if (! empty($settings['categories'])) {
            $categories = $settings['categories'];
            if (! is_array($categories)) {
                $categories = array_filter(array_map('trim', explode(',', (string) $categories)));
            }
            if ($categories) {
                $wc_args['category'] = array_map('sanitize_title', $categories);
            }
        }

        if (! empty($settings['tag'])) {
            $tags = $settings['tag'];
            if (! is_array($tags)) {
                $tags = array_filter(array_map('trim', explode(',', (string) $tags)));
            }
            if ($tags) {
                $wc_args['tag'] = array_map('sanitize_title', $tags);
            }
        }

        $products = wc_get_products($wc_args);
        $product_ids = array();

        if (is_array($products)) {
            foreach ($products as $product) {
                if (is_numeric($product)) {
                    $product_ids[] = absint($product);
                } elseif (is_object($product) && method_exists($product, 'get_id')) {
                    $product_ids[] = absint($product->get_id());
                }
            }
        }

        $product_ids = array_filter($product_ids);

        if (empty($product_ids)) {
            return new \WP_Query(
                array(
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => $limit,
                    'post__in'       => array(0),
                )
            );
        }

        return new \WP_Query(
            array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'posts_per_page'      => $limit,
                'post__in'            => $product_ids,
                'orderby'             => 'post__in',
                'ignore_sticky_posts' => true,
            )
        );
    }
}

if (! function_exists('wc_tdk_get_product_cat_filters_from_query')) {
    /**
     * Collect product category filter links without advancing the main query loop.
     *
     * @param \WP_Query $query Product query.
     * @return array<string, string> slug => name.
     */
    function wc_tdk_get_product_cat_filters_from_query($query)
    {
        $filters = array();

        if (! $query instanceof \WP_Query || empty($query->posts)) {
            return $filters;
        }

        foreach ($query->posts as $post) {
            $terms = wp_get_post_terms($post->ID, 'product_cat', array('fields' => 'all'));

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            foreach ($terms as $term) {
                $filters[$term->slug] = $term->name;
            }
        }

        return $filters;
    }
}

if (! function_exists('wc_tdk_woocommerce_time_sale_layout')) {
    function wc_tdk_woocommerce_time_sale_layout()
    {
        global $product;

        if (! $product instanceof \WC_Product || ! $product->is_on_sale()) {
            return;
        }

        $date_to = $product->get_date_on_sale_to();

        if (! $date_to) {
            return;
        }

        $end = $date_to->getTimestamp();

        if ($end <= time()) {
            return;
        }

        echo '<div class="wc-tdk-countdown" data-countdown="' . esc_attr($end) . '"></div>';
    }
}

if (! function_exists('wc_tdk_enqueue_woocommerce_product_styles')) {
    function wc_tdk_enqueue_woocommerce_product_styles()
    {
        if (! class_exists('WooCommerce')) {
            return;
        }

        wp_enqueue_style('wc-tdk-wc-products');

        if (wp_style_is('woocommerce-general', 'registered')) {
            wp_enqueue_style('woocommerce-general');
            wp_enqueue_style('woocommerce-layout');
            wp_enqueue_style('woocommerce-smallscreen');
        }
    }
}

if (! function_exists('wc_tdk_render_products_loop_fallback')) {
    /**
     * Render a standard WooCommerce product loop (used when custom templates fail).
     *
     * @param \WP_Query $query   Product query.
     * @param array     $settings Widget settings.
     * @return string
     */
    function wc_tdk_render_products_loop_fallback($query, $settings = array())
    {
        if (! $query instanceof \WP_Query || ! $query->have_posts()) {
            ob_start();
            wc_tdk_no_products_found_text();
            return ob_get_clean();
        }

        $columns = isset($settings['columns']) ? absint($settings['columns']) : 3;
        if ($columns < 1) {
            $columns = 3;
        }

        $settings['the_query']  = $query;
        $settings['columns']    = $columns;
        $settings['gutter']     = ! empty($settings['gutter']) ? $settings['gutter'] : 'gutter-10';
        $settings['holder_id']  = ! empty($settings['holder_id']) ? $settings['holder_id'] : wc_tdk_get_isotope_holder_ID('wc-product-fallback');
        $settings               = wc_tdk_prepare_widget_skin_for_templates($settings);
        $settings['display_type'] = 'grid';

        wc_tdk_enqueue_product_skin_assets(wc_tdk_get_active_product_skin($settings));

        $html = wc_tdk_get_shortcode_shop_template_part('wc-products', 'grid', 'wc-products/tpl', $settings, true);

        if (! empty(trim(wp_strip_all_tags($html)))) {
            return $html;
        }

        ob_start();
        echo '<div class="wc-tdk-products-fallback woocommerce">';
        echo '<ul class="products columns-' . esc_attr($columns) . '">';

        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }

        echo '</ul></div>';
        wp_reset_postdata();

        return ob_get_clean();
    }
}
