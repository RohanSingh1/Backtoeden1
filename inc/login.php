<?php 

function bte_login_form_shortcode() {
	ob_start(); ?>
		<main>
            <section aria-labelledby="login-section" class="login overlap">
                <div class="login__bg-img height-full">
                    <img class="cover-fit height-full width-full" src="<?php echo ( ! wp_is_mobile() ) ? get_template_directory_uri() . '/assets/images/login.png' : get_template_directory_uri() . '/assets/images/login-mobile.png'; ?>" alt="country side">
                </div>
                <div class="login__form form">
                    <div class="form__wrapper container <?php echo ( wp_is_mobile() ) ? 'bg-color-off-white' : 'bg-color-white'; ?> border-radius-10" data-type="narrow">
                        <?php if(is_user_logged_in()) :
                            echo  '<h2 class="form__title font-weight-700">You are already logged in.</h2>';
                        else: ?>
                            <h2 class="form__title font-weight-700">
                                Login
                            </h2>
                            <p class="form__desc">
                            Log in below to check out with an existing account
                            </p>
                            <form id="login-form" aria-label="Login form" class="login__form form__main">
                                <div class="form__grid">
                                    <div class="form-group">
                                        <label for="username" class="visually-hidden">Username</label>
                                        <input type="text" id="bte_username" name="username" required placeholder="Username">
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="visually-hidden">Password</label>
                                        <input type="password" id="bte_password" name="password" required placeholder="Password">
                                    </div>
                                </div>
                                <p class="forgot-link"><a href="<?php echo home_url() . '/forgot-password/'; ?>">Forgot Password?</a></p>  
                                <div class="form__footer flex">
                                    <button type="submit" class="btn">Login</button>
                                    <p class="signup-link">No account yet? <a href="<?php echo home_url() . '/sign-up/'; ?>">Create Wholesale Account</a></p>
                                </div>
                            </form>
                            <div id="login-message"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
	<?php
	return ob_get_clean();
}
add_shortcode('bte_login_form', 'bte_login_form_shortcode');

function bte_ajax_login() {
	$info = array();
	$info['user_login'] = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember'] = true;

	$user_signon = wp_signon($info, false);
	if (is_wp_error($user_signon)) {
		wp_send_json_error(array('message' => 'Wrong username or password.'));
	} else {
		wp_send_json_success(array('message' => '', 'reset' => false));
	}

	wp_die();
}

add_action('wp_ajax_nopriv_bte_ajax_login', 'bte_ajax_login');
add_action('wp_ajax_bte_ajax_login', 'bte_ajax_login');

function bte_handle_forgot_password() {
	check_ajax_referer('ajax-nonce', 'nonce');

	$user_login = sanitize_text_field($_POST['user_login']);
	$user = get_user_by('login', $user_login);

	if (!$user && is_email($user_login)) {
		$user = get_user_by('email', $user_login);
	}

	if (!$user) {
		wp_send_json_error('User not found.');
	}

    // Generate reset key and URL
	$reset_key = get_password_reset_key($user);
	$reset_url = add_query_arg(array('key' => $reset_key, 'login' => rawurlencode($user->user_login)), wp_login_url());

    // Send reset email
	$message = "To reset your password, visit the following address:\n\n" . $reset_url;
	$email_sent = wp_mail($user->user_email, 'Password Reset', $message);

	if ($email_sent) {
		wp_send_json_success('Password reset email has been sent.');
	} else {
		wp_send_json_error('Failed to send password reset email.');
	}
}
add_action('wp_ajax_nopriv_bte_handle_forgot_password', 'bte_handle_forgot_password');

