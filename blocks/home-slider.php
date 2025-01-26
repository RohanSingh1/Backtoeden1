<?php 
$bte_banner = get_field('home_slider');
?>
<div class="bte-banner banner overlap">
    <div class="bte-banner-slider swiper banner__slider">
        <div class="swiper-wrapper">
            <?php foreach( $bte_banner as $home_slider ) : ?>
                <div class="swiper-slide">
                    <div class="overlap">
                        <div class="banner__image">
                            <?php echo wp_get_attachment_image( $home_slider['background_image'], 'full', '', array( 'class' => '', 'alt' => 'hsl-image', 'loading' => 'lazy' ) ); ?>
                        </div>
                        <div class="content-wrapper">
                            <div class="banner__content">
                                <h2 class="banner__title">                    
                                    <?php echo wp_kses_post( $home_slider['title'] ) ;?>
                                </h2>
                                <div class="button-wrapper">
                                    <?php if( $home_slider['button_label'] && $home_slider['button_link'] ) : ?>
                                        <a href="<?php echo esc_url( $home_slider['button_link'] );?>" class="btn btn--outline"><?php echo esc_html( $home_slider['button_label'] ) ;?></a>
                                    <?php endif; ?>
                                    <?php if( $home_slider['button_label_two'] && $home_slider['button_link_two'] ) : ?>
                                        <a href="<?php echo esc_url( $home_slider['button_link_two'] );?>" class="btn btn--white"><?php echo esc_html( $home_slider['button_label_two'] ) ;?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-button-wrap">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>