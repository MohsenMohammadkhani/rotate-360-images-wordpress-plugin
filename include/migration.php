<?php
if (!defined('ABSPATH')) exit;

function rotaInitDB()
{
    global $table_prefix, $wpdb;
    $prefixTableForThisPlugin = "rota";

    $rotatesTableName = $table_prefix . $prefixTableForThisPlugin . "_" . "rotates";

    if ($wpdb->get_var($wpdb->prepare("show tables like %s", $rotatesTableName)) != $rotatesTableName) {
        roiCreateTableRotatesTableName($rotatesTableName);
    }

    $rotatesImagesTable = $table_prefix . $prefixTableForThisPlugin . "_" . "rotates_images";
    if ($wpdb->get_var($wpdb->prepare("show tables like %s", $rotatesImagesTable)) != $rotatesImagesTable) {
        roiCreateTableRotatesImages($rotatesImagesTable);
    }

}

function roiCreateTableRotatesTableName($tableName)
{
    $sql = "   CREATE TABLE `$tableName` (";
    $sql .= "   `id` mediumint UNSIGNED NOT NULL  PRIMARY KEY AUTO_INCREMENT, ";
    $sql .= "   `title` char(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, ";
    $sql .= "   `background_color` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,  ";
    $sql .= "   `background_color_button` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,  ";
    $sql .= "   `speed` smallint UNSIGNED NOT NULL,  ";
    $sql .= "   `active` tinyint(1) NOT NULL default 1 ,  ";
    $sql .= "   `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP   ";
    $sql .= "    ) ENGINE = InnoDB default CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci; ";

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function roiCreateTableRotatesImages($tableName)
{
    $sql = " CREATE TABLE `$tableName` (";
    $sql .= "  `id` mediumint UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
    $sql .= "  `image_id` mediumint UNSIGNED NOT NULL,  ";
    $sql .= "  `rotate_id` mediumint UNSIGNED NOT NULL  ";
    $sql .= "  ) ENGINE = InnoDB default CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci; ";

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
