<?php 
$bte_title       = get_field('sm_title');
$bte_subtitle    = get_field('sm_subtitle');
$bte_description = get_field('sm_description');
$bte_image       = get_field('sm_main_image');
?>
<section class="grid bg-color-white">
    <div class="shop-banner">
        <div class="shop-banner-text">
            <h2 class="title">                    
                <?php echo wp_kses_post( $bte_title ) ;?>
            </h2>
            <h3 class="subtitle">                    
                <?php echo wp_kses_post( $bte_subtitle ) ;?>
            </h3>
            <p class="desc">                    
                <?php echo wp_kses_post( $bte_description ) ;?>
            </p>
        </div>
    
        <div class="shop-banner__img">
            <?php echo wp_get_attachment_image( $bte_image, 'full', '', array( 'class' => '', 'alt' => 'shop-main-image', 'loading' => 'lazy' ) ); ?>
        </div>    
    </div>
</section>