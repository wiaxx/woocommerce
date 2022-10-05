<?php
// get all image ids available
$image_ids = get_posts(
    array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    )
);
// based on the number of image_ids retrieved, generate a random number within bounds.
$num_of_images = count($image_ids);
$random_index = rand(0, $num_of_images);
$random_image_id = $image_ids[$random_index];
?>

<!-- Half Image / Half Text -->
<div class="image-text-block">

    <div class="text-block">
        <a href="#">Something we like</a>

        <h2>Lorem ipsum lorem ipsum</h2>

        <p>
            Regular bread textRegular bread textRegular bread textRegular
            bread textRegular bread textRegular bread text. Regular bread
            textRegular bread textRegular bread textRegular bread textRegula.
        </p>

        <button> Read more </button>
    </div>

    <div class="image-block">
        <?php
        echo wp_get_attachment_image($random_image_id, 'large');
        ?>
    </div>

</div>