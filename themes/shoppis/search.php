<?php  /* Template Name: Search Form */ ?>
<?php get_header() ?>

<div class="search-title"> <?php the_title(); ?> </div>
<p class="looking">What are you looking for? </p>
<div class="search-container">
    <div class="search-form">
    <?php get_search_form(); ?>
    </div>

    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="search-result">
            <p>

             <a href="<?php the_permalink(); ?>">
             <?php the_post_thumbnail('thumbnail') ?>
             </a> 
            </p>

                <span><?php the_excerpt(); ?></span>
             </div>

        <?php endwhile; ?>
        <?php else : ?>


        <div class="search-result">
        <h2> <?php _e('No items found'); ?></h2>
        </div>

     <?php endif; ?>
</div>

<?php
get_footer();
?>