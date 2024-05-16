<?php
if (!defined('ABSPATH')) exit;
/**
 * Plugin Name:         rotate-360-image
 * Author:              Team Hilite
 * Description:         چرخش ۳۶۰ درجه عکس با زوایای مختلف
 * Version:             1.0.0
 * Tested up to:        6.5.2
 * Requires at least:   5.0
 * Author URI:          https://profiles.wordpress.org/mohsen1995/
 * License:             GPLv3
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.html
 */
require_once plugin_dir_path(__FILE__) . 'init.php';

add_action('activated_plugin', function ($plugin) {
    if ($plugin != plugin_basename(__FILE__)) {
        return;
    }

    rotaInitDB();
    exit(wp_redirect(admin_url('/admin.php?page=rota-about-us')));
});