function bte_forgot_password_form_shortcode() {
	ob_start(); ?>
		<main>
			<section aria-labelledby="forgot-password-section" class="forgot-password overlap">
				<div class="forgot-password__bg-img height-full">
                    <img class="cover-fit height-full width-full" src="<?php echo ( ! wp_is_mobile() ) ? get_template_directory_uri() . '/assets/images/login.png' : get_template_directory_uri() . '/assets/images/login-mobile.png'; ?>" alt="country side">
				</div>
				<div class="forgot-password__form form">
                    <div class="form__wrapper container <?php echo ( wp_is_mobile() ) ? 'bg-color-off-white' : 'bg-color-white'; ?> border-radius-10" data-type="narrow">
                        <?php if(is_user_logged_in()) :
                            echo  '<h2 class="form__title font-weight-700">You are already logged in.</h2>';
                        else: ?>
                            <h2 class="form__title font-weight-700">
                                Forgot Password
                            </h2>
                            <p class="form__desc">
                                Nunc tincidunt ultricies velit amet. Malesuada ut amet leo massa at pretium bibendum. Mauris
                                urna volutpat quisque. sed interdum eu nunc. Ut sed egestas
                            </p>
                            <form id="forgot-password-form" aria-label="forgot-password form" class="forgot-password__form form__main">
                                <div class="form__grid">
                                    <div class="form-group">
                                        <label for="username_email" class="visually-hidden">Username or Email</label>
                                        <input type="text" id="bte_username_email" name="username_email" required
                                            placeholder="Username or Email">
                                    </div>
                                </div>

                                <div class="form__footer flex">
                                    <button type="submit" class="btn">Reset Password</button>
                                </div>
                            </form>
                            <div id="forgot-password-message" style="margin-top:10px;"></div>
                        <?php endif; ?>
                    </div>                    
				</div>
			</section>
		</main>
	<?php
	return ob_get_clean();
}
add_shortcode('bte_forgot_password_form', 'bte_forgot_password_form_shortcode');


