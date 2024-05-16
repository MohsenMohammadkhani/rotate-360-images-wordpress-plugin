<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {
    require_once ROTA_DIR . "modules-menu/rotate-image.php";
    add_menu_page(
        'چرخش ۳۶۰ درجه عکس',
        'چرخش ۳۶۰ درجه عکس',
        'manage_options',
        'rota-menu-pages',
        'rotaRotateMenuPage',
    );

    add_submenu_page(
        'rota-menu-pages',
        'چرخش ۳۶۰ درجه عکس',
        'چرخش ۳۶۰ درجه عکس',
        'manage_options',
        'rota-menu-pages',
        "rotaRotateMenuPage");

    add_submenu_page(
        'rota-menu-pages',
        'درباره ما',
        'درباره ما',
        'manage_options',
        'rota-about-us',
        "rotaAboutUs");
});