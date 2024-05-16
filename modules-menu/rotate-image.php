<?php
if (!defined('ABSPATH')) exit;
function rotaRotateMenuPage()
{
    if (isset($_POST['title'])) {
        $action = sanitize_text_field($_GET['action']);
        switch ($action) {

            case "add":
                $nonce = sanitize_text_field($_POST['nonce']);
                if (!wp_verify_nonce($nonce, 'rota-add-rotate-image')) {
                    die('Security error');
                }

                $color = sanitize_text_field($_POST['color']);
                $backgroundColorButtons = sanitize_text_field($_POST['background-color-buttons']);
                $speed = sanitize_text_field($_POST['speed']);
                $title = sanitize_text_field($_POST['title']);
                $images_ids = sanitize_text_field($_POST['images_ids']);

                rotaAddRotate([
                    'color' => $color,
                    'background-color-buttons' => $backgroundColorButtons,
                    'speed' => $speed,
                    'title' => $title,
                    'images_ids' => $images_ids,
                ]);
                break;

            case "edit":
                $nonce = sanitize_text_field($_POST['nonce']);
                if (!wp_verify_nonce($nonce, 'rota-edit-rotate-image')) {
                    die('Security error');
                }
                $id = sanitize_text_field($_GET['id']);

                $color = sanitize_text_field($_POST['color']);
                $backgroundColorButtons = sanitize_text_field($_POST['background-color-buttons']);
                $speed = sanitize_text_field($_POST['speed']);
                $title = sanitize_text_field($_POST['title']);
                $images_ids = sanitize_text_field($_POST['images_ids']);

                rotaEditRotateImage(
                    $id,
                    [
                        'color' => $color,
                        'background-color-buttons' => $backgroundColorButtons,
                        'speed' => $speed,
                        'title' => $title,
                        'images_ids' => $images_ids,
                    ]
                );
                break;
        }
        return;
    }

    if (isset($_GET['action'])) {
        $action = sanitize_text_field($_GET['action']);
        switch ($action) {

            case "add":
                wp_enqueue_script('rota-add-image-rotate.js', ROTA_ASSETS_DASHBOARD_URL . '/js/add-image-rotate.js', array('jquery'), '', true);
                require_once ROTA_DIR . "template/menu-admin/rotate-image/add.php";
                break;

            case "remove":
                $id = sanitize_text_field($_GET['id']);
                rotaRemoveRotate($id);
                break;

            case "toggle-status":
                $id = sanitize_text_field($_GET['id']);
                rotaToggleStatusRotate($id);
                break;

            case "edit":
                wp_enqueue_script('rota-add-image-rotate.js', ROTA_ASSETS_DASHBOARD_URL . '/js/add-image-rotate.js', array('jquery'), '', true);
                $id = sanitize_text_field($_GET['id']);
                rotaShowFormEdit($id);
                break;
        }
        return;
    }

    rotaShowAllRotate();
}


function rotaEditRotateImage($rotateID, $data)
{
    rotaRemoveRotateImages($rotateID);
    $color = str_replace("#", "", $data['color']);
    $backgroundColorButtons = str_replace("#", "", $data['background-color-buttons']);
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $tableName SET `title` = %s , `background_color` = %s,`background_color_button`=%s ,  `speed` = %d WHERE `id`=%d",
            $data['title'],
            $color,
            $backgroundColorButtons,
            $data['speed'],
            $rotateID
        )
    );
    $imagesIDS = explode(",", $data['images_ids']);
    rotaAddRotateImages($rotateID, $imagesIDS);
    wp_redirect("/wp-admin/admin.php?page=rota-menu-pages");
}


function rotaShowFormEdit($id)
{
    $rotate = rotaGetRotate($id);
    $imagesRotate = rotaGetImageRotate($id);
    require_once ROTA_DIR . "template/menu-admin/rotate-image/edit.php";
}

function rotaGetImageRotate($id)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates_images";
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE `rotate_id`=%d", $id));
    return $results;
}

function rotaToggleStatusRotate($id)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    $rotate = rotaGetRotate($id);
    $wpdb->query($wpdb->prepare("UPDATE `$tableName` SET `active`=%d  WHERE `id`=%d", !$rotate->active, $id));
    wp_redirect("/wp-admin/admin.php?page=rota-menu-pages");
}

function rotaGetRotate($id)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE `id`=%d", $id));
    return $results[0];
}

function rotaRemoveRotate($id)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    $wpdb->query($wpdb->prepare("DELETE FROM `$tableName` WHERE `id`=%d", $id));

    rotaRemoveRotateImages($id);

    rotaShowAllRotate();
}

function rotaRemoveRotateImages($rotateID)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates_images";
    $wpdb->query($wpdb->prepare("DELETE FROM `$tableName` WHERE `rotate_id`=%d", $rotateID));
}

