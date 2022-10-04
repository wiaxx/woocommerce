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
        <h1>Show two categories</h1>

    <?php
    } ?>
</div>

<?php get_footer(); ?>