<?php

namespace WC_TDK\Widgets\Product_Category\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Skin_Base as Elementor_Skin_Base;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Skin_Current_Theme1 extends Elementor_Skin_Base
{

	protected function _register_controls_actions()
	{
		add_action('elementor/element/tm-ele-product-category/paragraph_opt/after_section_end', [$this, 'register_layout_controls1']);
	}

	public function get_id()
	{
		return 'skin-current-theme1';
	}


	public function get_title()
	{
		return __('Skin - Current Theme1', 'wc-tdk');
	}


	public function register_layout_controls1(Widget_Base $widget)
	{
		$this->parent = $widget;


		$this->start_controls_section(
			'bg_img_color_style',
			[
				'label' => esc_html__('Background Image/Color', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->start_controls_tabs('tab_bg');
		$this->start_controls_tab(
			'tab_bg_normal',
			[
				'label' => esc_html__('Normal', 'wc-tdk'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_before_background',
				'label' => esc_html__('Background', 'wc-tdk'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .tm-product-category-current-theme1:before',
			]
		);
		$this->add_responsive_control(
			'wrapper_before_width',
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
					'{{WRAPPER}} .tm-product-category-current-theme1:before' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_height',
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
					'{{WRAPPER}} .tm-product-category-current-theme1:before' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'wrapper_before_color',
			[
				'label'     => esc_html__('Background Color', 'wc-tdk'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .tm-product-category-current-theme1:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_theme_colored',
			[
				'label' => esc_html__("Background Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tm-product-category-current-theme1:before' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_border_radius',
			[
				'label' => esc_html__("Border Radius", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tm-product-category-current-theme1:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_bg_hover',
			[
				'label' => esc_html__('Hover', 'wc-tdk'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_before_background_hover',
				'label' => esc_html__('Background', 'wc-tdk'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}}:hover .tm-product-category-current-theme1:before',
			]
		);
		$this->add_responsive_control(
			'wrapper_before_width_hover',
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
					'{{WRAPPER}}:hover .tm-product-category-current-theme1:before' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_height_hover',
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
					'{{WRAPPER}}:hover .tm-product-category-current-theme1:before' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'wrapper_before_color_hover',
			[
				'label'     => esc_html__('Background Color', 'wc-tdk'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}:hover .tm-product-category-current-theme1:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_theme_colored_hover',
			[
				'label' => esc_html__("Background Theme Colored", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .tm-product-category-current-theme1:before' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_before_border_radius_hover',
			[
				'label' => esc_html__("Border Radius", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}}:hover .tm-product-category-current-theme1:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	public function render()
	{
		$html = '';
		$settings = $this->parent->get_settings_for_display();

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

			<div class="tm-product-category-current-theme1">
				<div class="cat-image">
					<a class="link_category_product" href="<?php echo esc_url(get_term_link($category)); ?>"
						title="<?php echo esc_attr($category->name); ?>">
						<?php if ($settings['icon_type'] == 'image') { ?>
							<img src="<?php echo esc_url_raw($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
						<?php } else if ($settings['icon_type'] == 'flat-icon') { ?>
							<span class="flat-icon"><?php \Elementor\Icons_Manager::render_icon($settings['category_flaticon'], ['aria-hidden' => 'true']); ?></span>
						<?php } ?>
					</a>
				</div>

				<div class="cat-details">
					<<?php echo esc_attr($settings['title_tag']); ?> class="cat-title">
						<a href="<?php echo esc_url(get_term_link($category)); ?>"
							title="<?php echo esc_attr($category->name); ?>">
							<span class="cats-title-text"><?php echo empty($settings['categories_name']) ? esc_html($category->name) : $settings['categories_name']; ?></span>
						</a>
					</<?php echo esc_attr($settings['title_tag']); ?>>
					<?php if ($settings['show_count'] == 'yes') { ?>
						<div class="count"><?php echo esc_html($category->count) . ' ' . esc_html__('products', 'wc-tdk'); ?> </div>
					<?php } ?>
					<?php if ($settings['show_paragraph'] == 'yes') { ?>
						<div class="paragraph"><?php echo wp_kses($settings['content'], 'post'); ?></div>
					<?php } ?>
				</div>
			</div>
<?php
		}
	}
}
