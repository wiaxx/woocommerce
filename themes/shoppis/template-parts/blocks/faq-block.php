<!-- Hero Block for store info -->

<h1 class="header-logo">
<?php echo $site_title; ?>
</h1>

<div class="faq-block">

<?php 
$image = get_field('image'); 


 
if($image) {
    $image_id = $image['id'];
    echo wp_get_attachment_image($image_id, 'large');

}
?>
    <div class="faq-block-content">
        <h1><?php the_field('heading')?></h1>
    </div>
</div>