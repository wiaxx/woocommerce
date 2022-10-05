<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <title><?php the_title() ?></title>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php get_template_part('template-parts/nav'); ?>
