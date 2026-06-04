<?php

namespace WC_TDK\Widgets\Product_Category;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class WC_TDK_Product_Category extends Widget_Base
{
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'wc-tdk-product-category';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Product Category', 'wc-tdk');
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-product-categories';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['wc-tdk'];
	}

	/**
	 * Skins
	 */
	protected function register_skins()
	{
		$this->add_skin(new Skins\Skin_Current_Theme1($this));
		$this->add_skin(new Skins\Skin_Current_Theme2($this));
		$this->add_skin(new Skins\Skin_Current_Theme3($this));
		$this->add_skin(new Skins\Skin_Current_Theme4($this));
		$this->add_skin(new Skins\Skin_Current_Theme5($this));
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls()
	{

		//Section Query
		$this->start_controls_section(
			'section_setting',
			[
				'label' => esc_html__('Settings', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'categories_name',
			[
				'label' => esc_html__('Alternate Name', 'wc-tdk'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__("Name Tag", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_heading_tag_list(),
				'default' => 'h5'
			]
		);
		$this->add_control(
			'show_count',
			[
				'label' => esc_html__("Show Product Count", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);
		$this->add_control(
			'categories',
			[
				'label'       => esc_html__('Category', 'wc-tdk'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => $this->get_product_categories(),
				'multiple'    => false,
			]
		);
		$this->end_controls_section();



		$this->start_controls_section(
			'category_image_opt',
			[
				'label' => esc_html__('Category Image', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'icon_type',
			[
				'label' => esc_html__("Icon Type", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'flat-icon' => esc_html__('Flat Icon', 'wc-tdk'),
					'image' => esc_html__('JPG/PNG Image', 'wc-tdk'),
				],
				'default' => 'flat-icon'
			]
		);

		$this->add_control(
			'category_image',
			[
				'label'      => esc_html__('Choose Category Image', 'wc-tdk'),
				'default'    => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'show_label' => false,
				'condition' => [
					'icon_type' => array('image')
				]
			]

		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => [
					'icon_type' => array('image')
				]
			]
		);

		//flaticon
		$this->add_control(
			'category_flaticon',
			[
				'label' => __('Choose Category Flat Icon', 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-chart-bar',
					'library' => 'font-awesome',
				],
				'condition' => [
					'icon_type' => array('flat-icon')
				]
			]
		);
		$this->end_controls_section();














		$this->start_controls_section(
			'paragraph_opt',
			[
				'label' => esc_html__('Content - Paragraph', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_paragraph',
			[
				'label' => esc_html__("Show Paragraph", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__("Paragraph", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__("Write a short description", 'wc-tdk'),
				'condition' => [
					'show_paragraph' => array('yes')
				]
			]
		);
		$this->end_controls_section();

















		$this->start_controls_section(
			'image_style',
			[
				'label' => esc_html__('Image', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__('Image Custom Width', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .cat-image img' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__('Image Margin', 'wc-tdk'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .cat-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_background_border_radius',
			[
				'label' => esc_html__("Border Radius", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .cat-image a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();





		$this->start_controls_section(
			'bg_style',
			[
				'label' => esc_html__('Background Option (Default Skin)', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);
		$this->start_controls_tabs('tab_bg');
		$this->start_controls_tab(
			'tab_bg_normal',
			[
				'label' => esc_html__('Normal', 'wc-tdk'),
			]
		);
		$this->add_responsive_control(
			'image_background_width',
			[
				'label'      => esc_html__('Background Width', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .cat-image a:before' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'image_background_height',
			[
				'label'      => esc_html__('Background Height', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .cat-image a:before' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'image_background_color',
			[
				'label'     => esc_html__('Background Color', 'wc-tdk'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cat-image a:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_background_theme_colored',
			[
				'label' => esc_html__("Background Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cat-image a:before' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_bg_hover',
			[
				'label' => esc_html__('Hover', 'wc-tdk'),
			]
		);
		$this->add_responsive_control(
			'image_background_width_hover',
			[
				'label'      => esc_html__('Background Width', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}}:hover .cat-image a:before' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'image_background_height_hover',
			[
				'label'      => esc_html__('Background Height', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}}:hover .cat-image a:before' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'image_background_color_hover',
			[
				'label'     => esc_html__('Background Color', 'wc-tdk'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}:hover .cat-image a:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_background_theme_colored_hover',
			[
				'label' => esc_html__("Background Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .cat-image a:before' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'image_background_border_radius_hover',
			[
				'label' => esc_html__("Border Radius", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}}:hover .cat-image a:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();















		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__('Title', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'tilte_typography',
				'selector' => '{{WRAPPER}} .cat-title a',
			]
		);

		$this->start_controls_tabs('tab_title');
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__('Normal', 'wc-tdk'),
			]
		);
		$this->add_control(
			'title_text_color',
			[
				'label' => esc_html__("Text Color", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cat-title a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_theme_colored',
			[
				'label' => esc_html__("Text Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cat-title a' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => esc_html__('Hover', 'wc-tdk'),
			]
		);
		$this->add_control(
			'title_text_color_hover',
			[
				'label' => esc_html__("Text Color (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .cat-title a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_theme_colored_hover',
			[
				'label' => esc_html__("Text Theme Colored (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .cat-title a' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Title Margin', 'wc-tdk'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__('Padding', 'wc-tdk'),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .cat-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'count_style',
			[
				'label' => esc_html__('Count Value', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'count_typography',
				'selector' => '{{WRAPPER}} .count',
			]
		);

		$this->start_controls_tabs('tab_count');
		$this->start_controls_tab(
			'tab_count_normal',
			[
				'label' => esc_html__('Normal', 'wc-tdk'),
			]
		);
		$this->add_control(
			'count_text_color',
			[
				'label' => esc_html__("Text Color", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .count' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'count_theme_colored',
			[
				'label' => esc_html__("Text Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .count' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_count_hover',
			[
				'label' => esc_html__('Hover', 'wc-tdk'),
			]
		);
		$this->add_control(
			'count_text_color_hover',
			[
				'label' => esc_html__("Text Color (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .count' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'count_theme_colored_hover',
			[
				'label' => esc_html__("Text Theme Colored (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .count' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'count_margin',
			[
				'label' => esc_html__('Count Value Margin', 'wc-tdk'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'paragraph_style',
			[
				'label' => esc_html__('Paragraph Style', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'paragraph_typography',
				'selector' => '{{WRAPPER}} .paragraph',
			]
		);

		$this->start_controls_tabs('tab_paragraph');
		$this->start_controls_tab(
			'tab_paragraph_normal',
			[
				'label' => esc_html__('Normal', 'wc-tdk'),
			]
		);
		$this->add_control(
			'paragraph_text_color',
			[
				'label' => esc_html__("Text Color", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .paragraph' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'paragraph_theme_colored',
			[
				'label' => esc_html__("Text Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .paragraph' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_paragraph_hover',
			[
				'label' => esc_html__('Hover', 'wc-tdk'),
			]
		);
		$this->add_control(
			'paragraph_text_color_hover',
			[
				'label' => esc_html__("Text Color (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .paragraph' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'paragraph_theme_colored_hover',
			[
				'label' => esc_html__("Text Theme Colored (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .paragraph' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'paragraph_margin',
			[
				'label' => esc_html__('Paragraph Value Margin', 'wc-tdk'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .paragraph' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}


	protected function get_product_categories()
	{
		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);
		$results = array();
		if (!is_wp_error($categories)) {
			foreach ($categories as $category) {
				$results[$category->slug] = $category->name;
			}
		}
		return $results;
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['categories'])) {
			echo esc_html__('Choose Category', 'wc-tdk');
			return;
		}

		$category = get_term_by('slug', $settings['categories'], 'product_cat');
		if (!is_wp_error($category) && !empty($category)) {

			if (!empty($settings['category_image']['id'])) {
				$image = Group_Control_Image_Size::get_attachment_image_src($settings['category_image']['id'], 'image', $settings);
			} else {
				$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
				if (!empty($thumbnail_id)) {
					$image = wp_get_attachment_url($thumbnail_id);
				} else {
					$image = wc_placeholder_img_src();
				}
			}
?>

			<div class="tm-product-category-default">
				<div class="cat-image">
					<a class="link_category_product" href="<?php echo esc_url(get_term_link($category)); ?>"
						title="<?php echo esc_attr($category->name); ?>">
						<img src="<?php echo esc_url_raw($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
					</a>
				</div>

				<div class="cat-details">
					<<?php echo esc_attr($settings['title_tag']); ?> class="cat-title">
						<a href="<?php echo esc_url(get_term_link($category)); ?>"
							title="<?php echo esc_attr($category->name); ?>">
							<span class="cats-title-text"><?php echo empty($settings['categories_name']) ? esc_html($category->name) : $settings['categories_name']; ?></span>
						</a>
					</<?php echo esc_attr($settings['title_tag']); ?>>
					<div class="count"><?php echo esc_html($category->count) . ' ' . esc_html__('products', 'wc-tdk'); ?> </div>
					<?php if ($settings['show_paragraph'] == 'yes') { ?>
						<div class="paragraph"><?php echo wp_kses($settings['content'], 'post'); ?></div>
					<?php } ?>
				</div>
			</div>
<?php
		}
	}
}
