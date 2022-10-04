<?php get_header(); ?>

 <!-- Hero Block -->
 <div class="hero-block">

 <?php
$image = the_post_thumbnail('large');
?>


<?php
   if ($image) : echo wp_get_attachment_image($image['id'], 'large');
    endif;
    ?>
</div>

 
    <div class="single-news-wrapper">

    <span class="date"> <?php the_time(get_option('date_format')); ?> </span>
      <h3 class="single-news-title"><?php the_title(); ?> </h3>
      <div class="single-thumbnail"> <?php the_post_thumbnail('medium') ?> </div>
      <div class="single-news-content"> <?php the_content(); ?> </div>
      
    </div> 

<?php get_footer(); ?>
