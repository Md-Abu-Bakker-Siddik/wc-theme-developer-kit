<?php

namespace WC_TDK\Widgets\WC_Products\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Skin_Current_Theme2 extends Elementor_Skin_Base
{

	protected function register_controls_actions()
	{
		add_action('elementor/element/wc-tdk-wc-products/tm_general/after_section_end', array($this, 'register_layout_controls2'));
	}

	public function get_id()
	{
		return 'skin-current-theme2';
	}


	public function get_title()
	{
		return __('Skin 2 – Classic Shop', 'wc-tdk');
	}



	public function register_layout_controls2(Widget_Base $widget)
	{
		$this->parent = $widget;
		$this->start_controls_section(
			'paragraph_opt',
			[
				'label' => esc_html__('Content - Paragraph', 'wc-tdk'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'excerpt_length',
			[
				'label' => esc_html__("Excerpt Length", 'wc-tdk'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				"description" => esc_html__("Number of words to display. Example: 25. Default all", 'wc-tdk'),
				'default' => 22,
			]
		);
		$this->end_controls_section();
	}

	public function render()
	{
		$settings = $this->parent->get_settings_for_display();
		$class_instance =  '';

		$settings['holder_id'] = wc_tdk_get_isotope_holder_ID('wc-product');
		return $this->parent->wc_render_output($class_instance, $settings);
	}
}
