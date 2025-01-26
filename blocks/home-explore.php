<?php 
$bte_title          = get_field('he_title');
$bte_description    = get_field('he_description');
$bte_button_label   = get_field('he_button_label');
$bte_button_link    = get_field('he_button_link');
$bte_image          = get_field('he_background_image');
?>
<div class="bte-explore cta overlap">
    <div class="cta__image">
        <img class="width-full" src="<?php echo esc_url( $bte_image ) ;?>" alt="">
    </div>
    <div class="cta__content bg-color-off-white">
        <h2 class="title">                    
            <?php echo wp_kses_post( $bte_title ) ;?>
        </h2>
        <p class="desc">                    
            <?php echo wp_kses_post( $bte_description ) ;?>
        </p>
        <?php if( $bte_button_label && $bte_button_link ) : ?>
            <a href="<?php echo esc_url( $bte_button_link );?>" class="btn"><?php echo esc_html( $bte_button_label ) ;?></a>
        <?php endif; ?>
    </div>
</div>