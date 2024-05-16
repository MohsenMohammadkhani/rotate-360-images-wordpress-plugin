<?php
if (!defined('ABSPATH')) exit;
// ROTA =>  rotate 360 images is prefix for all function names and tables
define('ROTA_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('ROTA_URL', trailingslashit(plugin_dir_url(__FILE__)));

define('ROTA_ASSETS_DASHBOARD_URL', trailingslashit(ROTA_URL . '/assets/dashboard'));
define('ROTA_ASSETS_SITE_URL', trailingslashit(ROTA_URL . '/assets/site'));

require_once ROTA_DIR . 'include/function.php';
require_once ROTA_DIR . 'include/menu-admin.php';
require_once ROTA_DIR . 'include/action.php';
require_once ROTA_DIR . 'include/rest-api.php';
require_once ROTA_DIR . 'include/migration.php';
require_once ROTA_DIR . 'include/ajax.php';
require_once ROTA_DIR . 'include/meta-box.php';