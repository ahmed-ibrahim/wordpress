<?php
//update order status
$order->update_status('completed');

//cart url
echo $woocommerce->cart->get_cart_url();

wc_customer_edit_account_url();


//add options to sort
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');

function custom_woocommerce_get_catalog_ordering_args($args) {
    $orderby_value = isset($_GET['orderby']) ? woocommerce_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

    if ('sku' == $orderby_value) {
        $args['orderby'] = 'meta_value';
        $args['order'] = 'asc';
        $args['meta_key'] = '_sku';
    }

    return $args;
}

add_filter('woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

function custom_woocommerce_catalog_orderby($sortby) {
    $sortby['sku'] = 'Sort by sku';
    return $sortby;
}

//remove price
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 10);
//remove add to cart
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
remove_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30);


$order->add_order_note(
        sprintf(
                "Shipping label available at: '%s'", $shipment->postage_label->label_url
        )
);

//get add to cart form
woocommerce_simple_add_to_cart();


