<?php
$bte_banner = get_field('about_slider');
?>
<div class="bte-banner banner overlap">
    <div class="bte-banner-slider swiper banner__slider">
        <div class="swiper-wrapper">
            <?php foreach ($bte_banner as $about_slider) : ?>
                <div class="swiper-slide">
                    <div class="overlap">
                        <div class="banner__image">
                            <?php echo wp_get_attachment_image($about_slider['background_image'], 'full', '', array('class' => '', 'alt' => 'asl-image', 'loading' => 'lazy')); ?>
                        </div>
                        <div class="content-wrapper">
                            <div class="banner__content">
                                <h2 class="banner__title">
                                    <?php echo wp_kses_post($about_slider['title']); ?>
                                </h2>
                                <p class="banner__desc">
                                    <?php echo wp_kses_post($about_slider['description']); ?>
                                </p>
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