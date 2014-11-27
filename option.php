<?php
if (is_admin()) {

    /* Call the html code */
    add_action('admin_menu', 'new_section_settings');

    function new_section_settings() {        
        add_submenu_page('themes.php', 'Mayriver Theme Options', 'Mayriver Theme Options', 'manage_options', 'mayriver-theme-options', 'mayriver_theme_options');
        add_menu_page('Closed Video Settings', 'Closed Video Settings', 'manage_options', 'closed-video-settings', 'closed_video_settings_function');
    }

}

function closed_video_settings_function() {
    ?>
    <div class="wrap">
        <div id="icon-tools" class="icon32"></div>
        <h2>Closed Video Settings</h2>
        <?php
        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'):
            ?>
            <div class="updated below-h2" id="message">
                <p>Settings Updated.</p>
            </div>
        <?php endif; ?>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <table class="widefat" style="margin-top: 20px;">
                <tbody>
                    <tr><th colspan="2">Group Name : [GroupName]</th></tr>
                    <tr>
                        <td style="width: 10%;">Login message</td>
                        <td>
                            <input type="text" style="width:90%;" name="login_message" value="<?php echo get_option('login_message'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;">Products message</td>
                        <td>
                            <input type="text" style="width:90%;" name="products_message" value="<?php echo get_option('products_message'); ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="login_message,products_message" />

            <p>
                <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
            </p>

        </form>

    </div>
    <?php
}
?>