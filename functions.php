<?php
 /**
 * Functions
 */

/*
Directory
- path to the current directory
*/
define( 'DIR', dirname( __FILE__ ) );
/*
General Functions
- basic theme functions
*/
include_once( DIR . '/inc/functions-general.php' );
include_once( DIR . '/inc/gutenberg-blocks.php' );

include_once( DIR . '/apis/api-main.php' );
include_once( DIR . '/inc/login.php' );
include_once( DIR . '/inc/woo.php' );
include_once( DIR . '/inc/woo-cart.php' );
include_once( DIR . '/inc/favorite.php' );

function bte_restrict_access_unless_logged_in() {
    if (!is_user_logged_in() && !bte_is_wp_login_page() && !is_page( array( 203414, 203376, 203373, 203365, 203367 ) ) && !( is_front_page() ) ) {
        wp_redirect( home_url() . '/sign-in/' );
        exit;
    }
}
add_action('template_redirect', 'bte_restrict_access_unless_logged_in');

// Helper function to check if on login page
function bte_is_wp_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function bte_add_post_states($post_states, $post) {

    if ($post->ID == 203414) { 
        $post_states['signin_state'] = 'Sign In Page';
    }
    if ($post->ID == 203376) { 
        $post_states['signup_state'] = ' Page';
    }
    if ($post->ID == 203373) { 
        $post_states['forgot_passsword_state'] = 'Forgot Password Page';
    }
    if ($post->ID == 203365) { 
        $post_states['about_state'] = 'About Page';
    }
    if ($post->ID == 203367) { 
        $post_states['contact_state'] = 'Contact Page';
    }

    return $post_states;
}
add_filter('display_post_states', 'bte_add_post_states', 10, 2);

add_filter('gform_submit_button_2', 'bte_gravity_form_submit_button', 10, 2);
function bte_gravity_form_submit_button($button, $form) {
    // Add your custom class
    $custom_class = 'btn';

    // Modify the submit button markup
    $button = str_replace("class='gform_button", "class='gform_button $custom_class", $button);

    return $button;
}

add_filter('use_block_editor_for_post_type', 'enable_gutenberg_for_products', 10, 2);
function enable_gutenberg_for_products($is_enabled, $post_type) {
    if ($post_type === 'product') {
        return true; // Enable Gutenberg editor
    }
    return $is_enabled;
}
