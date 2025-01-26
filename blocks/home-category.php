<?php 
$bte_title          = get_field('hc_title');
$bte_button_label   = get_field('hc_button_label');
$bte_button_link    = get_field('hc_button_link');
$bte_category       = get_field('home_category');
?>
<div class="bte-category product-slider bg-color-off-white">
    <div class="product-title">
        <h2 class="title">                    
            <?php echo wp_kses_post( $bte_title ) ;?>
        </h2>
        <?php if( $bte_button_label && $bte_button_link  ) : ?>
            <a href="<?php echo esc_url( $bte_button_link );?>" class="btn"><?php echo esc_html( $bte_button_label ) ;?></a>
        <?php endif; ?>
    </div>
    
    <div class="swiper product__list">
        <div class="swiper-wrapper">
            <?php foreach( $bte_category as $home_category ) : ?>
                <div class="swiper-slide">
                    <a href="<?php echo esc_url( $home_category['link'] ) ;?>" class="overlap width-full">
                        <?php echo wp_get_attachment_image( $home_category['image'], 'full', '', array( 'class' => '', 'alt' => 'hs-image', 'loading' => 'lazy' ) ); ?>
                        <h3 class="title">                    
                            <?php echo esc_html( $home_category['label'] ) ;?>
                        </h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>    
</div>