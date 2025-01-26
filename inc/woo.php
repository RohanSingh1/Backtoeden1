<?php
	 
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


add_action( 'bte_single_product_summary', 'bte_template_single_meta', 5 );
/**
 * Output the product meta.
 */
function bte_template_single_meta() {
    wc_get_template( 'single-product/meta.php' );
}

add_action( 'bte_single_product_after_summary', 'woocommerce_template_single_excerpt', 5 );

/**
 * Output the quantity input.
 */
add_action( 'woocommerce_before_quantity_input_field', 'bte_woocommerce_before_quantity_input_field', 5 );
function bte_woocommerce_before_quantity_input_field() {
    echo '<button class="decrement">
        <svg width="8" height="2" viewBox="0 0 8 2" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.321289 1.77525V0.225098H7.98877V1.77525H0.321289Z" fill="#252525"/>
        </svg>
    </button>';
}

/**
 * Output the quantity input.
 */
add_action( 'woocommerce_after_quantity_input_field', 'bte_woocommerce_after_quantity_input_field', 5 );
function bte_woocommerce_after_quantity_input_field() {
    echo '<button class="increment">
        <svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.22537 3.39187V0.154785H5.44118V3.39187H8.67827V4.60768H5.44118V7.84477H4.22537V4.60768H0.988281V3.39187H4.22537Z" fill="#252525"/>
        </svg>
    </button>';
}

add_action( 'woocommerce_save_account_details_errors', 'bte_validate_custom_fields', 10, 2 );

function bte_validate_custom_fields( $errors, $user ) {
    if ( isset( $_POST['account_birthday'] ) && empty( $_POST['account_birthday'] ) ) {
        $errors->add( 'account_birthday_error', __( 'Please enter a value for the field.', 'woocommerce' ) );
    }
    if ( isset( $_POST['account_business_name'] ) && empty( $_POST['account_business_name'] ) ) {
        $errors->add( 'account_business_name_error', __( 'Please enter a value for the field.', 'woocommerce' ) );
    }
    if ( isset( $_POST['account_business_email'] ) && empty( $_POST['account_business_email'] ) ) {
        $errors->add( 'account_business_email_error', __( 'Please enter a value for the  field.', 'woocommerce' ) );
    }
    if ( isset( $_POST['account_business_type'] ) && empty( $_POST['account_business_type'] ) ) {
        $errors->add( 'account_business_type_error', __( 'Please enter a value for the field.', 'woocommerce' ) );
    }
}

add_action( 'woocommerce_save_account_details', 'bte_save_custom_fields' );

function bte_save_custom_fields( $user_id ) {
    update_user_meta( $user_id, 'birthday', sanitize_text_field( $_POST['account_birthday'] ) );    
    update_user_meta( $user_id, 'business_name', sanitize_text_field( $_POST['account_business_name'] ) );    
    update_user_meta( $user_id, 'business_email', sanitize_text_field( $_POST['account_business_email'] ) );
    update_user_meta( $user_id, 'business_type', sanitize_text_field( $_POST['account_business_type'] ) );
}

add_action( 'woocommerce_single_product_image_thumbnail_html', 'bte_single_product_image_html', 10, 2 );

function bte_single_product_image_html( $html, $image_id ) {

    $image_url = get_field('_featured_image_url',  get_the_ID() );

    if( isset( $image_url ) && $image_url ) {
        $html = '<img src="' . esc_url( $image_url ) . '" alt="'. get_the_title( get_the_ID() ) .'" class="wp-post-image">';
    }

    return $html;
}

function bte_add_to_cart_notification_main() {
    if ( is_singular('product' ) ) { ?>    
        <div class="add-to-cart-notification-main">
            Added to cart.
        </div>
        <div class="add-to-cart-notification-fail">
            Failed to add product to cart.
        </div>
        <?php
    }
}
add_action('wp_footer','bte_add_to_cart_notification_main');

add_filter('woocommerce_add_to_cart_fragments', 'bte_update_cart_count_fragment');

function bte_update_cart_count_fragment($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();

    return $fragments;
}

add_action('woocommerce_save_account_details_errors', 'validate_password_requirements_on_account_page', 10, 2);

function validate_password_requirements_on_account_page($args, $current_user) {
    if (!isset($_POST['password_1']) || empty($_POST['password_1'])) {
        return; // Skip validation if no new password is being set
    }

    $password = $_POST['password_1']; // New password field
    $confirm_password = $_POST['password_2']; // Confirm password field

    // Check password length
    if (strlen($password) < 12) {
        wc_add_notice(__('Password must be at least 12 characters long.', 'woocommerce'), 'error');
    }

    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        wc_add_notice(__('Password must contain at least one uppercase letter.', 'woocommerce'), 'error');
    }

    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        wc_add_notice(__('Password must contain at least one lowercase letter.', 'woocommerce'), 'error');
    }

    // Check for at least one digit
    if (!preg_match('/\d/', $password)) {
        wc_add_notice(__('Password must contain at least one number.', 'woocommerce'), 'error');
    }

    // Check for at least one special character
    if (!preg_match('/[\W_]/', $password)) {
        wc_add_notice(__('Password must contain at least one special character.', 'woocommerce'), 'error');
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        wc_add_notice(__('Passwords do not match.', 'woocommerce'), 'error');
    }
}

add_filter('woocommerce_gateway_title', 'bte_rename_cash_on_delivery', 10, 2);

function bte_rename_cash_on_delivery($title, $id) {
    if ('cod' === $id) {
        $title = 'Add Order to Account'; // Replace with your desired title
    }
    return $title;
}

add_filter('woocommerce_gateway_description', 'bte_add_cash_on_delivery_description', 10, 2);
// Add a custom description for the payment method
function bte_add_cash_on_delivery_description($description, $id) {
    if ('cod' === $id) {
        $description = 'You can pay for your order when it arrives at your doorstep. If you are a regular Customer.';
    }
    return $description;
}