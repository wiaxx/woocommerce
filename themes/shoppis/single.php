<?php get_header(); ?>

<div class="single-news-wrapper">

 <?php
$the_query = new WP_Query(array(
    'posts_per_page' => 1,
));
?>

<?php if ($the_query->have_posts()) : ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

 <!-- Hero Block -->
<?php
$image = get_field('background_image');
?>

<div class="hero-block">

<?php
   if ($image) : echo wp_get_attachment_image($image['id'], 'large');
    endif;
    ?>
</div>

    <span class="date"> <?php the_time(get_option('date_format')); ?> </span>
      <h3 class="single-news-title"><?php the_title(); ?> </h3>
      <div class="thumbnail-single"> <?php the_post_thumbnail('medium'); ?> </div>  
      <div class="single-news-content"> <?php the_content(); ?> </div>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    
    </div> 

<?php get_footer(); ?>
