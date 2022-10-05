<?php
get_header();
?>

<div class="woocommerce">

    <?php woocommerce_content(); ?>

    <?php if (is_product_category()) : ?>
        <?php get_template_part('template-parts/two-categories'); ?>
    <?php endif; ?>

    <?php if (is_product()) : ?>
        <?php get_template_part('template-parts/half-img-text'); ?>
    <?php endif; ?>

</div>

<?php get_footer(); ?>