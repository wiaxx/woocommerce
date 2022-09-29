<!-- Hero Block -->
<?php
$image = get_field('background_image');
?>

<div class="hero-block">

    <?php
    if ($image) : echo wp_get_attachment_image($image['id'], 'large');
    endif;
    ?>

</div>