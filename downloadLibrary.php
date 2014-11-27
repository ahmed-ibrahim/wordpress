<?php

require_once dirname(__FILE__) . '/../../../wp-load.php';
if (isset($_GET['id']) && $_GET['id']) {
    $library = get_post($_GET['id']);
    if ($library) {
        if (get_post_meta($_GET['id'], 'file', true)) {
            $fileObject = get_post(get_post_meta($_GET['id'], 'file', true));
            $filePath = $fileObject->guid;
            //increment download number
            update_post_meta($_GET['id'], '_downloads', get_post_meta($_GET['id'], '_downloads', TRUE) + 1);

            //download the file
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$filePath\"");
            readfile($filePath);
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>