function rotaAddRotate($post)
{
    $color = str_replace("#", "", $post['color']);
    $backgroundColorButtons = str_replace("#", "", $post['background-color-buttons']);
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";

    $wpdb->query($wpdb->prepare(
        "INSERT INTO `$tableName` 
    (`title`, `background_color`,`background_color_button`,`speed`) values (%s, %s, %s, %d)",
        $post['title'],
        $color,
        $backgroundColorButtons,
        $post['speed']
    ));
    $rotateID = $wpdb->insert_id;
    $imagesIDS = explode(",", $post['images_ids']);
    rotaAddRotateImages($rotateID, $imagesIDS);
    wp_redirect("/wp-admin/admin.php?page=rota-menu-pages");
}

function rotaAddRotateImages($rotateID, $imagesIDS)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates_images";
    foreach ($imagesIDS as $key => $imageID) {
        $wpdb->query(
            $wpdb->prepare("INSERT INTO `$tableName` (`image_id`, `rotate_id`) values (%d, %d)", $imageID, $rotateID)
        );
    }
}

function rotaGenerateWhereFromQuery($IDSearch, $titleSearch)
{
    $whereQuery = [
        "key" => [],
        "value" => [],
    ];

    if ($IDSearch) {
        $whereQuery['key']['id'] = "AND id=%d";
        $whereQuery['value']['id'] = $IDSearch;
    }

    if ($titleSearch) {
        $whereQuery['key']['title'] = " AND title LIKE %s ";
        $whereQuery['value']['title'] = "%$titleSearch%";
    }

    return $whereQuery;
}


function rotaGetRotate360ImagesPaginate($currentPage, $IDSearch, $titleSearch)
{
    $countItemsPerPage = 10;
    $whereQuery = rotaGenerateWhereFromQuery($IDSearch, $titleSearch);

    $countRotate360Image = rotaGetCountRotate360Image($whereQuery);

    $offset = rotaGetOffsetPagination(
        $countRotate360Image,
        $countItemsPerPage,
        $currentPage
    );

    $countPages = rotaGetCountPages($countRotate360Image, $countItemsPerPage);

    $limit = rotaGetLimit(
        $countItemsPerPage,
        $currentPage,
        $countRotate360Image,
        $countPages
    );

    $rotate360Image = rotaGetImage360Rotate(
        $offset,
        $limit,
        $whereQuery
    );

    return [
        "rotate-360-Image" => $rotate360Image,
        "count-page" => $countPages,
        "count-rotate-360-Image" => $countRotate360Image,
    ];
}

function rotaShowAllRotate()
{
    require_once ROTA_DIR . "template/menu-admin/rotate-image/all.php";
}

function rotaGetAllRotate()
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";
    return $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName"));
}

function rotaGetLimit($countItemsPerPage, $currentPage, $countItems, $countPages)
{
    if ($currentPage == $countPages) {
        return $countItems - $countItemsPerPage * ($currentPage - 1);
    }
    return $countItemsPerPage;
}

function rotaGetCountPages($countItems, $countItemsPerPage)
{
    return ceil($countItems / $countItemsPerPage);
}

function rotaGetOffsetPagination($countItems, $countItemsPerPage, $currentPage)
{
    $offset = $countItems - $countItemsPerPage * $currentPage;
    if ($offset < 0) {
        return 0;
    }
    return $offset;
}

function rotaGetCountRotate360Image($whereQuery)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";

    if (count($whereQuery['key']) == 0) {
        $countRotate360Image = $wpdb->get_var("SELECT count(id) FROM {$tableName}");
        return $countRotate360Image;
    }

    $whereQueryKey = implode("", $whereQuery['key']);
    $countRotate360Image = $wpdb->get_var($wpdb->prepare("SELECT count(id) FROM $tableName WHERE 1 {$whereQueryKey}", ...$whereQuery['value']));

    return $countRotate360Image;
}

function rotaGetImage360Rotate($offset, $limit, $whereQuery)
{
    global $wpdb;
    $tableName = $wpdb->prefix . "rota_rotates";

    if (count($whereQuery['key']) == 0) {

        $imagesRotate360 = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $tableName LIMIT %d OFFSET %d", $limit, $offset)
        );
        $imagesRotate360 = array_reverse($imagesRotate360);
        return $imagesRotate360;
    }

    $whereQueryKey = implode("", $whereQuery['key']);
    $parameters =  array_merge($whereQuery['value'], array($limit, $offset));
    $rotate360Image = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE 1 {$whereQueryKey} LIMIT %d OFFSET %d ", ...$parameters));

    return $rotate360Image;
}


function rotaAboutUs()
{
    require_once ROTA_DIR . "template/menu-admin/about-us.php";
}
