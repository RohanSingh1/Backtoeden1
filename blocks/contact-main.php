<?php 
$contact_shortcode    = get_field('contact_shortcode');
$bte_location_label = get_field('contact_location_label');
$bte_location = get_field('contact_location');
$bte_opening_label = get_field('opening_hours_label');
$bte_opening = get_field('opening_hours');
?>
<section aria-labelledby="contact-form-section" class="contact-form overlap">
    <div class="contact-form__bg-img height-full">
        <img class="cover-fit height-full width-full" src="<?php echo get_template_directory_uri() . '/assets/images/contact-bg-img.jpg'; ?>" alt="country side">
    </div>
    <div class="contact-form__wrapper form">
        <div class="form__wrapper contact-form__flex container <?php echo ( wp_is_mobile() ) ? 'bg-color-off-white' : 'bg-color-white'; ?> border-radius-10">
            <div class="contact-form__main">
                <?php echo do_shortcode( $contact_shortcode ); ?>
            </div>
            <div class="contact-form__details">
                <div>
                    <h4><?php echo esc_html( $bte_location_label ); ?></h4>
                    <?php echo wp_kses_post( $bte_location ); ?>
                </div>
                <div>
                    <h4><?php echo esc_html( $bte_opening_label ); ?></h4>
                    <?php echo wp_kses_post( $bte_opening ); ?>
                </div>
            </div>
        </div>
    </div>
</section>