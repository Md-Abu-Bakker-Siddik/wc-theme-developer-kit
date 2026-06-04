<?php
/**
 * Vertical Menu Block.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-block-base.php';

class WC_TDK_Block_Vertical_Menu extends WC_TDK_Block_Base {

    /**
     * Set block name.
     */
    protected function set_block_name() {
        $this->block_name = 'vertical-menu';
    }

    /**
     * Set block attributes.
     */
    protected function set_attributes() {
        $this->attributes = array(
            'title' => array(
                'type' => 'string',
                'default' => '',
            ),
            'menu' => array(
                'type' => 'string',
                'default' => '',
            ),
            'show_product_categories' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        );
    }

    /**
     * Render callback.
     *
     * @param array $attributes Block attributes.
     * @param string $content Inner content.
     * @return string
     */
    public function render($attributes, $content) {
        $title = isset($attributes['title']) ? sanitize_text_field($attributes['title']) : '';
        $menu = isset($attributes['menu']) ? sanitize_text_field($attributes['menu']) : '';
        $show_product_categories = isset($attributes['show_product_categories']) ? (bool)$attributes['show_product_categories'] : true;

        ob_start();
        ?>
        <div class="wc-tdk-vertical-menu-block">
            <?php if ($title) : ?>
                <h3 class="wc-tdk-vertical-menu-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <nav class="wc-tdk-vertical-menu">
                <?php
                if (!empty($menu) && has_nav_menu($menu)) {
                    wp_nav_menu(array(
                        'theme_location' => $menu,
                        'container' => false,
                        'menu_class' => 'wc-tdk-vertical-menu-list',
                    ));
                } elseif ($show_product_categories) {
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0,
                    ));
                    if (!empty($product_categories)) {
                        echo '<ul class="wc-tdk-vertical-menu-list">';
                        foreach ($product_categories as $cat) {
                            $link = get_term_link($cat);
                            echo '<li class="wc-tdk-vertical-menu-item">';
                            echo '<a href="' . esc_url($link) . '" class="wc-tdk-vertical-menu-link">' . esc_html($cat->name) . '</a>';
                            // Get child categories
                            $child_cats = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => $cat->term_id,
                            ));
                            if (!empty($child_cats)) {
                                echo '<ul class="wc-tdk-vertical-menu-children">';
                                foreach ($child_cats as $child) {
                                    $child_link = get_term_link($child);
                                    echo '<li class="wc-tdk-vertical-menu-child-item">';
                                    echo '<a href="' . esc_url($child_link) . '" class="wc-tdk-vertical-menu-child-link">' . esc_html($child->name) . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </nav>
        </div>
        <?php
        return ob_get_clean();
    }
}
