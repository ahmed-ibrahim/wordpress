<?php
add_action('admin_print_scripts', 'svg_admin_scripts');
add_action('admin_head', 'svg_register_head');
/* add css to admin */

function svg_register_head() {
    wp_enqueue_style('thickbox');
}

/* add js to admin */

function svg_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('svg-script', get_option('siteurl') . '/wp-content/themes/conqueror/js/admin/adminScript.js', array('jquery'));
    wp_enqueue_script('svg-script');
}

function product_svg_file() {
    global $post;
    ?>
    <table class="widefat">
        <tbody>
            <tr>
                <td>
                    <input id="product_svg_image_input" type="text" name="product_svg_image" value="<?php echo get_post_meta($post->ID, 'product_svg_image', TRUE); ?>" />
                    <input type="button" onclick="Uploader('product_svg_image_input', 'product_svg_image_src');" class="button-primary" value="Upload"/>                    
                    <img width="250" height="190" src="<?php echo get_post_meta($post->ID, 'page_arabic_image', TRUE); ?>" id="product_svg_image_src"/>                    
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    echo '<input type="hidden" name="noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}