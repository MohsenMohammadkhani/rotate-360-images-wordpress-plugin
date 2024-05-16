<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_get_image_src_with_attachment_ID', function () {
    $imagesIDS  = array_map('sanitize_text_field', $_GET['images_IDS']);
    $imagesUrls = array_map(function ($imageID) {
        $attachment = wp_get_attachment_image_src($imageID, 'full');
        return [
            "ID" => $imageID,
            "src" => $attachment[0],
        ];
    }, $imagesIDS);
    wp_send_json(wp_json_encode($imagesUrls), 200);
    wp_die();
});

add_action('wp_ajax_get_rotate_360_image', function () {
    $currentPage = intval($_GET['page']);
    $titleSearch = sanitize_text_field($_GET['title']);
    $IDSearch =  sanitize_text_field($_GET['id']);
    require ROTA_DIR . 'modules-menu/rotate-image.php';
    wp_send_json(rotaGetRotate360ImagesPaginate($currentPage, $IDSearch, $titleSearch), 200);
    wp_die();
});