function bte_signup_form_shortcode() {	
	ob_start(); ?>
	<main>
        <section aria-labelledby="signup-section" class="signup overlap">
            <div class="signup__bg-img height-full">
                <img class="cover-fit height-full width-full" src="<?php echo ( ! wp_is_mobile() ) ? get_template_directory_uri() . '/assets/images/login.png' : get_template_directory_uri() . '/assets/images/login-mobile.png'; ?>" alt="country side">
            </div>
            <div class="signup__form form">
                <div class="form__wrapper container <?php echo ( wp_is_mobile() ) ? 'bg-color-off-white' : 'bg-color-white'; ?> border-radius-10" data-type="narrow">
                    <?php if(is_user_logged_in()) :
                        echo  '<h2 class="form__title font-weight-700">You are already logged in.</h2>';
                    else: ?>
                        <h2 class="form__title font-weight-700">
                            Sign Up for an wholesale account
                        </h2>
                        <p class="form__desc">
                        Sign up to access fresh, organic produce at wholesale prices. Manage your orders, view exclusive offers, and enjoy seamless service tailored to your business needs.
                        </p>
                        <?php if( ! wp_is_mobile() ) : ?>
                            <form id="signup-form" aria-label="signup form" class="signup__form form__main">
                                <div class="form__grid">
                                    <div class="even-columns">  
                                        <div class="form-group">
                                            <label for="first_name" class="visually-hidden">First Name</label>
                                            <input type="text" id="first_name" name="first_name" required
                                                placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name" class="visually-hidden">Last Name</label>
                                            <input type="text" id="last_name" name="last_name" required placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="even-columns">
                                        <div class="form-group">
                                            <label for="birthday" class="visually-hidden">Birthday</label>
                                            <input type="text" id="birthday" name="birthday" required autocomplete="birthday"
                                                placeholder="MM/DD/YYYY Birthday">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="visually-hidden">Email Address</label>
                                        <input type="email" id="email" name="email" required placeholder="Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="bussiness_name" class="visually-hidden">Business Name</label>
                                        <input type="text" id="bussiness_name" name="bussiness_name" required
                                            placeholder="Business Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="bussiness_email" class="visually-hidden">Business Email</label>
                                        <input type="email" id="bussiness_email" name="bussiness_email" required
                                            placeholder="Business Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="bussiness_type" class="visually-hidden">Business Type</label>
                                        <select name="bussiness_type" id="bussiness_type">
                                            <option value="">Business Type</option>
                                            <option value="sole_trader">Sole Trader</option>
                                            <option value="company">Company</option>
                                        </select>
                                        <div class="wholesale-checkbox flex">
                                            <input type="checkbox" name="wholesale" id="wholesale">
                                            <label for="wholesale">Create Wholesale Account</label>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group">
                                        <label for="username" class="visually-hidden">Username</label>
                                        <input type="text" id="username" name="username" required placeholder="Username">
                                    </div>
                                    <div class="even-columns">
                                        <div class="form-group">
                                            <label for="password" class="visually-hidden">Password</label>
                                            <input type="password" id="password" name="password" required
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password" class="visually-hidden">Re-type Password</label>
                                            <input type="password" id="confirm_password" name="confirm_password" required
                                                placeholder="Re-type Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__footer flex">
                                    <button type="submit" class="btn">Finish</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form id="signup-mobile-form" aria-label="signup form" class="signup__form form__main">
                                <div class="form__grid">
                                    <div class="form__step active">
                                        <div class="even-columns">  
                                            <div class="form-group">
                                                <label for="first_name" class="visually-hidden">First Name</label>
                                                <input type="text" id="first_name" name="first_name" required
                                                    placeholder="First Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name" class="visually-hidden">Last Name</label>
                                                <input type="text" id="last_name" name="last_name" required placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="even-columns">
                                            <div class="form-group">
                                                <label for="birthday" class="visually-hidden">Birthday</label>
                                                <input type="date" id="birthday" name="birthday" required autocomplete="birthday"
                                                    placeholder="Birthday">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="visually-hidden">Email Address</label>
                                            <input type="email" id="email" name="email" required placeholder="Email Address">
                                        </div>
                                        <button type="button" class="next-btn btn">Next</button>
                                    </div>
                                    <div class="form__step">
                                        <div class="form-group">
                                            <label for="bussiness_name" class="visually-hidden">Business Name</label>
                                            <input type="text" id="bussiness_name" name="bussiness_name" required
                                                placeholder="Business Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="bussiness_email" class="visually-hidden">Business Email</label>
                                            <input type="email" id="bussiness_email" name="bussiness_email" required
                                                placeholder="Business Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="bussiness_type" class="visually-hidden">Business Type</label>
                                            <select name="bussiness_type" id="bussiness_type">
                                                <option value="">Business Type</option>
                                                <option value="sole_trader">Sole Trader</option>
                                                <option value="company">Company</option>
                                            </select>
                                            <div class="wholesale-checkbox flex">
                                                <input type="checkbox" name="wholesale" id="wholesale">
                                                <label for="wholesale">Create Wholesale Account</label>
                                            </div>
                                        </div>
                                        <div class="mobile-btn flex">
                                            <button type="button" class="prev-btn btn btn--white">Previous</button>
                                            <button type="button" class="next-btn btn">Next</button>
                                        </div>
                                    </div>
                                    <div class="form__step">
                                        <div class="form-group">
                                            <label for="username" class="visually-hidden">Username</label>
                                            <input type="text" id="username" name="username" required placeholder="Username">
                                        </div>
                                        <div class="even-columns">
                                            <div class="form-group">
                                                <label for="password" class="visually-hidden">Password</label>
                                                <input type="password" id="password" name="password" required
                                                    placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_password" class="visually-hidden">Re-type Password</label>
                                                <input type="password" id="confirm_password" name="confirm_password" required
                                                    placeholder="Re-type Password">
                                            </div>
                                        </div>
                                        <div class="mobile-btn flex">
                                            <button type="button" class="prev-btn btn btn--white">Previous</button>
                                            <button type="submit" class="btn">Finish</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        <?php endif; ?>
                        <div id="signup-message" style="margin-top:10px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section aria-labelledby="thank-you-section" class="thank-you overlap" style="display:none;">
            <div class="thank-you__bg-img height-full">
                <img class="cover-fit height-full width-full" src="<?php echo ( ! wp_is_mobile() ) ? get_template_directory_uri() . '/assets/images/login.png' : get_template_directory_uri() . '/assets/images/login-mobile.png'; ?>" alt="country side">
            </div>
            <div class="thank-you__form form">
                <div class="form__wrapper container bg-color-white border-radius-10" data-type="narrow">
                    <h2 class="form__title font-weight-700">
                        Thank you!
                    </h2>
                    <p class="form__desc">
                        Nunc tincidunt ultricies velit amet. Malesuada ut amet leo massa at pretium bibendum. Mauris
                        urna volutpat quisque. sed interdum eu nunc. Ut sed egestas
                    </p>
                    <a href="<?php echo esc_url( home_url() ); ?>" class="btn">Back to Login</a>
                </div>
            </div>
        </section>
    </main>
	<?php
	return ob_get_clean();
}
add_shortcode('bte_signup_form', 'bte_signup_form_shortcode');

