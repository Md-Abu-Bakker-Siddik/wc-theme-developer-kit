const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { PanelBody, TextControl, SelectControl, ToggleControl, RangeControl, Spinner } = wp.components;
const { createElement: el } = wp.element;
const ServerSideRender = wp.serverSideRender;

// Product Category Block
registerBlockType('wc-tdk/product-category', {
    title: __('Product Category', 'wc-tdk'),
    icon: 'category',
    category: 'wc-tdk',
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        content: {
            type: 'string',
            default: '',
        },
        skin: {
            type: 'string',
            default: 'skin-current-theme1',
        },
        product_count: {
            type: 'boolean',
            default: true,
        },
        columns: {
            type: 'number',
            default: 4,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps({ className: 'wc-tdk-product-category-block' });
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(TextControl, {
                        label: __('Description', 'wc-tdk'),
                        value: props.attributes.content,
                        onChange: function(val) { props.setAttributes({ content: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Skin', 'wc-tdk'),
                        value: props.attributes.skin,
                        help: __('Advanced skins are available in the Elementor Product Category widget.', 'wc-tdk'),
                        options: [
                            { label: __('Default grid', 'wc-tdk'), value: 'skin-current-theme1' },
                        ],
                        onChange: function(val) { props.setAttributes({ skin: val }); }
                    }),
                    el(RangeControl, {
                        label: __('Columns', 'wc-tdk'),
                        value: props.attributes.columns,
                        onChange: function(val) { props.setAttributes({ columns: val }); },
                        min: 1,
                        max: 6,
                    }),
                    el(ToggleControl, {
                        label: __('Show Product Count', 'wc-tdk'),
                        checked: props.attributes.product_count,
                        onChange: function(val) { props.setAttributes({ product_count: val }); }
                    })
                )
            ),
            el(ServerSideRender, {
                block: 'wc-tdk/product-category',
                attributes: props.attributes,
                LoadingResponsePlaceholder: function() {
                    return el('div', { className: 'wc-tdk-product-category-block-preview' },
                        el(Spinner, {}),
                        el('p', {}, __('Loading categories…', 'wc-tdk'))
                    );
                },
                ErrorResponsePlaceholder: function(errorProps) {
                    return el('div', { className: 'wc-tdk-product-category-block-preview' },
                        el('p', {}, errorProps.error || __('Unable to load categories preview.', 'wc-tdk'))
                    );
                },
            })
        );
    },
    save: function() { return null; },
});

