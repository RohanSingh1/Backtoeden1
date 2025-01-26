<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>
<h2 class="cart__title">Cart</h2>
<p class="cart__desc">
	Nunc tincidunt ultricies velit amet. Malesuada ut amet leo massa at pretium bibendum. Mauris urna
	volutpat quisque. sed interdum eu nunc. Ut sed egestas
</p>

<div class="cart__wrapper">
	<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
		<?php do_action('woocommerce_before_cart_table'); ?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<?php /*
			<thead>
				<tr>
					<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
					<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
					<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			*/ ?>
			<tbody>
				<?php do_action('woocommerce_before_cart_contents'); ?>

				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
					/**
					 * Filter the product name.
					 *
					 * @since 2.1.0
					 * @param string $product_name Name of the product in the cart.
					 * @param array $cart_item The product in the cart.
					 * @param string $cart_item_key Key for the product in the cart.
					 */
					$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
				?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">


							<td class="product-thumbnail">
								<?php
								$product_image_url = get_field('_featured_image_url',  $_product->get_id() );
								$thumbnail = ( $product_image_url ) ? '<img src="' . esc_url( $product_image_url ) . '" alt="'. $_product->get_name() .'" class="wp-post-image">' : apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

								if (! $product_permalink) {
									echo $thumbnail; // PHPCS: XSS ok.
								} else {
									printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
								}
								?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
								<?php
								if (! $product_permalink) {
									echo wp_kses_post($product_name . '&nbsp;');
								} else {
									/**
									 * This filter is documented above.
									 *
									 * @since 2.1.0
									 */
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
								}

								do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

								// Meta data.
								echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

								// Backorder notification.
								if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
								}
								?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
								<?php
								if ($_product->is_sold_individually()) {
									$min_quantity = 1;
									$max_quantity = 1;
								} else {
									$min_quantity = 0;
									$max_quantity = $_product->get_max_purchase_quantity();
								}

								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $max_quantity,
										'min_value'    => $min_quantity,
										'product_name' => $product_name,
									),
									$_product,
									false
								);

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
								?>
							</td>
							<td class="product-subtotal product-price" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</td>
							<td class="product-remove">
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
												<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13.1562 2.8125H10.8125V2.34375C10.8125 1.97079 10.6643 1.6131 10.4006 1.34938C10.1369 1.08566 9.77921 0.9375 9.40625 0.9375H6.59375C6.22079 0.9375 5.8631 1.08566 5.59938 1.34938C5.33566 1.6131 5.1875 1.97079 5.1875 2.34375V2.8125H2.84375C2.71943 2.8125 2.6002 2.86189 2.51229 2.94979C2.42439 3.0377 2.375 3.15693 2.375 3.28125C2.375 3.40557 2.42439 3.5248 2.51229 3.61271C2.6002 3.70061 2.71943 3.75 2.84375 3.75H3.3125V12.1875C3.3125 12.4361 3.41127 12.6746 3.58709 12.8504C3.7629 13.0262 4.00136 13.125 4.25 13.125H11.75C11.9986 13.125 12.2371 13.0262 12.4129 12.8504C12.5887 12.6746 12.6875 12.4361 12.6875 12.1875V3.75H13.1562C13.2806 3.75 13.3998 3.70061 13.4877 3.61271C13.5756 3.5248 13.625 3.40557 13.625 3.28125C13.625 3.15693 13.5756 3.0377 13.4877 2.94979C13.3998 2.86189 13.2806 2.8125 13.1562 2.8125ZM6.125 2.34375C6.125 2.21943 6.17439 2.1002 6.26229 2.01229C6.3502 1.92439 6.46943 1.875 6.59375 1.875H9.40625C9.53057 1.875 9.6498 1.92439 9.73771 2.01229C9.82561 2.1002 9.875 2.21943 9.875 2.34375V2.8125H6.125V2.34375ZM11.75 12.1875H4.25V3.75H11.75V12.1875ZM7.0625 6.09375V9.84375C7.0625 9.96807 7.01311 10.0873 6.92521 10.1752C6.8373 10.2631 6.71807 10.3125 6.59375 10.3125C6.46943 10.3125 6.3502 10.2631 6.26229 10.1752C6.17439 10.0873 6.125 9.96807 6.125 9.84375V6.09375C6.125 5.96943 6.17439 5.8502 6.26229 5.76229C6.3502 5.67439 6.46943 5.625 6.59375 5.625C6.71807 5.625 6.8373 5.67439 6.92521 5.76229C7.01311 5.8502 7.0625 5.96943 7.0625 6.09375ZM9.875 6.09375V9.84375C9.875 9.96807 9.82561 10.0873 9.73771 10.1752C9.6498 10.2631 9.53057 10.3125 9.40625 10.3125C9.28193 10.3125 9.1627 10.2631 9.07479 10.1752C8.98689 10.0873 8.9375 9.96807 8.9375 9.84375V6.09375C8.9375 5.96943 8.98689 5.8502 9.07479 5.76229C9.1627 5.67439 9.28193 5.625 9.40625 5.625C9.53057 5.625 9.6498 5.67439 9.73771 5.76229C9.82561 5.8502 9.875 5.96943 9.875 6.09375Z" fill="currentColor"/>
												</svg>
											</a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										/* translators: %s is the product name */
										esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
										esc_attr($product_id),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								);
								?>
							</td>
						</tr>
				<?php
					}
				}
				?>

				<?php do_action('woocommerce_cart_contents'); ?>

				<tr>
					<td colspan="6" class="actions">

						<?php if (wc_coupons_enabled()) { ?>
							<div class="coupon">
								<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit" class="button btn btn--green<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
								<?php do_action('woocommerce_cart_coupon'); ?>
							</div>
						<?php } ?>

						<button type="submit" class="button btn btn--green" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

						<?php do_action('woocommerce_cart_actions'); ?>

						<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
					</td>
				</tr>

				<?php do_action('woocommerce_after_cart_contents'); ?>
			</tbody>
		</table>
		<?php do_action('woocommerce_after_cart_table'); ?>
	</form>

	<?php do_action('woocommerce_before_cart_collaterals'); ?>

	<div class="cart-collaterals">
		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action('woocommerce_cart_collaterals');
		?>
	</div>

	<?php do_action('woocommerce_after_cart'); ?>
</div>