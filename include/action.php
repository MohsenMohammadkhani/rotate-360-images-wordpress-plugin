<?php
if (!defined('ABSPATH')) exit;

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('rota-style.css', ROTA_ASSETS_DASHBOARD_URL . '/css/style.css', false, '1.0.0');
    wp_enqueue_script('rota-main.js', ROTA_ASSETS_DASHBOARD_URL . '/js/main.js', array('jquery'), '', true);
    wp_enqueue_script('rota-pagination.js', ROTA_ASSETS_DASHBOARD_URL . '/js/pagination.js', array('jquery'), '', true);
});

add_action('admin_enqueue_scripts', function () {
    if (is_admin())
        wp_enqueue_media();
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('rota-style', ROTA_ASSETS_SITE_URL . "/css/style.css");

    wp_enqueue_script('rota-rotate-360-image', ROTA_ASSETS_SITE_URL . "/js/rotate-360-image.js", array('jquery', 'rota-jquery-touch-swipe'));
    wp_enqueue_script('rota-jquery-touch-swipe', ROTA_ASSETS_SITE_URL . "/js/jquery-touch-swipe.min.js", array('jquery'));
});

add_shortcode('rota_rotate_360_images', "rotaRotate360ImagesShortcodeCallback");
function rotaRotate360ImagesShortcodeCallback($attributes)
{
    if (!isset($attributes['id'])) {
        return;
    }
    $rotateImagesID = $attributes['id'];
    if (!is_numeric($rotateImagesID)) {
        return;
    }

    return ("<div class='rota-rotate-360-image' id='rota-rotate-360-image-$rotateImagesID'>
  <img class='images'  />
  <div class='preload-images'></div>
</div>");

}

if (rotaWoocommercePluginIsActive()) {
    add_action("woocommerce_product_thumbnails", function () {
        global $product;
        $rotate360ImageID = get_post_meta($product->get_id(), "rota-rotate-360-image-product-woocommerce");
        if (!$rotate360ImageID) {
            return;
        }
        $rotate360ImageID = $rotate360ImageID[0];
        ?>
        <div class='rota-rotate-360-image rota-rotate-360-image-woocommerce-single-product'
             id='rota-rotate-360-image-<?php echo esc_attr($rotate360ImageID) ?>'>
            <img class='images'/>
            <div class='preload-images'></div>
        </div>
        <?php
    });
}