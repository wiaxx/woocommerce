<!--     
    <?php 
     $category = get_field('product_category');
     $product = get_field('products');
     ?>



        <?php if ($category->have_products()) : ?>
            <?php while ($category->have_products()) : $category->the_product(); ?>  


            <h1>
            <?php echo $category ?>
            </h1>

            
 <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?> -->