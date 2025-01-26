<?php 
$select_products  = get_field('select_products');
$pfb_title  = get_field('pfb_title');
?>
<div class="container">
	<div class="product-section">
		<h2 class="title"><?php echo esc_html( $pfb_title ); ?></h2>
		<div class="product-grid column-7">
			<?php foreach( $select_products as $products ) : 
				$product = wc_get_product( $products['select_products_fb'] ); 
				$product_image_url = get_field('_featured_image_url',  $product->get_id() ); ?>
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
			<?php endforeach; ?>
		</div>
	</div>
</div>