<!-- Intro block -->
<?php
$btn_text = get_field('intro_button_text');
?>

<div class="intro-block">

    <h1 class="intro-title">
        <?php the_field('intro_heading'); ?>
    </h1>

    <p class="intro-text">
        <?php the_field('intro_text'); ?>
    </p>

    <?php if ($btn_text) : ?>
        <button>
            <?php echo $btn_text; ?>
        </button>
    <?php endif; ?>

</div>