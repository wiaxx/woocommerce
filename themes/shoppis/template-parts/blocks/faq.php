<!-- --- FAQ Block for Store Info ---- -->
 <?php 
 $number = get_field('number');

 $args = array(
        'post_type' => 'stores',
        'post_status' => 'publish',
        'posts_per_page' => $number,
    );

    $loop = new WP_Query( $args ); 
    ?>
    <div class="stores">
        <h1>Our Stores</h1>
     <?php 
    
    if ($loop->have_posts()) : ?>
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>

    <?php get_template_part('template-parts/listed-stores'); ?>


    <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

    <?php endif; ?>