<?php 
$bte_title          = get_field('hg_title');
$bte_gallery        = get_field('home_gallery');
?>
<div class="bte-gallery image-section">
    <div class="container" data-type="narrow">
        <h2 class="title">                    
            <?php echo wp_kses_post( $bte_title ) ;?>
        </h2>
    </div>
    <div class="gallery-main image-slider-wrapper">
        <div class="swiper image-slider">
            <div class="swiper-wrapper">
                <?php foreach( $bte_gallery as $home_gallery ) : ?>
                    <div class="swiper-slide">
                        <div class="width-full">
                            <?php echo wp_get_attachment_image( $home_gallery['image'], 'full', '', array( 'class' => '', 'alt' => 'hg-image', 'loading' => 'lazy' ) ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>