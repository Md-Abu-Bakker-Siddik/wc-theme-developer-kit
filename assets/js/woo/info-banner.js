(function ($) {
    'use strict';

    var wcTdkBannerReveal = {
        init: function () {
            this.holder = $('.tm-sc-info-banner-advanced');

            if (this.holder.length) {
                this.holder.each(function () {
                    wcTdkBannerReveal.initItem($(this));
                });
            }
        },
        initItem: function ($currentItem) {
            if ($currentItem.hasClass('tm-layout-top-reveal')) {
                var $text = $currentItem.find('.text-paragraph'),
                    $button = $currentItem.find('.btn-view-details'),
                    textHeight = $text.outerHeight(true);
                $button.css(
                    'transform',
                    'translateY(-' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(function () {
                    $currentItem.addClass('wc-tdk--visible');
                }, 400);
            }
        },
    };

    var wcTdkBannerFromBottom = {
        init: function () {
            this.holder = $('.tm-sc-info-banner-advanced');

            if (this.holder.length) {
                this.holder.each(function () {
                    wcTdkBannerFromBottom.initItem($(this));
                });
            }
        },
        initItem: function ($currentItem) {
            if ($currentItem.hasClass('tm-layout-bottom')) {
                var $text = $currentItem.find('.content-holder'),
                    $content = $currentItem.find('.info-banner-text-holder-inner'),
                    textHeight = $text.outerHeight(true);

                $content.css(
                    'transform',
                    'translateY(' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(function () {
                    $currentItem.addClass('wc-tdk--visible');
                }, 400);
            }
        },
    };

    $(document).ready(function () {
        wcTdkBannerReveal.init();
        wcTdkBannerFromBottom.init();
    });
})(jQuery);
