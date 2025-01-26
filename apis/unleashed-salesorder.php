<?php
/**
 * Sales Orders
 */

add_action('woocommerce_thankyou', 'bt_eden_create_unleashed_draft_sales_order', 10, 1);

function bt_eden_create_unleashed_draft_sales_order($order_id) {
    
    // Get WooCommerce order
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }
	
	global $api_id, $api_key;
	$guid = bt_eden_generate_guid();
	$order_items = [];
	
	foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $sku = $product->get_sku();
        $quantity = $item->get_quantity();
        $price = $product->get_price();
        $product_id   = $item->get_product_id();

        $order_items[] = [
            'LineNumber' => $item_id,
            'Product' =>  [
                'Guid' =>  get_post_meta( $product_id, '_unleashed_product_id', true ),
                'ProductCode' =>  $sku
            ],
            'OrderQuantity' =>  $quantity,
            'UnitPrice' => $price,
            'LineTotal' => $item->get_total(),
        ];
    }

    $user_info = get_userdata($order->get_user_id());
    $display_name = $user_info->display_name;

	$sales = new stdClass();

	$sales->SalesOrderLines = $order_items;
	$sales->OrderDate = date("Y-m-d");
	$sales->RequiredDate = date("Y-m-d");
    $sales->OrderNumber  = 'SO-' . $order->get_order_number();
    $sales->OrderStatus  = 'Placed';
    $sales->Customer = [
		'CustomerCode' => get_user_meta($order->get_user_id(), '_customer_code', true) ? get_user_meta($order->get_user_id(), '_customer_code', true) : 'admin',
		'CustomerName' => $display_name,
	];

	$sales->Guid = $guid;
	$sales->SubTotal = $order->get_subtotal();
	$sales->ExchangeRate = 0.989200;
	$sales->Tax = [
		'TaxCode' => 'G.S.T.',
		'TaxRate' => 0.1
	];
	$sales->TaxRate = 0.1;
	$sales->TaxTotal = $order->get_total_tax();
	$sales->Total = $order->get_total();

	bt_eden_post_to_unleashed($api_id, $api_key, "SalesOrders", "json", $sales->Guid, json_encode( $sales ));
}

// Show Unleashed order history in WooCommerce My Account
add_shortcode('bt_eden_unleashed_order_history', 'bt_eden_display_unleashed_order_history');
function bt_eden_display_unleashed_order_history() {
    if (!is_user_logged_in()) {
        return '<p>Please log in to view your order history.</p>';
    }

    global $api_id, $api_key; 
    $user_id = get_current_user_id();
    $customer_code = get_user_meta($user_id, '_customer_code', true);
    $customer_code = 'CW26';
    $request = 'customerCode=' . $customer_code;

    $response = bt_eden_get_from_unleashed($api_id, $api_key, "SalesOrders", $request, "json");

    $sales_orders = json_decode($response, true);

    if (empty($sales_orders['Items'])) {
        return '<p>No order history available.</p>';
    }

    // Display order history
    ob_start();
    echo '<ul>';
    foreach ($sales_orders['Items'] as $order) {
        echo '<li>';
        echo '<strong>Order Number:</strong> ' . esc_html($order['OrderNumber']) . '<br>';
        echo '<strong>Date:</strong> ' . esc_html($order['OrderDate']) . '<br>';
        echo '<strong>Status:</strong> ' . esc_html($order['OrderStatus']);
        echo '</li>';
    }
    echo '</ul>';
    return ob_get_clean();
}