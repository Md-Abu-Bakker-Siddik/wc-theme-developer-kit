<?php
/**
 * Base Block Class.
 *
 * @package WooCommerce Theme Developer Kit
 */

if (!defined('ABSPATH')) exit;

abstract class WC_TDK_Block_Base {

    /**
     * Block name.
     *
     * @var string
     */
    protected $block_name;

    /**
     * Block attributes.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * Constructor.
     */
    public function __construct() {
        $this->set_block_name();
        $this->set_attributes();
    }

    /**
     * Set block name.
     */
    abstract protected function set_block_name();

    /**
     * Set block attributes.
     */
    abstract protected function set_attributes();

    /**
     * Render callback.
     *
     * @param array $attributes Block attributes.
     * @param string $content Inner content.
     * @return string
     */
    abstract public function render($attributes, $content);

    /**
     * Register block.
     */
    public function register() {
        register_block_type(
            'wc-tdk/' . $this->block_name,
            array(
                'attributes'      => $this->attributes,
                'render_callback' => array($this, 'render'),
                'editor_style'    => 'wc-tdk-blocks-editor',
                'style'           => 'wc-tdk-blocks-frontend',
                'editor_script'   => 'wc-tdk-blocks-editor',
            )
        );
    }

    /**
     * Get default attributes.
     *
     * @return array
     */
    protected function get_default_attributes() {
        return array();
    }
}
