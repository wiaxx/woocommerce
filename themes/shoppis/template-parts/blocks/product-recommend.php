<?php
// $categories = get_field('categories');
$title = get_field('product_recommend_title');
$desc = get_field('product_recommend_text');
$products = get_field('products');
?>

<div class="products-recommend">

    <h1 class="recommend-title"> <?php echo $title; ?> </h1>

    <p class="recommend-text"> <?php echo $desc; ?> </p>

    <div class="products-wrapper">

        <?php if ($products) :
            foreach ($products as $product) {
                $wc_product = wc_get_product($product->ID);
        ?>
                <div class="product-recommend">

                    <div class="recommend-img">
                        <a href="<?php echo get_permalink($wc_product->id); ?>">
                            <?php echo wp_get_attachment_image($wc_product->image_id, 'large'); ?>
                        </a>
                    </div>

                    <div class="recommend-info">
                        <h2> <?php echo $wc_product->name; ?> </h2>

                        <p> <?php echo $wc_product->short_description ?> </p>

                        <p class="recommend-price">
                            <?php echo $wc_product->price; ?> SEK
                        </p>
                    </div>

                </div>

        <?php }
        endif;
        ?>
    </div>
</div>
