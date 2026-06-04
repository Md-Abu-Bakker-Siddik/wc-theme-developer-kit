/* WC TDK Quick View */
jQuery(function ($) {
    var $modal = $('#wc-tdk-quick-view-modal');
    var $content = $('#wc-tdk-quick-view-content');

    if (!$modal.length || typeof wc_tdk_quick_view === 'undefined') {
        return;
    }

    var cache = {};
    var activeRequest = null;
    var loadingTimer = null;

    function normalizeId(id) {
        var n = parseInt(id, 10);
        return isNaN(n) ? 0 : n;
    }

    function openModal() {
        $modal.removeAttr('hidden').addClass('is-open').show();
        $('body').addClass('wc-tdk-quick-view-open');
    }

    function closeModal() {
        clearTimeout(loadingTimer);
        if (activeRequest && activeRequest.abort) {
            activeRequest.abort();
            activeRequest = null;
        }
        $modal.hide().attr('hidden', 'hidden').removeClass('is-open');
        $content.empty();
        $('body').removeClass('wc-tdk-quick-view-open');
        $('.wc-tdk-quick-view-button').removeClass('is-loading');
    }

    function showError(message) {
        var text = message || wc_tdk_quick_view.i18n.error;
        $content.html(
            '<p class="wc-tdk-quick-view-error">' + text + '</p>' +
            '<p><button type="button" class="button wc-tdk-quick-view-retry">' +
            wc_tdk_quick_view.i18n.retry +
            '</button></p>'
        );
    }

    function parseResponse(response) {
        if (!response) {
            return '';
        }
        if (response.success && response.data && response.data.html) {
            return response.data.html;
        }
        if (!response.success && response.data && response.data.message) {
            return { error: response.data.message };
        }
        return '';
    }

    function loadQuickView(productId, $btn) {
        productId = normalizeId(productId);

        if (!productId) {
            return;
        }

        if (cache[productId]) {
            openModal();
            $content.html(cache[productId]);
            if ($btn) {
                $btn.removeClass('is-loading');
            }
            return;
        }

        if (activeRequest && activeRequest.abort) {
            activeRequest.abort();
        }

        openModal();
        $content.html('<p class="wc-tdk-quick-view-loading">' + wc_tdk_quick_view.i18n.loading + '</p>');

        if ($btn) {
            $btn.addClass('is-loading');
        }

        clearTimeout(loadingTimer);
        loadingTimer = setTimeout(function () {
            showError(wc_tdk_quick_view.i18n.timeout);
            if ($btn) {
                $btn.removeClass('is-loading');
            }
        }, 10000);

        activeRequest = $.ajax({
            url: wc_tdk_quick_view.ajax_url,
            type: 'POST',
            dataType: 'json',
            timeout: 12000,
            data: {
                action: 'wc_tdk_quick_view',
                nonce: wc_tdk_quick_view.nonce,
                product_id: productId
            }
        });

        activeRequest
            .done(function (response) {
                clearTimeout(loadingTimer);
                var result = parseResponse(response);

                if (result && result.error) {
                    showError(result.error);
                    return;
                }

                if (result) {
                    cache[productId] = result;
                    $content.html(result);
                    return;
                }

                showError();
            })
            .fail(function (xhr, status) {
                clearTimeout(loadingTimer);
                if (status === 'abort') {
                    return;
                }
                showError();
            })
            .always(function () {
                activeRequest = null;
                if ($btn) {
                    $btn.removeClass('is-loading');
                }
            });
    }

    $(document).on('click', '.wc-tdk-quick-view-button', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $btn = $(this);
        loadQuickView($btn.data('product-id'), $btn);
    });

    $(document).on('click', '.wc-tdk-quick-view-retry', function (e) {
        e.preventDefault();
        var productId = $modal.data('last-product-id');
        loadQuickView(productId, null);
    });

    $(document).on('click', '.wc-tdk-quick-view-button', function () {
        $modal.data('last-product-id', normalizeId($(this).data('product-id')));
    });

    $(document).on('click', '.wc-tdk-quick-view-overlay, .wc-tdk-quick-view-close', function (e) {
        e.preventDefault();
        closeModal();
    });

    $(document).on('keyup', function (e) {
        if (e.key === 'Escape' && $modal.hasClass('is-open')) {
            closeModal();
        }
    });
});
