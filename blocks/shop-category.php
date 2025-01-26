<?php 
$enable_search      = get_field('enable_search');
$shop_category      = get_field('shop_category');
?>
<section class="grid">
    <?php if( $enable_search ) : ?>
        <div class="search bg-color-off-white">
            <div class="container" data-type="narrow">
                <form role="search" action="<?php echo esc_url( home_url() ); ?>" class="shop-search" autocomplete="off">
                    <label for="search-products" class="visually-hidden">Search Products</label>
                    <input id="search-products" type="search" name="s" placeholder='Search for ...'>
                    <button type="submit">
                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.2788 13.7825L11.005 10.5086C11.7932 9.45937 12.2187 8.18217 12.2172 6.86983C12.2172 3.51772 9.49 0.790527 6.13789 0.790527C2.78579 0.790527 0.0585938 3.51772 0.0585938 6.86983C0.0585938 10.2219 2.78579 12.9491 6.13789 12.9491C7.45024 12.9506 8.72744 12.5251 9.77671 11.7369L13.0505 15.0107C13.2162 15.1588 13.4324 15.2379 13.6546 15.2317C13.8768 15.2255 14.0882 15.1344 14.2453 14.9773C14.4025 14.8201 14.4936 14.6087 14.4998 14.3865C14.506 14.1643 14.4269 13.9482 14.2788 13.7825ZM1.79554 6.86983C1.79554 6.01099 2.05021 5.17144 2.52736 4.45734C3.0045 3.74325 3.68268 3.18668 4.47615 2.85801C5.26961 2.52935 6.14271 2.44336 6.98505 2.61091C7.82738 2.77846 8.60112 3.19203 9.2084 3.79932C9.81569 4.40661 10.2293 5.18034 10.3968 6.02268C10.5644 6.86501 10.4784 7.73811 10.1497 8.53158C9.82105 9.32504 9.26448 10.0032 8.55038 10.4804C7.83628 10.9575 6.99673 11.2122 6.13789 11.2122C4.98665 11.2108 3.88296 10.7529 3.06891 9.93881C2.25486 9.12476 1.79692 8.02107 1.79554 6.86983Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </form>
                <div class="search-drop">
                    <div class="search-suggest-wrap-main">
                        <div class="search-product-wrapper visually-hidden">
                            <div class="product-row">

                            </div>
                            <!-- <div class="btn-wrapper visually-hidden">
                                <a class="btn btn-primary btn-results" href="#">Show all results</a>
                            </div> -->
                            <div class="noresult_info visually-hidden">No results found</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="shop__product-slider-wrapper">
        <div class="container grid" data-type="narrow">
            <div class="swiper shop__product-slider">            
                <div class="swiper-wrapper">
                    <?php foreach( $shop_category as $shop_cat ) : ?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url( $shop_cat['link'] ) ;?>" class="overlap width-full">
                                <?php echo wp_get_attachment_image( $shop_cat['image'], 'full', '', array( 'class' => '', 'alt' => 'hs-image', 'loading' => 'lazy' ) ); ?>
                                <h3 class="title">                    
                                    <?php echo esc_html( $shop_cat['label'] ) ;?>
                                </h3>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div> 
            </div> 
        </div> 
    </div> 
</section>