<?php
get_header();
?>

<div class="woocommerce">

    <?php
    woocommerce_content();
    ?>

    <?php
    if (is_product_category()) {
    ?>
        <?php get_template_part('template-parts/two-categories'); ?>
    <?php
    } ?>

    <?php
    if (is_product()) {
    ?>
    <h1>hejsan</h1>
        <?php // get_template_part('template-parts/two-categories'); ?>
    <?php
    } ?>

</div>

<?php get_footer(); ?>