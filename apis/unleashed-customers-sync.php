<?php
/**
 * Customers
 */

// Schedule daily sync with Unleashed for customers
if (!wp_next_scheduled('sync_unleashed_customers')) {
    // Set up a timestamp for 1 AM Australia/Sydney time
    $timestamp = strtotime('tomorrow 2am Australia/Sydney');
    wp_schedule_event($timestamp, 'daily', 'sync_unleashed_customers');
}
add_action('sync_unleashed_customers', 'unleashed_to_woocommerce_customer_sync');

/**
 *  Get API Customers
 */
function bt_eden_unleashed_to_woocommerce_response() {
    // Unleashed API endpoint and credentials
    global $api, $api_id, $api_key;
    $api_url = $api . 'Customers/';    

    $signature = bt_eden_getSignature("", $api_key);
    $page = 1;
    $all_customers = [];

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
            // Append the current page items to all_customers
            $all_customers = array_merge($all_customers, $data['Items']);
            $page++; // Move to the next page
        } else {
            break; // Exit if no more items or no response
        }

    } while ($page <= $data['Pagination']['NumberOfPages']);

    return $all_customers;
}

/**
 *  Customers Sync
 */
function unleashed_to_woocommerce_customer_sync() {
    
    $all_customers = bt_eden_unleashed_to_woocommerce_response();

    // Iterate over Unleashed customers
    foreach ($all_customers as $unleashed_customer) {
        // Get customer information from Unleashed
        $customer_code = $unleashed_customer['CustomerCode'];
        $email = $unleashed_customer['Email'];
        $name = $unleashed_customer['CustomerName'];
        $credit_terms = isset($unleashed_customer['HasCreditLimit']) && $unleashed_customer['HasCreditLimit'] == true; // Adjust field as per Unleashed response

        
        if( $email ) {
            // Check if customer already exists in WooCommerce
            $user = get_user_by('email', $email);

            if (!$user) {            
                $user_data = [
                    'user_login' => $email,
                    'user_pass' => wp_generate_password(),
                    'display_name' => $unleashed_customer['CustomerName'],
                    'user_email' => $unleashed_customer['Email'],
                    'role' => 'customer',
                    'first_name' => $unleashed_customer['ContactFirstName'],
                    'last_name' => $unleashed_customer['ContactLastName']
                ];

                $user_id = wp_insert_user($user_data);
                update_user_meta($user_id, '_unleashed_customer_id', $unleashed_customer['Guid']);
            } else {
                $user_id = $user->ID;
            }

            // Update customer meta for credit terms status
            update_user_meta($user_id, '_customer_code', $customer_code);
            update_user_meta($user_id, '_has_credit_terms', $credit_terms ? 'yes' : 'no');
            if( isset($unleashed_customer['Addresses'][0] ) && $unleashed_customer['Addresses'][0] ){
                // Update customer address
                update_user_meta($user_id, 'billing_address_1', $unleashed_customer['Addresses'][0]['StreetAddress']);
                update_user_meta($user_id, 'billing_address_2', $unleashed_customer['Addresses'][0]['StreetAddress2']);
                update_user_meta($user_id, 'billing_city', $unleashed_customer['Addresses'][0]['City']);
                update_user_meta($user_id, 'billing_country', $unleashed_customer['Addresses'][0]['Country']);
                update_user_meta($user_id, 'billing_state', $unleashed_customer['Addresses'][0]['Region']);
                update_user_meta($user_id, 'billing_postcode', $unleashed_customer['Addresses'][0]['PostalCode']);
            }
            update_user_meta($user_id, 'billing_phone', $unleashed_customer['PhoneNumber']);
        }
    }
}

// Add "Pay via Credit Terms" option at checkout for eligible customers
// add_filter('woocommerce_available_payment_gateways', 'bt_eden_add_credit_terms_payment_gateway');
function bt_eden_add_credit_terms_payment_gateway($gateways) {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $has_credit_terms = get_user_meta($user_id, '_has_credit_terms', true);

        // Show "Pay via Credit Terms" only for customers with credit terms
        if ($has_credit_terms === 'yes') {
            $gateways['credit_terms'] = [
                'id' => 'credit_terms',
                'title' => __('Pay via Credit Terms'),
                'description' => __('Your account has credit terms, so you can pay later.'),
                'enabled' => true,
            ];
        }
    }
    return $gateways;
}

add_action('user_register', 'bt_eden_add_customer_to_unleashed', 10, 1);

function bt_eden_add_customer_to_unleashed($user_id) {
    // Unleashed API credentials
    global $api_id, $api_key;
	$guid = bt_eden_generate_guid();

    // Get the user's data
    $user = get_userdata($user_id);
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    $email = $user->user_email;

    // Prepare the data for Unleashed API
    $customer_data = [
        'CustomerCode' => 'CUST-' . $user_id, // Unique code for the customer
        'CustomerName' => $first_name . ' ' . $last_name,
        'Email' => $email,
        'DefaultCurrency' => 'USD', // Adjust as per your Unleashed settings
    ];

    bt_eden_post_to_unleashed($api_id, $api_key, "Customers", "json", $Guid, json_encode( $customer_data ));
}
