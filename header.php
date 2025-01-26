<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta HTTP-EQUIV="Content-type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=Edge,chrome=1"/>
        <title><?php wp_title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <script src="<?php bloginfo('template_directory'); ?>/js/vendor/modernizr-2.8.0.min.js"></script>
		<?php wp_head(); ?>
	</head>

    	<body <?php body_class(); ?>>
            
            <header id="site-header" class="header">
                <div class="container header__wrapper flex">
                    <div class="header__left flex">
                        <div class="header__titles flex">
                            <?php if( wp_is_mobile() ) : ?>
                                <div class="hamburger-menu" aria-label="Toggle Menu">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            <?php endif; ?>
                            <div class="site-logo">
                                <a href="/">
                                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/logo.png" alt="Logo Name">
                                </a>
                                <span class="screen-reader-text">Back To Eden.</span>
                            </div>
                            <div class="site-title">Back To Eden.</div>
                        </div>
                        <?php if( !wp_is_mobile() ) : ?>
                            <nav class="header__nav">
                                <?php wp_nav_menu(array ('theme_location' => 'header', 'container' => 'false', 'menu_class' => 'primary-menu flex' )); ?>
                            </nav>
                        <?php else: ?>
                            <nav class="mobile__nav">
                                <?php wp_nav_menu(array ('theme_location' => 'header', 'container' => 'false', 'menu_class' => 'primary-menu' )); ?>
                                <?php if( is_user_logged_in() ) : ?>
                                    <div class="sign-in-btn">
                                        <a href="<?php echo home_url('my-account'); ?>" class="btn">Account</a>
                                    </div>
                                <?php else: ?>
                                    <div class="sign-in-btn">
                                        <a href="/sign-in/" class="btn">
                                            Sign In
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </nav>
                        <?php endif; ?>
                    </div>
                    <div class="header__right flex">
                        <?php if( is_user_logged_in() ) : ?>
                            <div class="logout">
                                <a href="<?php echo wp_logout_url( home_url('my-account') ); ?>">Logout</a>
                            </div>
                        <?php endif; ?>
                        <div class="cart">
                            <a href="/cart/" class="cart-link">Cart <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></a>
                        </div>
                        <?php if( !wp_is_mobile() ) : ?>
                            <?php if( is_user_logged_in() ) : ?>
                                <div class="sign-in-btn">
                                    <a href="<?php echo home_url('my-account'); ?>" class="btn">Account</a>
                                </div>
                            <?php else: ?>
                                <div class="sign-in-btn">
                                    <a href="/sign-in/" class="btn">
                                        Sign In
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </header>