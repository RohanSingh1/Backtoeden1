<?php

/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

?>
<div class="woocommerce-product-details">
	<div class="woocommerce-product-detail">
		<div class="woocommerce-product-detail__delivery">
			<span class="woocommerce-product-detail__title">
				Delivery By:
			</span>
			<div class="woocommerce-product-detail__flex">
				<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<mask id="mask0_140_16913" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2" y="6" width="26" height="19">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M2.91602 6.25H27.0824V24.9998H2.91602V6.25Z" fill="white" />
					</mask>
					<g mask="url(#mask0_140_16913)">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M26.274 20.6189L25.0496 22.025H23.4839C23.4879 21.9628 23.4939 21.9004 23.4939 21.8372C23.4939 20.1167 22.0459 18.7174 20.2657 18.7174C19.7571 18.7174 19.2768 18.8352 18.8489 19.0385V16.6845L26.274 16.6368V20.6189ZM20.2689 24.1783C18.9337 24.1783 17.8472 23.1283 17.8472 21.8369C17.8472 20.5455 18.9337 19.4956 20.2689 19.4956C21.605 19.4956 22.6916 20.5455 22.6916 21.8369C22.6916 23.1283 21.605 24.1783 20.2689 24.1783ZM10.7905 19.4913V19.5389C10.2166 19.031 9.45528 18.7186 8.61751 18.7186C7.80692 18.7186 7.06581 19.0116 6.49889 19.4913H3.72377V7.02764H18.3587L21.7269 10.4763H18.4513C18.2288 10.4763 18.0486 10.6505 18.0486 10.8656V19.4232C18.0486 19.4465 18.0516 19.4689 18.0555 19.4913H10.7905ZM17.0412 21.8392C17.0412 21.883 17.0462 21.9268 17.0472 21.9705H11.8363C11.8383 21.9268 11.8434 21.883 11.8434 21.8392C11.8434 21.0976 11.5725 20.4175 11.1244 19.8812H17.7601C17.3111 20.4175 17.0412 21.0976 17.0412 21.8392ZM8.61489 24.1783C7.27967 24.1783 6.19319 23.1283 6.19319 21.8369C6.19319 20.5455 7.27967 19.4956 8.61489 19.4956C9.95113 19.4956 11.0376 20.5455 11.0376 21.8369C11.0376 23.1283 9.95113 24.1783 8.61489 24.1783ZM5.39025 21.8396C5.39025 21.9028 5.3963 21.9651 5.40032 22.0274H3.72377V19.8816H6.1082C5.66011 20.4179 5.39025 21.098 5.39025 21.8396ZM25.8986 15.8634L18.854 15.9081V11.2547H22.4559L25.8986 15.8634ZM27.0061 16.0186L22.9854 10.6373C22.9753 10.6237 22.9622 10.612 22.9502 10.6004L22.9522 10.5984L18.8237 6.37213C18.7472 6.29428 18.6414 6.24951 18.5307 6.24951H3.31879C3.09625 6.24951 2.91602 6.42467 2.91602 6.63876V22.4159C2.91602 22.6309 3.09625 22.8051 3.31879 22.8051H5.54816C5.81399 23.5895 6.39198 24.2366 7.14114 24.6103H4.8131V24.9995H8.66969V24.9557C10.0543 24.9333 11.2273 24.0653 11.6613 22.8626H17.2237C17.4976 23.6206 18.0644 24.2463 18.7945 24.6103H16.4121V24.9995H20.2969V24.9567C21.7146 24.945 22.9169 24.0459 23.3368 22.8051H25.2399C25.3587 22.8051 25.4716 22.7546 25.548 22.6669L26.988 21.0127C27.0494 20.9436 27.0826 20.8541 27.0826 20.7626V16.2473C27.0826 16.1655 27.0554 16.0858 27.0061 16.0186Z" fill="#111111" />
					</g>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M20.2666 21.0249C19.8014 21.0249 19.4248 21.3898 19.4248 21.8384C19.4248 22.288 19.8014 22.6529 20.2666 22.6529C20.7318 22.6529 21.1084 22.288 21.1084 21.8384C21.1084 21.3898 20.7318 21.0249 20.2666 21.0249Z" fill="#111111" />
					<path fill-rule="evenodd" clip-rule="evenodd" d="M8.61524 21.0249C8.15004 21.0249 7.77344 21.3898 7.77344 21.8384C7.77344 22.288 8.15004 22.6529 8.61524 22.6529C9.08045 22.6529 9.45705 22.288 9.45705 21.8384C9.45705 21.3898 9.08045 21.0249 8.61524 21.0249Z" fill="#111111" />
					<mask id="mask1_140_16913" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2" y="6" width="26" height="19">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M2.91602 25H27.0827V6.25H2.91602V25Z" fill="white" />
					</mask>
					<g mask="url(#mask1_140_16913)">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M19.7822 17.8355H20.9231V17.4463H19.7822V17.8355Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M3.7793 9.61439H17.4979V9.2251H3.7793V9.61439Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13.5166 16.5012H17.3741V15.7227H13.5166V16.5012Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M11.3076 17.9997H12.7747V17.2212H11.3076V17.9997Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M5.85156 21.8396C5.85156 20.3644 7.08909 19.1694 8.61462 19.1694C10.1402 19.1694 11.3776 20.3644 11.3776 21.8396C11.3776 23.3139 10.1402 24.5099 8.61462 24.5099C7.08909 24.5099 5.85156 23.3139 5.85156 21.8396Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M7.77246 21.839C7.77246 21.3894 8.15007 21.0254 8.61427 21.0254C9.07947 21.0254 9.45607 21.3894 9.45607 21.839C9.45607 22.2886 9.07947 22.6525 8.61427 22.6525C8.15007 22.6525 7.77246 22.2886 7.77246 21.839Z" fill="white" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M17.5059 21.8396C17.5059 20.3644 18.7434 19.1694 20.2689 19.1694C21.7944 19.1694 23.032 20.3644 23.032 21.8396C23.032 23.3139 21.7944 24.5099 20.2689 24.5099C18.7434 24.5099 17.5059 23.3139 17.5059 21.8396Z" fill="#111111" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M19.5078 21.839C19.5078 21.3894 19.8854 21.0254 20.3496 21.0254C20.8148 21.0254 21.1924 21.3894 21.1924 21.839C21.1924 22.2886 20.8148 22.6525 20.3496 22.6525C19.8854 22.6525 19.5078 22.2886 19.5078 21.839Z" fill="white" />
					</g>
				</svg>
				<span class="woocommerce-product-detail__delivery-time">Today 2 PM - 4 PM</span>
			</div>
		</div>
	</div>
	<?php /*
	<div class="woocommerce-product-detail">
		<div class="woocommerce-product-detail__short-description">
			<span class="woocommerce-product-detail__title">
				Key Information:
			</span>
			<?php echo $short_description; // WPCS: XSS ok. 
			?>
		</div>
	</div>
	*/ ?>
</div>