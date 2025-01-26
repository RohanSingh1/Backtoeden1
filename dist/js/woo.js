jQuery(document).ready(function ($) {
    // Increment button
    $(document).on('click', '.quantity-control .increment', function () {
        const input = $(this).siblings('.quantity');
        input.val(parseInt(input.val()) + 1);
    });

    // Decrement button
    $(document).on('click', '.quantity-control .decrement', function () {
        const input = $(this).siblings('.quantity');
        const currentValue = parseInt(input.val());
        if (currentValue > 1) {
            input.val(currentValue - 1);
        }
    });
    
    // Increment button
    $(document).on('click', 'form.cart .quantity .increment', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.qty');
        input.val(parseInt(input.val()) + 1);
    });

    // Decrement button
    $(document).on('click', 'form.cart .quantity .decrement', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.qty');
        const currentValue = parseInt(input.val());
        if (currentValue > 1) {
            input.val(currentValue - 1);
        }
    });

    // Add to Cart button
    $(document).on('click', '.custom-add-to-cart', function () {
        const button = $(this);
        const productId = button.data('product-id');
        const quantity = button.siblings('.quantity-control').find('.quantity').val();

        $.ajax({
            url: wc_add_to_cart_params.ajax_url, // WooCommerce AJAX URL
            type: 'POST',
            data: {
                action: 'bte_custom_add_to_cart',
                product_id: productId,
                quantity: quantity,
            },
            beforeSend: function () {
                button.text('Adding...');
            },
            success: function (response) {
                if( response.success ){
                    // Update cart count
                    $('.cart-count').text(response.data.cart_count);
                    $(document.body).trigger('wc_fragment_refresh');
                }
                button.text('Added');
                setTimeout(function () {
                    button.text('Add to Cart');
                }, 5000);
            },
        });
    });
    
    // Single Add to Cart button
    $(document).on('click', '.single_add_to_cart_button', function (e) {
        e.preventDefault();
        const button = $(this);
        const productId = button.val();
        const quantity = button.siblings('.quantity').find('.qty').val();

        $.ajax({
            url: wc_add_to_cart_params.ajax_url, // WooCommerce AJAX URL
            type: 'POST',
            data: {
                action: 'bte_single_add_to_cart',
                product_id: productId,
                quantity: quantity,
            },
            success: function (response) {
                if( response.success ){
                    // Update cart count
                    $('.cart-count').text(response.data.cart_count);
                    $('.add-to-cart-notification-main').addClass('enable');
                    $(document.body).trigger('wc_fragment_refresh');
                }else{
                    $('.add-to-cart-notification-fail').addClass('enable');
                }
                setTimeout(function() {
                    $('.add-to-cart-notification-main').removeClass('enable');
                    $('.add-to-cart-notification-fail').removeClass('enable');
                }, 2000);
            },
        });
    });

});

jQuery(document).ready(function ($) {
    // add favorite id
    $(document).on('click', '.favorite-icon', function (e) {
        e.preventDefault();
        var item_id = $(this).attr('data-item_id');

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                'action': 'bte_add_favorite_id',
                'item_id': item_id
            },
            success: function (result) {
                if (result.success) {
                    $('.favorite-' + item_id).html('<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_960_848)"><path d="M9.74969 16.2149C9.63921 16.2145 9.53196 16.1776 9.44469 16.1099C6.66469 13.9499 4.74969 12.0899 3.40969 10.2549C1.69969 7.90985 1.30969 5.74485 2.24969 3.81985C2.91969 2.44485 4.84469 1.31985 7.09469 1.97485C8.16746 2.28472 9.10343 2.94924 9.74969 3.85985C10.3959 2.94924 11.3319 2.28472 12.4047 1.97485C14.6497 1.32985 16.5797 2.44485 17.2497 3.81985C18.1897 5.74485 17.7997 7.90985 16.0897 10.2549C14.7497 12.0899 12.8347 13.9499 10.0547 16.1099C9.96741 16.1776 9.86016 16.2145 9.74969 16.2149ZM5.81469 2.78985C5.27932 2.76902 4.74838 2.89438 4.27886 3.15248C3.80935 3.41058 3.41899 3.79167 3.14969 4.25485C2.37469 5.84485 2.72469 7.61485 4.21969 9.65985C5.80787 11.7097 7.66837 13.5332 9.74969 15.0799C11.8307 13.5347 13.6912 11.7129 15.2797 9.66485C16.7797 7.61485 17.1247 5.84485 16.3497 4.25985C15.8497 3.25985 14.3497 2.46485 12.6797 2.93485C12.1442 3.0931 11.6478 3.36171 11.2224 3.72339C10.797 4.08507 10.452 4.53181 10.2097 5.03485C10.172 5.12656 10.1079 5.20499 10.0256 5.26019C9.94323 5.3154 9.84633 5.34487 9.74719 5.34487C9.64805 5.34487 9.55115 5.3154 9.46879 5.26019C9.38644 5.20499 9.32236 5.12656 9.28469 5.03485C9.04418 4.53055 8.6998 4.08277 8.27413 3.72086C7.84847 3.35896 7.35112 3.0911 6.81469 2.93485C6.48969 2.84039 6.15313 2.79159 5.81469 2.78985Z" fill="#4CAF50"/></g><defs><clipPath id="clip0_960_848"><rect width="18" height="18" fill="#7ad03a" transform="translate(0.75)"/></clipPath></defs></svg>');
                    $('.favorite-' + item_id).addClass('favorite-icon-fill');
                    $('.favorite-' + item_id).removeClass('favorite-icon');
                }
                // window.location.reload();
            },
            error: function (err) {
                $('#errormessage').text('An error occurred.').show();
            }
        });
    });

    // remove favorite list from favorite group
    $(document).on('click', '.favorite-icon-fill, .favorite-icon.fill', function (e) {
        e.preventDefault();
        var item_id = $(this).attr('data-item_id');

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                'action': 'bte_remove_favorite_id',
                'item_id': item_id
            },
            success: function (result) {
                if (result.success) {
                    $('.favorite-' + item_id).html('<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_960_848)"><path d="M9.74969 16.2149C9.63921 16.2145 9.53196 16.1776 9.44469 16.1099C6.66469 13.9499 4.74969 12.0899 3.40969 10.2549C1.69969 7.90985 1.30969 5.74485 2.24969 3.81985C2.91969 2.44485 4.84469 1.31985 7.09469 1.97485C8.16746 2.28472 9.10343 2.94924 9.74969 3.85985C10.3959 2.94924 11.3319 2.28472 12.4047 1.97485C14.6497 1.32985 16.5797 2.44485 17.2497 3.81985C18.1897 5.74485 17.7997 7.90985 16.0897 10.2549C14.7497 12.0899 12.8347 13.9499 10.0547 16.1099C9.96741 16.1776 9.86016 16.2145 9.74969 16.2149ZM5.81469 2.78985C5.27932 2.76902 4.74838 2.89438 4.27886 3.15248C3.80935 3.41058 3.41899 3.79167 3.14969 4.25485C2.37469 5.84485 2.72469 7.61485 4.21969 9.65985C5.80787 11.7097 7.66837 13.5332 9.74969 15.0799C11.8307 13.5347 13.6912 11.7129 15.2797 9.66485C16.7797 7.61485 17.1247 5.84485 16.3497 4.25985C15.8497 3.25985 14.3497 2.46485 12.6797 2.93485C12.1442 3.0931 11.6478 3.36171 11.2224 3.72339C10.797 4.08507 10.452 4.53181 10.2097 5.03485C10.172 5.12656 10.1079 5.20499 10.0256 5.26019C9.94323 5.3154 9.84633 5.34487 9.74719 5.34487C9.64805 5.34487 9.55115 5.3154 9.46879 5.26019C9.38644 5.20499 9.32236 5.12656 9.28469 5.03485C9.04418 4.53055 8.6998 4.08277 8.27413 3.72086C7.84847 3.35896 7.35112 3.0911 6.81469 2.93485C6.48969 2.84039 6.15313 2.79159 5.81469 2.78985Z" fill="#111111"/></g><defs><clipPath id="clip0_960_848"><rect width="18" height="18" fill="#7ad03a" transform="translate(0.75)"/></clipPath></defs></svg>');
                    $('.favorite-' + item_id).removeClass('favorite-icon-fill');
                    $('.favorite-' + item_id).addClass('favorite-icon');
                }
                // window.location.reload();
            },
            error: function (err) {
                $('#errormessage').text('An error occurred.').show();
            }
        });
    });
});

