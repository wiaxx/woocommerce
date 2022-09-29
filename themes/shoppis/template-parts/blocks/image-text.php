<!-- Half Image / Half Text Block -->
<?php
$image = get_field('image');

?>
<div class="image-text-block">

    <div class="text-block">
        <a href="#">
            <?php echo get_field('half_text_link'); ?>
        </a>

        <h2>
            <?php echo get_field('half_text_heading'); ?>
        </h2>

        <p>
            <?php echo get_field('half_text'); ?>
        </p>

        <button>
            <?php echo get_field('half_text_btn'); ?>
        </button>
    </div>

    <div class="image-block">
        <?php
        if ($image) : echo wp_get_attachment_image($image['id'], 'large');
        endif;
        ?>
    </div>

</div>