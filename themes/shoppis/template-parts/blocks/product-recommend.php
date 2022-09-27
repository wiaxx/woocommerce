<?php 

 $args = array(
        'post_type' => 'products',
        'post_status' => 'publish',
        'posts_per_page' => 2,
    );

    $loop = new WP_Query( $args ); 
    ?>

    <div class="product-recommend">
     <?php 
    
    if ($loop->have_posts()) : ?>
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>


    <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

    <?php endif; ?>

            





    <!-- <div class="faq-block-content">
        <h1><?php the_field('heading')?></h1>
    </div>
</div> -->

<!-- if($image) {
    $image_id = $image['id'];
    echo wp_get_attachment_image($image_id, 'large');
} -->