/**
 * Handle WooCommerce user registration.
 */
function bte_woocommerce_register_user() {
    
    check_ajax_referer('ajax-nonce', 'register_nonce');

    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = sanitize_text_field( $_POST['first_name'] );
    $last_name = sanitize_text_field( $_POST['last_name'] );
    $birthday = sanitize_text_field( $_POST['birthday'] );
    $business_name = sanitize_text_field( $_POST['bussiness_name'] );
    $business_email = sanitize_email( $_POST['bussiness_email'] );
    $business_type = sanitize_text_field( $_POST['bussiness_type'] );
    $wholesale_account = $_POST['wholesale_account'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name)|| empty($last_name) || empty($birthday) || empty($business_name || empty($business_email) || empty($business_type) ) ) {
        wp_send_json_error(['message' => 'All fields are required.']);
    }

    if ($password !== $confirm_password) {
        wp_send_json_error(['message' => 'Passwords do not match.']);
    }

    if (username_exists($username) || email_exists($email)) {
        wp_send_json_error(['message' => 'Username or email already exists.']);
    }

    // Create the user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(['message' => $user_id->get_error_message()]);
    }

    // Assign WooCommerce customer role
    $user = new WP_User($user_id);
    $user->set_role($wholesale_account ? 'wholesale_customer' : 'customer');

    // Save additional user meta
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'birthday', $birthday);
    update_user_meta($user_id, 'business_type', $business_type);
    update_user_meta($user_id, 'business_email', $business_email);
    update_user_meta($user_id, 'business_name', $business_name);

    wp_send_json_success(['message' => 'Registration successful.']);
}

add_action('wp_ajax_bte_register_user', 'bte_woocommerce_register_user');
add_action('wp_ajax_nopriv_bte_register_user', 'bte_woocommerce_register_user');


function bte_autocomplete_search(){
    $product_type = array('product');
    $args = array(
        'post_type' => $product_type,
        'posts_per_page' => intval($_POST['number']),
        's' => sanitize_text_field($_POST['data']),
        'tax_query'   => [
            [
                'taxonomy'  => 'product_visibility',
                'terms'     => array( 'exclude-from-catalog' ),
                'field'     => 'name',
                'operator'  => 'NOT IN',
            ]
        ]
    );
    ob_start();
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :

        while ($the_query->have_posts()) : $the_query->the_post();
            echo '<li><a href="'. esc_url( get_the_permalink() ) .'">' . esc_html( get_the_title() ). '</a></li>';
        endwhile;
        wp_reset_postdata();

    endif;

    echo json_encode(array(
        'total' => $the_query->found_posts,
        'result' => ob_get_clean(),
        'url' => site_url() . '/?s=' . $_POST['data'] . '&post_type=product'
    ));


    die();
}
add_action('wp_ajax_bte_autocomplete_search', 'bte_autocomplete_search');
add_action('wp_ajax_nopriv_bte_autocomplete_search', 'bte_autocomplete_search');