<?php 

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-add-to-cart', get_template_directory_uri() . '/dist/js/woo.js', ['jquery'], time(), true);
    wp_localize_script('custom-add-to-cart', 'wc_add_to_cart_params', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('shop-ajax-nonce'),
        'is_shop'  => is_shop(),
        'is_product_cat'  => is_tax('product_cat'),
    ]);
}

// Handle Custom Add to Cart AJAX Request
add_action('wp_ajax_bte_custom_add_to_cart', 'bte_custom_add_to_cart_handler');
add_action('wp_ajax_nopriv_bte_custom_add_to_cart', 'bte_custom_add_to_cart_handler');

function bte_custom_add_to_cart_handler() {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if (!$product_id || !$quantity) {
        wp_send_json_error(['message' => 'Invalid product or quantity.']);
    }

    $product = wc_get_product($product_id);

    if (!$product || !$product->is_purchasable()) {
        wp_send_json_error(['message' => 'Product not purchasable.']);
    }

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);

    if ($cart_item_key) {
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', []),
        ]);
    } else {
        wp_send_json_error(['message' => 'Failed to add product to cart.']);
    }

    wp_die();
}

add_action('wp_ajax_bte_shop_filter', 'bte_handle_shop_filter');
add_action('wp_ajax_nopriv_bte_shop_filter', 'bte_handle_shop_filter');

function bte_handle_shop_filter() {
    // Nonce verification for security

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'menu_order';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $posts_per_page = 20; // Number of products per page

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $orderby === 'price-low-high' || $orderby === 'price-high-low' ? 'ASC' : 'DESC',
    ];

    // If categories are selected, add a tax_query to filter by category
    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category,
                'operator' => 'IN',
            ]
        ];
    }

    // Handle specific sorting conditions
    if ($orderby === 'price-high-low') {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_price';
        $args['order'] = 'DESC';
    } elseif ($orderby === 'price-low-high') {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_price';
    } elseif ($orderby === 'popularity') {
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
    } elseif ($orderby === 'rating') {
        $args['meta_key'] = '_wc_average_rating';
        $args['orderby'] = 'meta_value_num';
    } elseif ($orderby === 'latest') {
        $args['meta_key'] = 'date';
        $args['orderby'] = 'DESC';
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            $product_image_url = get_field('_featured_image_url',  $product->get_id() );
            ?>
            <div class="product-card">
                <div class="product-header">
					<?php if( get_post_meta( $product->get_id(), '_product_best_seller', true ) ) echo '<span class="bt-seller">Best Seller</span>'; ?>
					<?php echo ( $product_image_url ) ? '<img src="' . esc_url( $product_image_url ) . '" alt="'. $product->get_name() .'" class="wp-post-image">' : $product->get_image(); ?>				
				</div>	
				<div class="product-body">
                    <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><h3 class="product-title"><?php echo esc_html( $product->get_name() ); ?></h3></a>
                    <p class="product-price"><?php echo $product->get_price_html(); ?></p>
                    <div class="product-actions">
                        <div class="quantity-control">
                            <button class="decrement">
                                <svg width="8" height="2" viewBox="0 0 8 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.321289 1.77525V0.225098H7.98877V1.77525H0.321289Z" fill="#252525"/>
                                </svg>
                            </button>
                            <input type="number" class="quantity" value="1" min="1" data-product-id="<?php echo $product->get_id(); ?>">
                            <button class="increment">
                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22537 3.39187V0.154785H5.44118V3.39187H8.67827V4.60768H5.44118V7.84477H4.22537V4.60768H0.988281V3.39187H4.22537Z" fill="#252525"/>
                                </svg>
                            </button>
                        </div>
                        <button class="custom-add-to-cart btn btn--green" data-product-id="<?php echo $product->get_id(); ?>">Add to Cart</button>
                    </div>
                </div>
            </div>
            <?php
        }
        $products = ob_get_clean();

        // Pagination Links
        $pagination = paginate_links([
            'base' => '%_%',
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $query->max_num_pages,
            'type' => 'array',
        ]);

        wp_send_json_success(['products' => $products, 'pagination' => $pagination, 'total' => $query->found_posts .' results' ]);
    } else {
        wp_send_json_error(['message' => 'No products found.', 'pagination' => '', 'total' =>  '0 results' ]);
    }
}

add_action('wp_ajax_bte_single_add_to_cart', 'bte_single_add_to_cart_handler');
add_action('wp_ajax_nopriv_bte_single_add_to_cart', 'bte_single_add_to_cart_handler');

function bte_single_add_to_cart_handler() {
    // Get product ID and quantity from AJAX request
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if (!$product_id || !$quantity) {
        wp_send_json_error(['message' => 'Invalid product ID or quantity']);
        return;
    }

    // Add the product to the cart
    $added = WC()->cart->add_to_cart($product_id, $quantity);

    if ($added) {
        // Send the updated cart count and fragments back
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', []),
        ]);
    } else {
        wp_send_json_error(['message' => 'Failed to add to cart']);
    }
}
