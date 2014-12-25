<?php
// To add custom data above add to cart button in woocommerce
// step 1
add_action('wp_ajax_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');
add_action('wp_ajax_nopriv_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');

function wdm_add_user_custom_data_options_callback() {
//Custom data - Sent Via AJAX post method
    $product_id = $_POST['id']; //This is product ID
    $custom_data_1 = $_POST['custom_data_1']; //This is User custom value sent via AJAX
    $custom_data_2 = $_POST['custom_data_2'];
    $custom_data_3 = $_POST['custom_data_3'];
    $custom_data_4 = $_POST['custom_data_4'];
    $custom_data_5 = $_POST['custom_data_5'];
    session_start();
    $_SESSION['custom_data_1'] = $custom_data_1;
    $_SESSION['custom_data_2'] = $custom_data_2;
    $_SESSION['custom_data_3'] = $custom_data_3;
    $_SESSION['custom_data_4'] = $custom_data_4;
    $_SESSION['custom_data_5'] = $custom_data_5;
    die();
}

// step 2
add_filter('woocommerce_add_cart_item_data', 'wdm_add_item_data', 1, 2);
if (!function_exists('wdm_add_item_data')) {

    function wdm_add_item_data($cart_item_data, $product_id) {
        /* Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name */
        global $woocommerce;
        session_start();
        $new_value = array();
        if (isset($_SESSION['custom_data_1'])) {
            $option1 = $_SESSION['custom_data_1'];
            $new_value['custom_data_1'] = $option1;
        }
        if (isset($_SESSION['custom_data_2'])) {
            $option2 = $_SESSION['custom_data_2'];
            $new_value['custom_data_2'] = $option2;
        }
        if (isset($_SESSION['custom_data_3'])) {
            $option3 = $_SESSION['custom_data_3'];
            $new_value['custom_data_3'] = $option3;
        }
        if (isset($_SESSION['custom_data_4'])) {
            $option4 = $_SESSION['custom_data_4'];
            $new_value['custom_data_4'] = $option4;
        }
        if (isset($_SESSION['custom_data_5'])) {
            $option5 = $_SESSION['custom_data_5'];
            $new_value['custom_data_5'] = $option5;
        }
        if (empty($option1) && empty($option2) && empty($option3) && empty($option4) && empty($option5))
            return $cart_item_data;
        else {
            if (empty($cart_item_data))
                return $new_value;
            else
                return array_merge($cart_item_data, $new_value);
        }
// vardump($new_value);
// die();
        unset($_SESSION['custom_data_1']);
        unset($_SESSION['custom_data_2']);
        unset($_SESSION['custom_data_3']);
        unset($_SESSION['custom_data_4']);
        unset($_SESSION['custom_data_5']);
//Unset our custom session variable, as it is no longer needed.
    }

}
// step 3
add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3);
if (!function_exists('wdm_get_cart_items_from_session')) {

    function wdm_get_cart_items_from_session($item, $values, $key) {
        if (array_key_exists('custom_data_1', $values)) {
            $item['custom_data_1'] = $values['custom_data_1'];
        }
        if (array_key_exists('custom_data_2', $values)) {
            $item['custom_data_2'] = $values['custom_data_2'];
        }
        if (array_key_exists('custom_data_3', $values)) {
            $item['custom_data_3'] = $values['custom_data_3'];
        }
        if (array_key_exists('custom_data_4', $values)) {
            $item['custom_data_4'] = $values['custom_data_4'];
        }
        if (array_key_exists('custom_data_5', $values)) {
            $item['custom_data_5'] = $values['custom_data_5'];
        }
        return $item;
    }

}
// step 4
add_filter('woocommerce_checkout_cart_item_quantity', 'wdm_add_user_custom_option_from_session_into_cart', 1, 3);
add_filter('woocommerce_cart_item_price', 'wdm_add_user_custom_option_from_session_into_cart', 1, 3);
if (!function_exists('wdm_add_user_custom_option_from_session_into_cart')) {

    function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key) {
        /* code to add custom data on Cart & checkout Page */
        if (count($values['custom_data_1']) > 0) {
            $return_string = $product_name . "</a><dl class='variation'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td> custom_data_1 : " . $values['custom_data_1'] . "</td></tr>";
            $return_string .= "<tr><td> custom_data_2 : " . $values['custom_data_2'] . "</td></tr>";
            $return_string .= "<tr><td> custom_data_3 : " . $values['custom_data_3'] . "</td></tr>";
            $return_string .= "<tr><td> custom_data_4 : " . $values['custom_data_4'] . "</td></tr>";
            $return_string .= "<tr><td> custom_data_5 : " . $values['custom_data_5'] . "</td></tr>";
            $return_string .= "</table></dl>";
            return $return_string;
        } else {
            return $product_name;
        }
    }

}
// step 5
add_action('woocommerce_add_order_item_meta', 'wdm_add_values_to_order_item_meta', 1, 2);
if (!function_exists('wdm_add_values_to_order_item_meta')) {

    function wdm_add_values_to_order_item_meta($item_id, $values) {
        global $woocommerce, $wpdb;
        $user_custom_values = $values['wdm_user_custom_data_value'];
        if (!empty($user_custom_values)) {
            wc_add_order_item_meta($item_id, 'wdm_user_custom_data', $user_custom_values);
        }
        $custom_data_2 = $values['custom_data_2'];
        if (!empty($custom_data_2)) {
            wc_add_order_item_meta($item_id, 'custom_data_2', $custom_data_2);
        }
        $custom_data_3 = $values['custom_data_3'];
        if (!empty($custom_data_3)) {
            wc_add_order_item_meta($item_id, 'custom_data_3', $custom_data_3);
        }
        $custom_data_4 = $values['custom_data_4'];
        if (!empty($custom_data_4)) {
            wc_add_order_item_meta($item_id, 'custom_data_4', $custom_data_4);
        }
        $custom_data_5 = $values['custom_data_5'];
        if (!empty($custom_data_5)) {
            wc_add_order_item_meta($item_id, 'custom_data_5', $custom_data_5);
        }
    }

}
// step 6
add_action('woocommerce_before_cart_item_quantity_zero', 'wdm_remove_user_custom_data_options_from_cart', 1, 1);
if (!function_exists('wdm_remove_user_custom_data_options_from_cart')) {

    function wdm_remove_user_custom_data_options_from_cart($cart_item_key) {
        global $woocommerce;
// Get cart
        $cart = $woocommerce->cart->get_cart();
// For each item in cart, if item is upsell of deleted product, delete it
        foreach ($cart as $key => $values) {
            if ($values['wdm_user_custom_data_value'] == $cart_item_key)
                unset($woocommerce->cart->cart_contents[$key]);
        }
    }

}
?>

// I m using following script in my template which is working perfect

<script type="text/javascript">
    jQuery(document).ready(function () {
//code to add validation on "Add to Cart" button
        jQuery('.single_add_to_cart_button').click(function () {
//code to add validation, if any
//If all values are proper, then send AJAX request
            alert('sending ajax request');
            var custom_data_1 = 'custom_data_1';
            var custom_data_2 = 'custom_data_2';
            var custom_data_3 = 'custom_data_3';
            var custom_data_4 = 'custom_data_4';
            var custom_data_5 = 'custom_data_5';
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.ajax({
                url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
                type: "POST",
                data: {
//action name
                    action: 'wdm_add_user_custom_data_options',
                    custom_data_1: custom_data_1,
                    custom_data_2: custom_data_2,
                    custom_data_3: custom_data_3,
                    custom_data_4: custom_data_4,
                    custom_data_5: custom_data_5
                },
                async: false,
                success: function (data) {
//Code, that need to be executed when data arrives after
// successful AJAX request execution
                    alert('ajax response recieved');
                }
            });
        })
    });
</script> 
