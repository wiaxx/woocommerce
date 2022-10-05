<?php
// $categories = get_field('categories');
$title = get_field('product_recommend_title');
$desc = get_field('product_recommend_text');
$products = get_field('products');

echo '<pre>';
var_dump($products);
echo '</pre>';
?>

<div class="products-recommend">

    <h1 class="recommend-title">
        <?php echo $title; ?>
    </h1>

    <p class="recommend-text">
        <?php echo $desc; ?>
    </p>

    <?php if ($products) :
        foreach ($products as $product) { ?>

            <div class="product-recommend">

                <div class="recommend-img">
                    <?php echo wp_get_attachment_image($product->ID, 'large'); ?>
                </div>

                <div class="recommend-info">
                    <h2>
                        <?php echo $product->post_title ?>
                    </h2>

                    <p>
                        <?php echo $product->post_excerpt ?>
                    </p>

                    <!-- <a href="<?php // echo get_term_link($category); ?>">
                        View collection
                    </a> -->
                </div>

            </div>

    <?php }
    endif;




    ?>