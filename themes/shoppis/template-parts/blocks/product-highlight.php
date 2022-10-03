<!-- Product Highlight Block -->
<?php
$product_id = get_field('product_id');
$product = wc_get_product($product_id);

if ($product) :
    $terms = get_the_terms($product_id, 'product_cat');
    $category = $terms[0]->name;
    $category_id = $terms[0]->term_id;
endif
?>

<div class="product-highlight-block">

    <?php if ($product) : ?>

        <div class="highlight-image">
            <?php echo wp_get_attachment_image($product->image_id, 'large'); ?>
        </div>

        <div class="highlight-info">

            <a href="<?php echo get_category_link($category_id); ?>">
                <?php echo $category ?>
            </a>

            <h1 class="highlight-title">
                <?php echo $product->name; ?>
            </h1>

            <span class="highlight-price">
                <?php echo $product->price; ?> SEK
            </span>

            <p class="highlight-description">
                <?php echo $product->short_description; ?>
            </p>

            <button>
                <a href="<?php echo get_permalink($product_id); ?>">READ MORE</a>
            </button>
        </div>

    <?php endif ?>

</div>