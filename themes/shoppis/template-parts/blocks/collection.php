<!-- Collection Block -->
<?php
$categories  = get_terms('product_cat');
$title = get_field('collections_heading');
$description = get_field('collections_desc');
?>

<div class="collection-block">

    <h1 class="collection-title"> <?php echo $title; ?> </h1>

    <p class="collection-desc"> <?php echo $description; ?> </p>

    <div class="collection-categories">
        <?php
        if ($categories) :
            foreach ($categories as $category) {

                $id = $category->term_id;
                $thumbnail_id = get_term_meta($id, 'thumbnail_id', true);
                $image = wp_get_attachment_image($thumbnail_id, 'medium');
        ?>

                <div class="collection-category">

                    <div class="collection-img">
                        <?php echo $image; ?>
                    </div>

                    <div class="collection-text">
                        <h2>
                            <?php echo $category->name ?>
                        </h2>

                        <p>
                            <?php echo $category->description ?>
                        </p>

                        <a href="<?php echo get_term_link($category); ?>">
                            View collection
                        </a>
                    </div>

                </div>
        <?php }
        endif;
        ?>

    </div>
</div>