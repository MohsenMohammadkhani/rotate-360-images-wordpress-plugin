<?php
if (!defined('ABSPATH')) exit;

add_action('rest_api_init', function () {
    register_rest_route('rota-rotate-plugin/v1', 'get-rotate-plugin/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'rotaGetRotate360ImageEndPoint',
        'permission_callback' => '__return_true',
    ));
});

function rotaGetRotate360ImageEndPoint($data)
{
    $getRotate360ImageID = (int)($data['id']);
    $rotate360Image = rotaGetRotate360Image($getRotate360ImageID);

    if (!$rotate360Image) {
        return;
    }

    $rotate360ImagesIDS = rotaGetImagesRotate360($getRotate360ImageID);
    $rotate360Image->images = rotaGetImagesSrcRotate360Images($rotate360ImagesIDS);

    return new WP_REST_Response($rotate360Image, 200);
}

function rotaGetImagesSrcRotate360Images($rotate360ImagesIDS)
{
    $imagesSrc = [];
    foreach ($rotate360ImagesIDS as $rotate360ImageID) {
        $imagesSrc[] = rotaGetImageSrcWithAttachmentID($rotate360ImageID->image_id);
    }
    return $imagesSrc;
}

function rotaGetImagesRotate360($rotateImageID)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates_images";
    return $wpdb->get_results($wpdb->prepare("SELECT image_id FROM $tableName WHERE `rotate_id`=%d", $rotateImageID));
}

function rotaGetRotate360Image($getRotate360ImageID)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $tableName WHERE `id`=%d AND active=1", $getRotate360ImageID));
}

function rotaGetImageSrcWithAttachmentID($attachmentID)
{
    $attachment = wp_get_attachment_image_src($attachmentID, 'full');
    return $attachment[0];
}

