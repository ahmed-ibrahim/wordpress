<?php
add_action('woocommerce_after_order_notes', 'wccs_custom_checkout_field');

function wccs_custom_checkout_field($checkout) {

    woocommerce_form_field('latitude', array(
        'type' => 'text',
        'label' => 'Latitude',
        'required' => 1,
        'placeholder' => 'Latitude',
            ), $checkout->get_value('latitude'));
    woocommerce_form_field('longitude', array(
        'type' => 'text',
        'label' => 'Longitude',
        'required' => 1,
        'placeholder' => 'Longitude',
            ), $checkout->get_value('longitude'));
}

/**
 * Validate the custom field.
 */
add_action('woocommerce_checkout_process', 'validate_custom_checkout_field_process');

function validate_custom_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ((isset($_POST['latitude']) && !$_POST['latitude']) || (isset($_POST['longitude']) && !$_POST['longitude'])) {
        wc_add_notice(__('Please define your location on the map.'), 'error');
    }
}

/**
 * Save the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta($order_id) {
    if ((isset($_POST['latitude']) && $_POST['latitude']) || (isset($_POST['longitude']) && $_POST['longitude'])) {
        update_post_meta($order_id, 'latitude', esc_attr($_POST['latitude']));
        update_post_meta($order_id, 'longitude', esc_attr($_POST['longitude']));
    }
}

/**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);

function my_custom_checkout_field_display_admin_order_meta($order) {
    if (get_post_meta($order->id, 'latitude', true) && get_post_meta($order->id, 'longitude', true)) {
        echo '<p><strong>' . __('user Location') . ':</strong> <a target="_blank" href="http://www.google.com/maps/place/' . get_post_meta($order->id, 'latitude', true) . ',' . get_post_meta($order->id, 'longitude', true) . '">click here</a></p>';
    }
}

add_filter('woocommerce_cart_shipping_packages', 'add_custom_data_to_packages', 10, 1);

function add_custom_data_to_packages($packages) {
    $packages[0]['destination']['latitude'] = WC()->session->get('latitude');
    $packages[0]['destination']['longitude'] = WC()->session->get('longitude');
    return $packages;
}

//add_position_to_session
add_action('wp_ajax_add_position_to_session', 'add_position_to_session_callback');
add_action('wp_ajax_nopriv_add_position_to_session', 'add_position_to_session_callback');

function add_position_to_session_callback() {

    WC()->session->set('latitude', esc_attr($_POST['lat']));
    WC()->session->set('longitude', esc_attr($_POST['lng']));
    echo 'done';
    die();
}

/**
 * calculate_shipping function.
 *
 * @access public
 * @param mixed $package
 * @return void
 */
function calculate_shipping($package) {
    $lat = $package['destination']['latitude'];
    $lng = $package['destination']['longitude'];
}
?>
<script>
    function add_position_to_session() {
        var lat = $('#latitude').val();
        var lng = $('#longitude').val();

        var data = {
            'action': 'add_position_to_session',
            'lat': lat,
            'lng': lng
        };
        $.ajax({
            url: ajax_url,
            data: data,
            type: 'post',
            success: function (msg) {

            }, complete: function () {
                $('#billing_country').change();
            }
        });
    }
</script>    