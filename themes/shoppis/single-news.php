 <?php
$the_query = new WP_Query(array(
    'posts_per_page' => 1,
));
?>

<?php if ($the_query->have_posts()) : ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
     

      <h3 class="single-news-title"><?php the_title(); ?> </h3>  
      <span class="date"> <?php the_time(get_option('date_format')); ?> </span>
      <div class="single-news-content">
      <div class="thumbnail"> <?php the_post_thumbnail('thumbnail'); ?> </div>
        <?php the_content(); ?>
      </div>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>

<?php get_footer(); ?>