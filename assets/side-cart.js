/* WC TDK Side Cart JavaScript */
jQuery(document).ready(function($) {
    // Add a cart toggle button (you can customize this)
    $('body').prepend('<button id="wc-tdk-cart-toggle" style="position:fixed;top:20px;right:20px;z-index:9998;padding:10px 20px;background:#222;color:#fff;border:none;cursor:pointer;border-radius:4px;">Cart</button>');

    $('#wc-tdk-cart-toggle, .wc-tdk-side-cart-overlay, .wc-tdk-side-cart-close').on('click', function() {
        $('#wc-tdk-side-cart').toggleClass('active');
        if ($('#wc-tdk-side-cart').hasClass('active')) {
            $('#wc-tdk-side-cart').show();
        } else {
            setTimeout(function() {
                $('#wc-tdk-side-cart').hide();
            }, 300);
        }
    });
});
