<?php
/*
  Plugin Name: Custom Registration Fields
  Plugin URI: http://objects.ws
  Description: Add fields to register form

 */

// This function shows the form field on registration page
add_action('register_form', 'show_first_name_field');

// This is a check to see if you want to make a field required
//add_action('register_post', 'check_fields', 10, 3);
// This inserts the data
add_action('user_register', 'register_extra_fields');

// This is the forms The Two forms that will be added to the wp register page
function show_first_name_field() {
    ?>
    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="exampleInputPassword1">Telephone Number</label>
            <input type="text" class="form-control" name="tel_number" value="<?php echo $_POST['tel_number']; ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="exampleInputPassword1">Fax Number</label>
            <input type="text" class="form-control" name="fax_number" value="<?php echo $_POST['fax_number']; ?>">
        </div>


        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="exampleInputPassword1">Mobile Number</label>
            <input type="text" class="form-control" name="mob_number" value="<?php echo $_POST['mob_number']; ?>">
        </div>

    </div>

    <div class="row">

        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="exampleInputPassword1">Date Of Birth</label>
            <input type="text" class="form-control birthDate" name="birth_date" value="<?php echo $_POST['birth_date']; ?>">
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="exampleInputPassword1">Company Name</label>
            <input type="text" class="form-control" name="copmany_name" value="<?php echo $_POST['copmany_name']; ?>">
        </div>

    </div>
    <?php
}

// This function checks to see if they didn't enter them
// If no first name or last name display Error
function check_fields($login, $email, $errors) {
    global $zipcode;
    global $describes;
    if ($_POST['zip_code'] == '') {
        $errors->add('empty_realname', "<strong>ERROR</strong>: Please enter Zip Code");
    } elseif (!ctype_digit($_POST['zip_code'])) {
        $errors->add('empty_realname', "<strong>ERROR</strong>: Please enter Valid numeric Zip Code");
    } else {
        $zipcode = $_POST['zip_code'];
    }

    if ($_POST['describes'] == 'none') {
        $errors->add('empty_describes', "<strong>ERROR</strong>: Please tells us which best describes you");
    } else {
        $describes = $_POST['describes'];
    }

    if ($_POST['hp'] != '') {
        $errors->add('empty_realname', "<strong>ERROR</strong>: You are spammer");
    }
}

// This is where the magic happens
function register_extra_fields($user_id, $password = "", $meta = array()) {
    add_user_meta($user_id, 'tel_number', $_POST['tel_number']);
    add_user_meta($user_id, 'fax_number', $_POST['fax_number']);
    add_user_meta($user_id, 'mob_number', $_POST['mob_number']);
    add_user_meta($user_id, 'copmany_name', $_POST['copmany_name']);
    add_user_meta($user_id, 'birth_date', $_POST['birth_date']);
}
?>