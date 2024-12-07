jQuery(function($) {
    const $grid = $('.products-grid');
    const $loadMoreBtn = $('.load-more-button');

    $loadMoreBtn.on('click', function() {
        const $btn = $(this);
        const currentPage = parseInt($btn.data('page'));
        const maxPages = parseInt($btn.data('max'));

        $.ajax({
            url: wpGridProducts.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_products',
                nonce: wpGridProducts.nonce,
                page: currentPage + 1
            },
            beforeSend: function() {
                $btn.text('Loading...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    $grid.append(response.data.html);
                    $btn.data('page', currentPage + 1);
                    
                    if (!response.data.hasMore) {
                        $btn.parent().remove();
                    }
                }
            },
            complete: function() {
                $btn.text('Load More').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.buy-now-button', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        window.location.href = '?add-to-cart=' + productId + '&quantity=1';
    });
});