jQuery(document).ready(function ($) {
    if( wc_add_to_cart_params.is_shop === '1' || wc_add_to_cart_params.is_product_cat === '1' ) {
        function bte_fetchProducts(page = 1, orderby = 'menu_order', cat = '') {
            $.ajax({
                url: wc_add_to_cart_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'bte_shop_filter',
                    nonce: wc_add_to_cart_params.nonce,
                    page: page,
                    orderby: orderby,
                    category: cat,
                },
                beforeSend: function () {
                    $('#product-grid').fadeTo('fast', 0.5);
                },
                success: function (response) {
                    if (response.success) {
                        $('.shop-count').html(response.data.total).fadeTo('fast', 1);
                        $('#product-grid').html(response.data.products).fadeTo('fast', 1);
                        bte_renderPagination(response.data.pagination);
                    } else {
                        $('.shop-count').html(response.data.total)
                        $('#product-grid').html(response.data.message);
                        bte_renderPagination(response.data.pagination);
                    }
                },
            });
        }

        function bte_renderPagination(pages) {
            const container = $('#pagination-container');
            container.html('');
            if (pages) {
                pages.forEach((page) => {
                    container.append(page);
                });
            }
        }

        const cat_id = $('.shop-header').attr('data-cat_id');

        // Handle sorting change
        $('#sortby').change(function () {
            debugger;
            const orderby = $(this).val();
            bte_fetchProducts(1, orderby, cat_id); // Reset to page 1 on sort change
        });

        // Handle pagination click
        $('#pagination-container').on('click', 'a', function (e) {
            e.preventDefault();
            const page = $(this).text();
            const orderby = $('#sortby').val();
            bte_fetchProducts(page, orderby, cat_id);
        });

        // Initial load
        bte_fetchProducts( page = 1, orderby = 'menu_order', cat_id );
    }
});

jQuery(document).ready(function ($) {
    // Increment quantity
    $(document).on('click', 'form.woocommerce-cart-form .quantity .increment', function (e) {
        e.preventDefault();
        var $input = $(this).siblings('.qty');
        var max = parseInt($input.attr('max')) || 9999;
        var currentValue = parseInt($input.val()) || 1;

        if (currentValue < max) {
            $input.val(currentValue + 1).trigger('change');
        }
    });

    // Decrement quantity
    $(document).on('click', 'form.woocommerce-cart-form .quantity .decrement', function (e) {
        e.preventDefault();
        var $input = $(this).siblings('.qty');
        var min = parseInt($input.attr('min')) || 1;
        var currentValue = parseInt($input.val()) || 1;

        if (currentValue > min) {
            $input.val(currentValue - 1).trigger('change');
        }
    });

    // Trigger cart update on quantity change
    $(document).on('change', 'form.woocommerce-cart-form .quantity', function () {
        var $form = $('form.woocommerce-cart-form');
        $form.find('button[name="update_cart"]').prop('disabled', false); // Enable the update cart button
    });
});
