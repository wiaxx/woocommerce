<?php get_header() ?>

<?php /* Template Name: News */ ?>

<?php 
get_header();
$site_title = get_bloginfo('name');
$site_url = network_site_url('/');
?>

<h1 class="header-logo">
<?php echo $site_title; ?>
</h1>

<h3 class="news-news"><?php the_title(); ?> </h3>  


<?php
$the_query = new WP_Query(array(
    'posts_per_page' => 6,
));
?>

<?php if ($the_query->have_posts()) : ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
    

      <h3 class="all-news-title"><?php the_title(); ?> </h3>  
      <a class="permalink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

      <span class="date"> <?php the_time(get_option('date_format')); ?> </span>

      <div class="all-news-content">
        
           
          </div>
        <?php the_content(); ?> 
      </div>


    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>

<?php get_footer(); ?>
