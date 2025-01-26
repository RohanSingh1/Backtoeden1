<?php 
$bte_title          = get_field('hct_title');
$bte_description    = get_field('hct_description');
$bte_button_label   = get_field('hct_button_label');
$bte_button_link    = get_field('hct_button_link');
$bte_image          = get_field('hct_background_image');
?>
<div class="bte-cta footer-cta">
    <div class="overlap">
        <div class="image">
            <?php echo wp_get_attachment_image( $bte_image, 'full', '', array( 'class' => '', 'alt' => 'cta-image', 'loading' => 'lazy' ) ); ?>
        </div>
        <div class="content">            
            <h2 class="title">                    
                <?php echo esc_html( $bte_title ) ;?>
            </h2>                    
            <?php echo wp_kses_post( $bte_description ) ;?>
            <?php if( $bte_button_label && $bte_button_link ) : ?>
                <a href="<?php echo esc_url( $bte_button_link );?>" class="btn btn--white"><?php echo esc_html( $bte_button_label ) ;?></a>
            <?php endif; ?>
        </div>
    </div>
</div>