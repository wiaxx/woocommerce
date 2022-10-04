    <div class="products-recommend">

<?php 
    $categories = get_field('categories');
     $products = get_field('products');
?>


<?php
     if ($categories) {
        foreach ($categories as $cat_id) {

     if( $products = get_term_by( 'id', $cat_id, 'product_cat' ) ){ ?>  
    <div class="cat-name"> <?php echo $products->name; ?> </div>
   

   <?php
    $thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true ); 

    $image = wp_get_attachment_url( $thumbnail_id ); 

    echo "<img src='{$image}' alt='' width='200' height='200' />";
    
 }

  }  

    }
 ?>
 </div>