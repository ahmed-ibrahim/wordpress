<?php

media_handle_upload( $file_handler, $post_id );

//upload artwork image
$fileData = $_FILES['artwork_image'];
$upload_dir = wp_upload_dir();
$image_data = file_get_contents($fileData['tmp_name']);
$filename = uniqid();
if (wp_mkdir_p($upload_dir['path'])) {
//check that the file name does not exist
while (@file_exists($upload_dir['path'] . '/' . $filename)) {
//try to find a new unique name
$filename = uniqid();
}
$file = $upload_dir['path'] . '/' . $filename;
} else {
//check that the file name does not exist
while (@file_exists($upload_dir['basedir'] . '/' . $filename)) {
//try to find a new unique name
$filename = uniqid();
}
$file = $upload_dir['basedir'] . '/' . $filename;
}
file_put_contents($file, $image_data);

list(, $ext) = explode('.', $fileData['name']);

$attachment = array(
'post_mime_type' => 'image/' . $ext,
 'post_title' => $filename,
 'post_content' => '',
 'post_status' => 'inherit'
);
$attach_id = wp_insert_attachment($attachment, $file, $newPostId);
require_once(ABSPATH . 'wp-admin/includes/image.php');
$attach_data = wp_generate_attachment_metadata($attach_id, $file);
wp_update_attachment_metadata($attach_id, $attach_data);
if ($attach_id) {
set_post_thumbnail($newPostId, $attach_id);
}

===============================================

$imgName = $_FILES['comp_img']['name'][$key];
$upload_dir = wp_upload_dir();
$image_data = file_get_contents($img);
$filename = uniqid();
if (wp_mkdir_p($upload_dir['path'])) {
//check that the file name does not exist
while (@file_exists($upload_dir['path'] . '/' . $filename)) {
//try to find a new unique name
$filename = uniqid();
}
$file = $upload_dir['path'];
}

list(, $ext) = explode('.', $imgName);
$post_mime_type = 'image/' . $ext;

$allowedMimeTypes = array(
'jpe' => 'image/jpe',
 'jpeg' => 'image/jpeg',
 'jpg' => 'image/jpg',
 'gif' => 'image/gif',
 'png' => 'image/png',
 'bmp' => 'image/bmp',
 'tif|tiff' => 'image/tiff',
 'ico' => 'image/x-icon',
);
if (in_array($post_mime_type, $allowedMimeTypes)) {
$filename = $filename . '.' . $ext;
$file = $file . '/' . $filename;

file_put_contents($file, $image_data);

$attachment = array(
'guid' => $upload_dir['url'] . '/' . $filename,
 'post_mime_type' => $post_mime_type,
 'post_title' => $filename,
 'post_content' => '',
 'post_status' => 'inherit'
);
$attach_id = wp_insert_attachment($attachment, $file);
require_once(ABSPATH . 'wp-admin/includes/image.php');
$attach_data = wp_generate_attachment_metadata($attach_id, $file);
wp_update_attachment_metadata($attach_id, $attach_data);

if ($attach_id){
$imagesArray[] = $attach_id;
}
