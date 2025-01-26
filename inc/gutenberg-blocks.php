<?php
function bt_eden_register_custom_block_categories( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'back-to-eden-blocks',
				'title' => 'BackToEden: Custom Blocks',
			),
		)
	);
}
add_action( 'block_categories_all', 'bt_eden_register_custom_block_categories', 10, 2 );

// Register ACF Blocks
add_action( 'acf/init', 'bt_eden_custom_acf_init' );
function bt_eden_custom_acf_init() {
	// check function exists.
	if ( function_exists( 'acf_register_block_type' ) ) {

		acf_register_block_type(
			array(
				'name'            => 'bte-home-slider',
				'title'           => 'Home Slider',
				'description'     => 'BackToEden: Home Slider',
				'render_template' => 'blocks/home-slider.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
        acf_register_block_type(
			array(
				'name'            => 'bte-home-service',
				'title'           => 'Home Service',
				'description'     => 'BackToEden: Home Service',
				'render_template' => 'blocks/home-service.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'bte-home-category',
				'title'           => 'Home Categories',
				'description'     => 'BackToEden: Home Categories',
				'render_template' => 'blocks/home-category.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'bte-home-explore',
				'title'           => 'Home Explore',
				'description'     => 'BackToEden: Home Explore',
				'render_template' => 'blocks/home-explore.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'bte-home-gallery',
				'title'           => 'Home Gallery',
				'description'     => 'BackToEden: Home gallery',
				'render_template' => 'blocks/home-gallery.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

		acf_register_block_type(
			array(
				'name'            => 'bte-home-cta',
				'title'           => 'Home CTA',
				'description'     => 'BackToEden: Home CTA',
				'render_template' => 'blocks/home-cta.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

		acf_register_block_type(
			array(
				'name'            => 'bte-about-slider',
				'title'           => 'About Slider',
				'description'     => 'BackToEden: About Slider',
				'render_template' => 'blocks/about-slider.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-about-service',
				'title'           => 'About Service',
				'description'     => 'BackToEden: About Service',
				'render_template' => 'blocks/about-service.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-contact-main',
				'title'           => 'Contact Main',
				'description'     => 'BackToEden: Contact Main',
				'render_template' => 'blocks/contact-main.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-shop-main',
				'title'           => 'Shop Main',
				'description'     => 'BackToEden: Shop Main',
				'render_template' => 'blocks/shop-main.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-shop-category',
				'title'           => 'Shop Category',
				'description'     => 'BackToEden: Shop Category',
				'render_template' => 'blocks/shop-category.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-shop-filters',
				'title'           => 'Shop Filters',
				'description'     => 'BackToEden: Shop Filters',
				'render_template' => 'blocks/shop-filters.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

		acf_register_block_type(
			array(
				'name'            => 'bte-product-frequently-bought',
				'title'           => 'Product Frequently Bought',
				'description'     => 'BackToEden: Product Frequently Bought',
				'render_template' => 'blocks/product-frequently-bought.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);
		
		acf_register_block_type(
			array(
				'name'            => 'bte-product-service',
				'title'           => 'Product Service',
				'description'     => 'BackToEden: Product Service',
				'render_template' => 'blocks/product-service.php',
				'category'        => 'back-to-eden-blocks',
				'icon'            => 'back-to-eden',
			)
		);

	}
}
