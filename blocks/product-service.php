<?php 
$product_service = get_field('product_service');
?>
<section class="services">
    <div class="section-title">
        <div class="service-wrapper">
            <?php foreach( $product_service as $index => $pro_service ) : ?>
                <div class="service-col<?php echo ( $index % 2 == 1 ) ? ' img-left' : ''; ?>">
                    <div class="content">
                        <h2>
                            <?php echo wp_kses_post( $pro_service['title'] ) ;?>
                        </h2>
                        <p>
                            <?php echo wp_kses_post( $pro_service['description'] ) ;?>
                        </p>
                    </div>
                    <div class="image">
                        <?php echo wp_get_attachment_image( $pro_service['image'], 'full', '', array( 'class' => '', 'alt' => 'asr-image', 'loading' => 'lazy' ) ); ?>
                    </div>
                </div>
            <?php $index++; endforeach; ?>
        </div>
    </div>
</section>