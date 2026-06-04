<?php

namespace WC_TDK\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * WooCommerce Theme Developer Kit - Info Banner Widget
 *
 * Elementor widget for displaying info banners.
 *
 * @since 1.0.0
 */
class WC_TDK_Info_Banner extends Widget_Base
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
		return 'wc-tdk-info-banner';
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
		return esc_html__('Info Banner', 'wc-tdk');
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
		return 'eicon-image-box';
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
		$this->start_controls_section(
			'wc_tdk_general',
			[
				'label' => esc_html__('General', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'layout',
			[
				'label' => esc_html__("Layout", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'layout-top-reveal' => esc_html__('Top Reveal', 'wc-tdk'),
					'layout-center'  => esc_html__('Center Standard', 'wc-tdk'),
					'layout-bottom'  => esc_html__('From Bottom', 'wc-tdk'),
					'layout-image-switch'  => esc_html__('Image Switch', 'wc-tdk'),
					'layout-basic'  => esc_html__('Basic', 'wc-tdk'),
				],
				'default' => 'layout-top-reveal',
			]
		);
		$this->add_responsive_control(
			'layout_alignment',
			[
				'label'       => esc_html__('Alignment', 'wc-tdk'),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'left',
				'options'     => [
					'left' => [
						'title' => esc_html__('Left', 'wc-tdk'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'wc-tdk'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'wc-tdk'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'label_block' => false,
				'selectors'   => [
					'{{WRAPPER}} .tm-sc-info-banner-advanced' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_options',
			[
				'label' => esc_html__('Title', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__("Title", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__("Example title", 'wc-tdk'),
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__("Title Tag", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_heading_tag_list(),
				'default' => 'h3',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_options',
			[
				'label' => esc_html__('Subtitle', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_subtitle',
			[
				'label' => esc_html__("Show Sub Title", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__("Sub Title", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__("Example subtitle", 'wc-tdk'),
				'condition' => [
					'show_subtitle' => 'yes',
				],
			]
		);
		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__("Sub Title Tag", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_heading_tag_list(),
				'default' => 'h6',
				'condition' => [
					'show_subtitle' => 'yes',
				],
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
				'default' => 'yes',
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__("Paragraph", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__("Write a short description", 'wc-tdk'),
				'condition' => [
					'show_paragraph' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'floating_img_options',
			[
				'label' => esc_html__('Floating PNG Image', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'floating_banner_image',
			[
				'label' => esc_html__("Floating PNG Image", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'floating_banner_image_hover',
			[
				'label' => esc_html__("Floating PNG Image (Hover)", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'layout' => 'layout-image-switch',
				],
			]
		);
		$this->add_control(
			'floating_banner_image_size',
			[
				'label' => esc_html__("Floating Image Size", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wc_tdk_get_available_image_sizes(),
				'default' => 'large',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'link_options',
			[
				'label' => esc_html__('Link URL', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'link',
			[
				'label' => esc_html__("Button Link URL", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'default' => [
					'url' => '',
				],
			]
		);
		$this->add_control(
			'link_subtitle',
			[
				'label' => esc_html__("Link to Subtitle?", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		$this->add_control(
			'link_title',
			[
				'label' => esc_html__("Link to Title?", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		$this->end_controls_section();
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

		//classes
		$classes = array();
		$classes[] = 'tm-' . $settings['layout'];
		$settings['classes'] = $classes;

		//link url
		$settings['target'] = ($settings['link'] && $settings['link']['is_external']) ? ' target="_blank"' : '';
		$settings['url'] = ($settings['link'] && $settings['link']['url']) ? $settings['link']['url'] : '';

		//button classes
		$settings['btn_classes'] = wc_tdk_prepare_button_classes_from_params($settings);

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = wc_tdk_get_shortcode_shop_template_part('info-banner', $settings['layout'], 'info-banner/tpl', $settings, true);

		wc_tdk_print_template_html( $html );
	}
}
