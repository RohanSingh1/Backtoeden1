<?php
/**
 * Products
 */

/**
 * Cron Job
 */ 
function bt_eden_setup_unleashed_sync_cron() {
    if (!wp_next_scheduled('pull_unleashed_products_evt')) {
        // Set up a timestamp for 1 AM Australia/Sydney time
        $timestamp = strtotime('tomorrow 1am Australia/Sydney');
        wp_schedule_event($timestamp, 'daily', 'pull_unleashed_products_evt');
    }
}
add_action('wp', 'bt_eden_setup_unleashed_sync_cron');

/**
 *  Get API Products
 */
function bt_eden_fetch_unleashed_products(){
    
    // Unleashed API endpoint and credentials
    global $api, $api_id, $api_key;
    $api_url = $api . 'Products/'; 

    $page = 1;
    $all_products = [];
    $signature = bt_eden_getSignature("", $api_key);

    do {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$api_url}{$page}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json",
            "api-auth-id: $api_id",
            "api-auth-signature: $signature",
            "api-auth-timestamp: " . gmdate("Y-m-d\TH:i:s\Z"),  // Added timestamp
            "client-type: StoneDigital/BackToEden"
        ]);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            curl_close($ch);
            break;
        }

        $data = json_decode($response, true);
        curl_close($ch);

        if (isset($data['Items']) && !empty($data['Items'])) {
            // Append the current page items to all_products
            $all_products = array_merge($all_products, $data['Items']);
            $page++; // Move to the next page
        } else {
            break; // Exit if no more items or no response
        }

    } while ($page <= $data['Pagination']['NumberOfPages']);

    return $all_products;
}

/**
 * Category Funtions
 */
function bt_eden_get_or_create_category($category_name) {
    // Check if the category exists
    $term = get_term_by('name', $category_name, 'product_cat');
    
    if ($term) {
        return $term->term_id; // Return existing category ID
    } else {
        // Create new category
        $new_category = wp_insert_term($category_name, 'product_cat');
        if (!is_wp_error($new_category)) {
            return $new_category['term_id'];
        }
    }
    
    return false;
}

/**
 * Function to set a product image from a URL.
 */
function bt_eden_get_single_product($sku) {
    
    global $api_id, $api_key;
    $request = 'ProductCode=' . $sku;
    $response = bt_eden_get_from_unleashed($api_id, $api_key, "Products", $request, "json");
    $single_product = json_decode($response, true);

    $image_url = '';
    
    if( $single_product['Items'][0]['ImageUrl'] ) {
        $image_url = $single_product['Items'][0]['ImageUrl'];
    }

    return $image_url;
}

/**
 * Product Sync to woo
 */
function bt_eden_create_or_update_woocommerce_product($product_data) {
    if (empty($product_data['ProductCode'])) {
        return;
    }
    
    $sku = $product_data['ProductCode'];    
    // $image_url = bt_eden_get_single_product( $sku );

    $existing_product_id = wc_get_product_id_by_sku($sku);

    // Prepare product data
    $product_args = [
        'name' => $product_data['ProductDescription'],
        'sku' => $sku,
        'regular_price' => $product_data['DefaultPurchasePrice'],
        'sale_price' => $product_data['DefaultSellPrice'],
        'manage_stock' => false,
        'stock_status' => 'instock',
        'backorders' => 'yes'        
    ];

    // Check and assign category
    if (!empty($product_data['ProductGroup']['GroupName'])) {
        $category_id = bt_eden_get_or_create_category($product_data['ProductGroup']['GroupName']);
        if ($category_id) {
            $product_args['category_ids'] = [$category_id];
        }
    }
    
    // Check if product exists and update or create accordingly
    if ($existing_product_id) {
        $product = new WC_Product($existing_product_id);
        $product->set_props($product_args);
        $product->save();

        // Add product image
        // if (!empty($image_url) && !has_post_thumbnail($existing_product_id)) {
        //     update_field('field_6751123faa453', $image_url, $existing_product_id );
        // }

    } else {
        $product = new WC_Product();
        $product->set_props($product_args);
        $product_id = $product->save();
        update_post_meta($product_id, '_unleashed_product_id', $product_data['Guid']);

        // Add product image
        // if (!empty($image_url)) {
        //     update_field('field_6751123faa453', $image_url, $product_id );
        // }
    }
}

/**
 * Main Funtions
 */
function sync_unleashed_to_woocommerce(){
    $unleashed_products = bt_eden_fetch_unleashed_products();

    foreach($unleashed_products as $product_data) {
        if( $product_data['IsSellable'] ) {
            bt_eden_create_or_update_woocommerce_product($product_data);
        }
    }
}

// Hook the custom function to the cron event
add_action('pull_unleashed_products_evt', 'sync_unleashed_to_woocommerce');