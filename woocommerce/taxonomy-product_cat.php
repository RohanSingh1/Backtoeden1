<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Archive Page
*/

get_header();

$the_term_id = get_queried_object_id();
$the_term = get_term( $the_term_id );

$post = get_post( 8 ); // specific post
if ( !empty($post->post_content) ) {

	$blocks = parse_blocks( $post->post_content );

	foreach ( $blocks as $index => $block ) {
		if ( $block['blockName'] == 'acf/bte-shop-main' ) {
			echo render_block( $block );
		}
		if ( $block['blockName'] == 'acf/bte-shop-category' ) {
			echo render_block( $block );
		}
	}
	?>
	<section class="shop-cat-page">
		<!-- Products Grid -->
		<div class="shop-products shop-cat-section">
			<div class="shop-header" data-cat_id="<?php echo absint( $the_term_id ); ?>">
				<div class="left-shop-header">
					<h4><?php echo $the_term->name; ?></h4>
					<span class="shop-count">0 results</span>
				</div>            
				<div class="filter-sort">
					<select id="sortby" class="filter-select">
						<option value="">Sort By</option>                    
						<option value="menu_order">Default</option>                    
						<option value="popularity">Popularity</option>                    
						<option value="rating">Average Rating</option>                    
						<option value="latest">Latest</option>
						<option value="price-low-high">Price: Low to High</option>
						<option value="price-high-low">Price: High to Low</option>
					</select>
				</div>
			</div>
			<div id="product-grid" class="product-grid column-5"></div>
			<div id="pagination-container" class="paginate-bte"></div>
		</div>
	</section>

	<?php 
	foreach ( $blocks as $index => $block ) {
		if ( $block['blockName'] == 'acf/bte-home-explore' ) {
			echo render_block( $block );
		}
		if ( $block['blockName'] == 'acf/bte-home-gallery' ) {
			echo render_block( $block );
		}
		if ( $block['blockName'] == 'acf/bte-home-cta' ) {
			echo render_block( $block );
		}
	}
}
get_footer(); 