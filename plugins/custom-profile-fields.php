<?php
/*
  Plugin Name: Custom Profile Fields
  Plugin URI: http://objects.ws

 */

// This function hooks into the profile page
add_action('show_user_profile', 'add_extra_profile_fields');

// This function hooks into the profile page
add_action('edit_user_profile', 'add_extra_profile_fields');

function add_extra_profile_fields($user) {
    ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="tel_number"><?php _e("Telephone Number"); ?></label></th>
            <td>
                <input type="text" name="tel_number" id="tel_number" value="<?php echo get_user_meta($user->ID, 'tel_number', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="fax_number"><?php _e("Fax Number"); ?></label></th>
            <td>
                <input type="text" name="fax_number" id="fax_number" value="<?php echo get_user_meta($user->ID, 'fax_number', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="fax_number"><?php _e("Mobile Numbe"); ?></label></th>
            <td>
                <input type="text" name="mob_number" id="mob_number" value="<?php echo get_user_meta($user->ID, 'mob_number', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="fax_number"><?php _e("Date Of Birth"); ?></label></th>
            <td>
                <input type="text" name="birth_date" id="birth_date" value="<?php echo get_user_meta($user->ID, 'birth_date', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="fax_number"><?php _e("Company Name"); ?></label></th>
            <td>
                <input type="text" name="copmany_name" id="copmany_name" value="<?php echo get_user_meta($user->ID, 'copmany_name', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'update_extra_profile_fields');
add_action('edit_user_profile_update', 'update_extra_profile_fields');

function update_extra_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'tel_number', $_POST['tel_number']);
    update_user_meta($user_id, 'fax_number', $_POST['fax_number']);
    update_user_meta($user_id, 'mob_number', $_POST['mob_number']);
    update_user_meta($user_id, 'copmany_name', $_POST['copmany_name']);
    update_user_meta($user_id, 'birth_date', $_POST['birth_date']);
}
?>