// Product List Block
registerBlockType('wc-tdk/product-list', {
    title: __('Product List', 'wc-tdk'),
    icon: 'products',
    category: 'wc-tdk',
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        product_type: {
            type: 'string',
            default: 'recent',
        },
        columns: {
            type: 'number',
            default: 4,
        },
        limit: {
            type: 'number',
            default: 8,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Product Type', 'wc-tdk'),
                        value: props.attributes.product_type,
                        options: [
                            { label: 'Recent Products', value: 'recent' },
                            { label: 'Featured Products', value: 'featured' },
                            { label: 'Top Rated Products', value: 'top_rated' },
                            { label: 'On Sale Products', value: 'on_sale' },
                            { label: 'Best Selling Products', value: 'best_selling' },
                        ],
                        onChange: function(val) { props.setAttributes({ product_type: val }); }
                    }),
                    el(RangeControl, {
                        label: __('Columns', 'wc-tdk'),
                        value: props.attributes.columns,
                        onChange: function(val) { props.setAttributes({ columns: val }); },
                        min: 1,
                        max: 6
                    }),
                    el(RangeControl, {
                        label: __('Limit', 'wc-tdk'),
                        value: props.attributes.limit,
                        onChange: function(val) { props.setAttributes({ limit: val }); },
                        min: 1,
                        max: 24
                    })
                )
            ),
            el('div', { className: 'wc-tdk-product-list-block-preview' },
                el('h3', {}, __('Product List Block', 'wc-tdk')),
                el('p', {}, __('Displays products with customizable filters and layout.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Info Banner Block
registerBlockType('wc-tdk/info-banner', {
    title: __('Info Banner', 'wc-tdk'),
    icon: 'format-image',
    category: 'wc-tdk',
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        subtitle: {
            type: 'string',
            default: '',
        },
        content: {
            type: 'string',
            default: '',
        },
        button_text: {
            type: 'string',
            default: '',
        },
        button_url: {
            type: 'string',
            default: '',
        },
        layout: {
            type: 'string',
            default: 'basic',
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(TextControl, {
                        label: __('Subtitle', 'wc-tdk'),
                        value: props.attributes.subtitle,
                        onChange: function(val) { props.setAttributes({ subtitle: val }); }
                    }),
                    el(TextControl, {
                        label: __('Content', 'wc-tdk'),
                        value: props.attributes.content,
                        onChange: function(val) { props.setAttributes({ content: val }); }
                    }),
                    el(TextControl, {
                        label: __('Button Text', 'wc-tdk'),
                        value: props.attributes.button_text,
                        onChange: function(val) { props.setAttributes({ button_text: val }); }
                    }),
                    el(TextControl, {
                        label: __('Button URL', 'wc-tdk'),
                        value: props.attributes.button_url,
                        onChange: function(val) { props.setAttributes({ button_url: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Layout', 'wc-tdk'),
                        value: props.attributes.layout,
                        options: [
                            { label: 'Basic', value: 'basic' },
                            { label: 'Bottom', value: 'bottom' },
                            { label: 'Center', value: 'center' },
                            { label: 'Image Switch', value: 'image_switch' },
                            { label: 'Top Reveal', value: 'top_reveal' },
                        ],
                        onChange: function(val) { props.setAttributes({ layout: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-info-banner-block-preview' },
                el('h3', {}, __('Info Banner Block', 'wc-tdk')),
                el('p', {}, __('Creates attractive promotional banners.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Header Cart Block
registerBlockType('wc-tdk/header-cart', {
    title: __('Header Cart', 'wc-tdk'),
    icon: 'cart',
    category: 'wc-tdk',
    attributes: {
        layout: {
            type: 'string',
            default: 'dropdown',
        },
        show_count: {
            type: 'boolean',
            default: true,
        },
        show_total: {
            type: 'boolean',
            default: true,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(SelectControl, {
                        label: __('Layout', 'wc-tdk'),
                        value: props.attributes.layout,
                        options: [
                            { label: 'Dropdown', value: 'dropdown' },
                            { label: 'Side Cart', value: 'side_cart' },
                        ],
                        onChange: function(val) { props.setAttributes({ layout: val }); }
                    }),
                    el(ToggleControl, {
                        label: __('Show Count', 'wc-tdk'),
                        checked: props.attributes.show_count,
                        onChange: function(val) { props.setAttributes({ show_count: val }); }
                    }),
                    el(ToggleControl, {
                        label: __('Show Total', 'wc-tdk'),
                        checked: props.attributes.show_total,
                        onChange: function(val) { props.setAttributes({ show_total: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-header-cart-block-preview' },
                el('h3', {}, __('Header Cart Block', 'wc-tdk')),
                el('p', {}, __('Displays shopping cart with item count and total.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Header Search Block
registerBlockType('wc-tdk/header-search', {
    title: __('Header Search', 'wc-tdk'),
    icon: 'search',
    category: 'wc-tdk',
    attributes: {
        show_categories: {
            type: 'boolean',
            default: false,
        },
        placeholder: {
            type: 'string',
            default: 'Search products...',
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(ToggleControl, {
                        label: __('Show Categories', 'wc-tdk'),
                        checked: props.attributes.show_categories,
                        onChange: function(val) { props.setAttributes({ show_categories: val }); }
                    }),
                    el(TextControl, {
                        label: __('Placeholder', 'wc-tdk'),
                        value: props.attributes.placeholder,
                        onChange: function(val) { props.setAttributes({ placeholder: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-header-search-block-preview' },
                el('h3', {}, __('Header Search Block', 'wc-tdk')),
                el('p', {}, __('Advanced product search for headers.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Account Block
registerBlockType('wc-tdk/account', {
    title: __('Account', 'wc-tdk'),
    icon: 'admin-users',
    category: 'wc-tdk',
    attributes: {
        layout: {
            type: 'string',
            default: 'dropdown',
        },
        show_avatar: {
            type: 'boolean',
            default: true,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(SelectControl, {
                        label: __('Layout', 'wc-tdk'),
                        value: props.attributes.layout,
                        options: [
                            { label: 'Dropdown', value: 'dropdown' },
                            { label: 'Simple Link', value: 'simple' },
                        ],
                        onChange: function(val) { props.setAttributes({ layout: val }); }
                    }),
                    el(ToggleControl, {
                        label: __('Show Avatar', 'wc-tdk'),
                        checked: props.attributes.show_avatar,
                        onChange: function(val) { props.setAttributes({ show_avatar: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-account-block-preview' },
                el('h3', {}, __('Account Block', 'wc-tdk')),
                el('p', {}, __('Displays user account link with avatar.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Wishlist Block
registerBlockType('wc-tdk/wishlist', {
    title: __('Wishlist', 'wc-tdk'),
    icon: 'heart',
    category: 'wc-tdk',
    attributes: {
        show_count: {
            type: 'boolean',
            default: true,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(ToggleControl, {
                        label: __('Show Count', 'wc-tdk'),
                        checked: props.attributes.show_count,
                        onChange: function(val) { props.setAttributes({ show_count: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-wishlist-block-preview' },
                el('h3', {}, __('Wishlist Block', 'wc-tdk')),
                el('p', {}, __('Displays wishlist with item count.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Vertical Menu Block
registerBlockType('wc-tdk/vertical-menu', {
    title: __('Vertical Menu', 'wc-tdk'),
    icon: 'menu',
    category: 'wc-tdk',
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        show_product_categories: {
            type: 'boolean',
            default: true,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(ToggleControl, {
                        label: __('Show Product Categories', 'wc-tdk'),
                        checked: props.attributes.show_product_categories,
                        onChange: function(val) { props.setAttributes({ show_product_categories: val }); }
                    })
                )
            ),
            el('div', { className: 'wc-tdk-vertical-menu-block-preview' },
                el('h3', {}, __('Vertical Menu Block', 'wc-tdk')),
                el('p', {}, __('Vertical category or custom menu display.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// Product Tabs Block
registerBlockType('wc-tdk/product-tabs', {
    title: __('Product Tabs', 'wc-tdk'),
    icon: 'table',
    category: 'wc-tdk',
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        columns: {
            type: 'number',
            default: 4,
        },
        limit: {
            type: 'number',
            default: 4,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps();
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(RangeControl, {
                        label: __('Columns', 'wc-tdk'),
                        value: props.attributes.columns,
                        onChange: function(val) { props.setAttributes({ columns: val }); },
                        min: 1,
                        max: 6
                    }),
                    el(RangeControl, {
                        label: __('Limit per Tab', 'wc-tdk'),
                        value: props.attributes.limit,
                        onChange: function(val) { props.setAttributes({ limit: val }); },
                        min: 1,
                        max: 12
                    })
                )
            ),
            el('div', { className: 'wc-tdk-product-tabs-block-preview' },
                el('h3', {}, __('Product Tabs Block', 'wc-tdk')),
                el('p', {}, __('Create tabbed product displays.', 'wc-tdk'))
            )
        );
    },
    save: function() { return null; },
});

// WC Products Block
registerBlockType('wc-tdk/wc-products', {
    title: __('WC Products', 'wc-tdk'),
    icon: 'store',
    category: 'wc-tdk',
    apiVersion: 3,
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        layout: {
            type: 'string',
            default: 'grid',
        },
        skin: {
            type: 'string',
            default: 'skin-current-theme1',
        },
        product_type: {
            type: 'string',
            default: 'recent',
        },
        columns: {
            type: 'number',
            default: 4,
        },
        limit: {
            type: 'number',
            default: 8,
        },
    },
    edit: function(props) {
        const blockProps = useBlockProps({ className: 'wc-tdk-wc-products-block' });
        return el('div', blockProps,
            el(InspectorControls, {},
                el(PanelBody, { title: __('Settings', 'wc-tdk') },
                    el(TextControl, {
                        label: __('Title', 'wc-tdk'),
                        value: props.attributes.title,
                        onChange: function(val) { props.setAttributes({ title: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Layout', 'wc-tdk'),
                        value: props.attributes.layout,
                        options: [
                            { label: 'Grid', value: 'grid' },
                            { label: 'Carousel', value: 'carousel' },
                            { label: 'Masonry', value: 'masonry' },
                        ],
                        onChange: function(val) { props.setAttributes({ layout: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Skin', 'wc-tdk'),
                        value: props.attributes.skin,
                        options: [
                            { label: __('Skin 1 – Modern Card', 'wc-tdk'), value: 'skin-current-theme1' },
                            { label: __('Skin 2 – Classic Shop', 'wc-tdk'), value: 'skin-current-theme2' },
                        ],
                        onChange: function(val) { props.setAttributes({ skin: val }); }
                    }),
                    el(SelectControl, {
                        label: __('Product Type', 'wc-tdk'),
                        value: props.attributes.product_type,
                        options: [
                            { label: 'Recent Products', value: 'recent' },
                            { label: 'Featured Products', value: 'featured' },
                            { label: 'Top Rated Products', value: 'top_rated' },
                            { label: 'On Sale Products', value: 'on_sale' },
                            { label: 'Best Selling Products', value: 'best_selling' },
                        ],
                        onChange: function(val) { props.setAttributes({ product_type: val }); }
                    }),
                    el(RangeControl, {
                        label: __('Columns', 'wc-tdk'),
                        value: props.attributes.columns,
                        onChange: function(val) { props.setAttributes({ columns: val }); },
                        min: 1,
                        max: 6
                    }),
                    el(RangeControl, {
                        label: __('Limit', 'wc-tdk'),
                        value: props.attributes.limit,
                        onChange: function(val) { props.setAttributes({ limit: val }); },
                        min: 1,
                        max: 24
                    })
                )
            ),
            el(ServerSideRender, {
                block: 'wc-tdk/wc-products',
                attributes: props.attributes,
                LoadingResponsePlaceholder: function() {
                    return el('div', { className: 'wc-tdk-wc-products-block-preview' },
                        el(Spinner, {}),
                        el('p', {}, __('Loading products…', 'wc-tdk'))
                    );
                },
                ErrorResponsePlaceholder: function(errorProps) {
                    return el('div', { className: 'wc-tdk-wc-products-block-preview' },
                        el('p', {}, errorProps.error || __('Unable to load products preview.', 'wc-tdk'))
                    );
                },
            })
        );
    },
    save: function() { return null; },
});
