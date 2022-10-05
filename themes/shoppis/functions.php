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

    wp_enqueue_style(
        'add_google_fonts',
        'https://fonts.google.com/specimen/Libre+Baskerville?query=Libre+Baskerville',
        'https://fonts.google.com/specimen/Montserrat?query=Montserrat',
        false
    );

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

// change position of category on single product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 1);

// remove related products
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// remove review & additional_information tags from product content
function woo_remove_product_tabs($tabs)
{
    unset($tabs['additional_information']);      // Remove the additional information tab
    unset($tabs['reviews']);             // Remove the reviews tab

    return $tabs;
}

add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 60);

// support to add title in the_content
function echo_title_in_post($atts, $content = null)
{
    return '<h1 class="info-title">' . get_the_title() . '</h1>';
}

add_shortcode('the_title', 'echo_title_in_post');

// change text on proceed to checkout btn
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);

function custom_button_proceed_to_checkout()
{
    echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward">' .
        __("Checkout", "woocommerce") . '</a>';
}

add_action('woocommerce_proceed_to_checkout', 'custom_button_proceed_to_checkout', 20);
// support to add thumbnail in the_content
function featured_image($post, $atts, $content = null)
{
    if (has_post_thumbnail($post))
        return '<div class="info-thumbnail">' . get_the_post_thumbnail($post, 'large') . '</div>';
}

add_shortcode('featured_image', 'featured_image');

// merge tabs from My account page into one
function remove_tabs_my_account($items)
{
    unset($items['dashboard']);
    unset($items['orders']);
    unset($items['downloads']);
    unset($items['edit-address']);
    unset($items['payment-methods']);
    unset($items['edit-account']);
    unset($items['customer-logout']);
    return $items;
}

add_filter('woocommerce_account_menu_items', 'remove_tabs_my_account', 999);

// add content to dashboard tab on My account page
add_action('woocommerce_account_dashboard',  'woocommerce_account_orders');
add_action('woocommerce_account_dashboard',  'woocommerce_account_edit_address');
add_action('woocommerce_account_dashboard',  'woocommerce_account_edit_account');

// add title before my account content
add_action('woocommerce_before_account_orders', 'add_order_title');
function add_order_title()
{
    echo '<h2>Order History</h2>';
}

add_action('woocommerce_before_edit_account_address_form', 'add_address_title');
function add_address_title()
{
    echo '<h2>Addresses</h2>';
}

add_action('woocommerce_edit_account_form_start', 'add_account_title');
function add_account_title()
{
    echo '<h2>Account Details</h2>';
}

// display two columns with products instead of three 
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 2; // 3 products per row
    }
}

// remove product result count from category page
function remove_product_result_count()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
}

add_action('after_setup_theme', 'remove_product_result_count', 99);

// remove add to cart btn on category page
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// remove show sku on single product page
add_filter('wc_product_sku_enabled', '__return_false');

// add product gallery support
function product_gallery_support()
{
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'product_gallery_support');

// change number of upsells output
add_filter('woocommerce_upsell_display_args', 'wc_change_number_related_products', 20);

function wc_change_number_related_products($args)
{

    $args['posts_per_page'] = 4;
    $args['columns'] = 2; //change number of upsells here
    return $args;
}

function add_text_before_drop_down() {
    if(is_product_category()) :
        echo '<p class="category-sort"> Sort </p>';
    endif;
}

add_action('woocommerce_before_shop_loop','add_text_before_drop_down');
