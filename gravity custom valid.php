<?php

add_filter("gform_validation_2", "custom_validation_1");

function custom_validation_1($validation_result) {
    $form = $validation_result["form"];

    //get select day
    $date = $_POST['input_9'];
    $dayName = date('D', strtotime($date));
    //get select time
    $time = $_POST['input_10'];

    $hour = date('h', strtotime($time));
    $minutes = date('i', strtotime($time));
    $type = date('a', strtotime($time));

    if ($dayName == 'Tue' || $dayName == 'Mon') {
        if ($type == 'am') {
            if ($hour < 11) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 11:00 am - 07:00 pm.";
                        break;
                    }
                }
            }
        } else {
            if ($hour > 7 || ($hour == 7 && $minutes > 0)) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 11:00 am - 07:00 pm.";
                        break;
                    }
                }
            }
        }
    } elseif ($dayName == 'Wed' || $dayName == 'Thu') {
        if ($type == 'am') {
            if ($hour < 8) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 08:00 am - 04:00 pm.";
                        break;
                    }
                }
            }
        } else {
            if ($hour > 4 || ($hour == 4 && $minutes > 0)) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 08:00 am - 04:00 pm.";
                        break;
                    }
                }
            }
        }
    } elseif ($dayName == 'Fri') {
        if ($type == 'am') {
            if ($hour < 8) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 08:00 am - 03:00 pm.";
                        break;
                    }
                }
            }
        } else {
            if ($hour > 3 || ($hour == 3 && $minutes > 0)) {
                // set the form validation to false
                $validation_result["is_valid"] = false;
                //finding Field with ID of 1 and marking it as failed validation
                foreach ($form["fields"] as &$field) {

                    //NOTE: replace 1 with the field you would like to validate
                    if ($field["id"] == "10") {
                        $field["failed_validation"] = true;
                        $field["validation_message"] = "Operation time from 08:00 am - 03:00 pm.";
                        break;
                    }
                }
            }
        }
    }


    //Assign modified $form object back to the validation result
    $validation_result["form"] = $form;
    return $validation_result;
}
