<?php get_header(); ?>

<div class="listed-stores">
 <p class="store-title"><?php the_title(); ?> </p> 
 <p class="store-phone"><?php the_field('store_phone_number', get_the_id()); ?></p> 
 <p class="store-address"> <?php the_field('store_address', get_the_id()); ?></p> 
<p class="store-hours"><?php the_field('store_opening_hours', get_the_id()); ?> </p> 
</div>

