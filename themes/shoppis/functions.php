<?php

// enqueue style.css
function test_theme_enqueue_styles()
{
    wp_enqueue_style('style-css', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'test_theme_enqueue_styles', 11);

// create menus
register_nav_menus(array(
    'main-menu' => esc_html__('Main menu', 'shoppis'),
    'first-footer-menu' => esc_html__('First footer menu', 'shoppis'),
    'second-footer-menu' => esc_html__('Second footer menu', 'shoppis')
));

// add support to theme to upload thumbnails on post and pages
add_theme_support('post-thumbnails');

// add support for woocommerce
function add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'add_woocommerce_support');

// remove woocommerce sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// adding font
function add_google_fonts()
{

    wp_enqueue_style('add_google_fonts', 'https://fonts.google.com/specimen/Libre+Baskerville?query=Libre+Baskerville',
                                         'https://fonts.google.com/specimen/Montserrat?query=Montserrat', false);

    add_action('wp_enqueue_scripts', 'add_google_fonts');
}

//  message about free shipping
add_action('woocommerce_before_cart', 'single_product_cart_notice');

function single_product_cart_notice()
{

    $cart_total = WC()->cart->subtotal;
    $minimum_amount = 399;

    wc_clear_notices();

    if ($cart_total < $minimum_amount) {
        wc_print_notice($minimum_amount - $cart_total . "kr kvar för att få fri frakt!");
    } else {
        wc_print_notice("Du har fått fri frakt!");
    }

    wc_clear_notices();
}

// create custom blocks
function my_acf_init_block_types()
{
    // Check function exists.
    if (function_exists('acf_register_block_type')) {

        // register a hero block.
        acf_register_block_type(array(
            'name'              => 'hero',
            'title'             => __('Hero'),
            'description'       => __('A custom hero block.'),
            'render_template'   => 'template-parts/blocks/hero.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('hero'),
        ));

        // register a intro block.
        acf_register_block_type(array(
            'name'              => 'intro',
            'title'             => __('Intro'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/intro.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('intro'),
        ));

        // register a product highlight block.
        acf_register_block_type(array(
            'name'              => 'product_highlight',
            'title'             => __('Product Highlight'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/product-highlight.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('product_highlight'),
        ));

        // register a collection highlight block.
        acf_register_block_type(array(
            'name'              => 'collection',
            'title'             => __('Collection'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/collection.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('collection'),
        ));

        // register a half image / half text block.
        acf_register_block_type(array(
            'name'              => 'image_text',
            'title'             => __('Image Text'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/image-text.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('image_text'),
        ));

        // register a product recommend block.
        acf_register_block_type(array(
            'name'              => 'product_recommend',
            'title'             => __('Product Recommend'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/product-recommend.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('product_recommend'),
        ));

        // register a FAQ block.
        acf_register_block_type(array(
            'name'              => 'faq',
            'title'             => __('FAQ'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/faq.php',
            'category'          => 'formatting',
            'icon'              => 'text',
            'keywords'          => array('faq'),
        ));
    }
}

add_action('acf/init', 'my_acf_init_block_types');

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

// create custom post type for stores
function create_posttype()
{
    register_post_type(
        'stores',

        array(
            'labels' => array(
                'name' => __('Stores'),
                'singular_name' => __('Store'),
                'add_new_item' => __('Add New Store', 'text_domain'),
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'stores'),
        )
    );
}

add_action('init', 'create_posttype');



