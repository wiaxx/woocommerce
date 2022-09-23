<?php

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');



//  Funktion för meddelande om fri frakt
add_action('woocommerce_before_cart', 'single_product_cart_notice');

function single_product_cart_notice(){

	$cart_total = WC()->cart->subtotal;
	$minimum_amount = 399;
	
	wc_clear_notices();

	if ($cart_total < $minimum_amount){
		wc_print_notice($minimum_amount - $cart_total . "kr kvar för att få fri frakt!");
	} else {
		wc_print_notice("Du har fått fri frakt!");
	}

	wc_clear_notices();
}