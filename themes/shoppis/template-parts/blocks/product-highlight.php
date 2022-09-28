<?php
$product_id = get_field('product_id');
?>

<div class="product-highlight-block">

    <?php
    echo do_shortcode('[product_page id=' . $product_id . ']');
    ?>

</div>