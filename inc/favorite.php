<?php

function bte_get_user_favorite_list( $product_id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'favorite_sync';
    $user_id = get_current_user_id();
    
    if( $user_id ) {
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %s",
            $user_id
        );
        $results = $wpdb->get_results($query);
        $products_array = array_column($results, 'item_id');
        
        if( in_array( $product_id, $products_array ) ) {
            return '<span class="favorite-icon-fill favorite-' . absint( $product_id ) . '" data-item_id="' . absint( $product_id ) . '">
                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_960_848)">
                    <path d="M9.74969 16.2149C9.63921 16.2145 9.53196 16.1776 9.44469 16.1099C6.66469 13.9499 4.74969 12.0899 3.40969 10.2549C1.69969 7.90985 1.30969 5.74485 2.24969 3.81985C2.91969 2.44485 4.84469 1.31985 7.09469 1.97485C8.16746 2.28472 9.10343 2.94924 9.74969 3.85985C10.3959 2.94924 11.3319 2.28472 12.4047 1.97485C14.6497 1.32985 16.5797 2.44485 17.2497 3.81985C18.1897 5.74485 17.7997 7.90985 16.0897 10.2549C14.7497 12.0899 12.8347 13.9499 10.0547 16.1099C9.96741 16.1776 9.86016 16.2145 9.74969 16.2149ZM5.81469 2.78985C5.27932 2.76902 4.74838 2.89438 4.27886 3.15248C3.80935 3.41058 3.41899 3.79167 3.14969 4.25485C2.37469 5.84485 2.72469 7.61485 4.21969 9.65985C5.80787 11.7097 7.66837 13.5332 9.74969 15.0799C11.8307 13.5347 13.6912 11.7129 15.2797 9.66485C16.7797 7.61485 17.1247 5.84485 16.3497 4.25985C15.8497 3.25985 14.3497 2.46485 12.6797 2.93485C12.1442 3.0931 11.6478 3.36171 11.2224 3.72339C10.797 4.08507 10.452 4.53181 10.2097 5.03485C10.172 5.12656 10.1079 5.20499 10.0256 5.26019C9.94323 5.3154 9.84633 5.34487 9.74719 5.34487C9.64805 5.34487 9.55115 5.3154 9.46879 5.26019C9.38644 5.20499 9.32236 5.12656 9.28469 5.03485C9.04418 4.53055 8.6998 4.08277 8.27413 3.72086C7.84847 3.35896 7.35112 3.0911 6.81469 2.93485C6.48969 2.84039 6.15313 2.79159 5.81469 2.78985Z" fill="#4CAF50"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_960_848">
                    <rect width="18" height="18" fill="#7ad03a" transform="translate(0.75)"/>
                    </clipPath>
                    </defs>
                </svg>
            </span>';
        }
    }

    return '<span class="favorite-icon favorite-' . absint( $product_id ) . '" data-item_id="' . absint( $product_id ) . '">
        <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_960_848)">
            <path d="M9.74969 16.2149C9.63921 16.2145 9.53196 16.1776 9.44469 16.1099C6.66469 13.9499 4.74969 12.0899 3.40969 10.2549C1.69969 7.90985 1.30969 5.74485 2.24969 3.81985C2.91969 2.44485 4.84469 1.31985 7.09469 1.97485C8.16746 2.28472 9.10343 2.94924 9.74969 3.85985C10.3959 2.94924 11.3319 2.28472 12.4047 1.97485C14.6497 1.32985 16.5797 2.44485 17.2497 3.81985C18.1897 5.74485 17.7997 7.90985 16.0897 10.2549C14.7497 12.0899 12.8347 13.9499 10.0547 16.1099C9.96741 16.1776 9.86016 16.2145 9.74969 16.2149ZM5.81469 2.78985C5.27932 2.76902 4.74838 2.89438 4.27886 3.15248C3.80935 3.41058 3.41899 3.79167 3.14969 4.25485C2.37469 5.84485 2.72469 7.61485 4.21969 9.65985C5.80787 11.7097 7.66837 13.5332 9.74969 15.0799C11.8307 13.5347 13.6912 11.7129 15.2797 9.66485C16.7797 7.61485 17.1247 5.84485 16.3497 4.25985C15.8497 3.25985 14.3497 2.46485 12.6797 2.93485C12.1442 3.0931 11.6478 3.36171 11.2224 3.72339C10.797 4.08507 10.452 4.53181 10.2097 5.03485C10.172 5.12656 10.1079 5.20499 10.0256 5.26019C9.94323 5.3154 9.84633 5.34487 9.74719 5.34487C9.64805 5.34487 9.55115 5.3154 9.46879 5.26019C9.38644 5.20499 9.32236 5.12656 9.28469 5.03485C9.04418 4.53055 8.6998 4.08277 8.27413 3.72086C7.84847 3.35896 7.35112 3.0911 6.81469 2.93485C6.48969 2.84039 6.15313 2.79159 5.81469 2.78985Z" fill="#111111"/>
            </g>
            <defs>
            <clipPath id="clip0_960_848">
            <rect width="18" height="18" fill="white" transform="translate(0.75)"/>
            </clipPath>
            </defs>
        </svg>
    </span>';
}

add_action('wp_ajax_nopriv_bte_add_favorite_id', 'bte_add_favorite_id');
add_action('wp_ajax_bte_add_favorite_id', 'bte_add_favorite_id');

function bte_add_favorite_id(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'favorite_sync';
    
    $item_id = isset($_POST["item_id"]) ? sanitize_text_field($_POST["item_id"]) : "";    
    $user_id = get_current_user_id();

    $data = array(
        "user_id" => $user_id,
        "item_id" => $item_id,
        "modified" => date('Y-m-d H:i:s'), // Use MySQL datetime format
    );

    $result = $wpdb->insert($table_name, $data);

    // Check if deletion was successful
    if ($result !== false) {
        $response = array(
            'success' => true,
            'message' => 'Favorite added successfully.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Failed to add favorite.',
        );
    }

    wp_send_json($response);
    wp_die();

}

add_action('wp_ajax_nopriv_bte_remove_favorite_id', 'bte_remove_favorite_id');
add_action('wp_ajax_bte_remove_favorite_id', 'bte_remove_favorite_id');

function bte_remove_favorite_id() {
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'favorite_sync';
    
    $item_id = isset($_POST["item_id"]) ? sanitize_text_field($_POST["item_id"]) : "";    
    $user_id = get_current_user_id();

    // Prepare query to delete favorite
    $query = $wpdb->prepare(
        "DELETE FROM $table_name WHERE user_id = %s AND item_id = %s",
        $user_id,
        $item_id
    );

    // Execute query
    $result = $wpdb->query($query);

    // Check if deletion was successful
    if ($result !== false) {
        $response = array(
            'success' => true,
            'message' => 'Favorite removed successfully.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Failed to remove favorite.',
        );
    }

    wp_send_json($response);
}