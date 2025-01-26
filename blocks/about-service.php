<?php 
$bte_title   = get_field('asr_title');
$bte_service = get_field('about_service');
?>
<section class="services">
    <div class="section-title">
        <h2><?php echo esc_html( $bte_title ) ;?></h2>
        <div class="service-wrapper">
            <?php foreach( $bte_service as $index => $about_service ) : ?>
                <div class="service-col<?php echo ( $index % 2 == 1 ) ? ' img-left' : ''; ?>">
                    <div class="content">
                        <h2>
                            <?php echo wp_kses_post( $about_service['title'] ) ;?>
                        </h2>
                        <p>
                            <?php echo wp_kses_post( $about_service['description'] ) ;?>
                        </p>
                    </div>
                    <div class="image">
                        <?php echo wp_get_attachment_image( $about_service['image'], 'full', '', array( 'class' => '', 'alt' => 'asr-image', 'loading' => 'lazy' ) ); ?>
                    </div>
                </div>
            <?php $index++; endforeach; ?>
        </div>
    </div>
</section>