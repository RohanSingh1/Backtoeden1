<?php 
$bte_services = get_field('home_services');
?>
<div class="bte-services feature">
    <div class="container">
        <div class="service-items grid">
            <?php foreach( $bte_services as $home_service ) : ?>
                <div class="service-item column">
                    <?php echo wp_get_attachment_image( $home_service['image'], 'full', '', array( 'class' => '', 'alt' => 'hs-image', 'loading' => 'lazy' ) ); ?>                    
                    <h3 class="title">                    
                        <?php echo wp_kses_post( $home_service['title'] ) ;?>
                    </h3>
                    <p class="desc">                    
                        <?php echo wp_kses_post( $home_service['description'] ) ;?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
