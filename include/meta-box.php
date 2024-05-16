<?php
if (!defined('ABSPATH')) exit;

if (rotaWoocommercePluginIsActive()) {
    add_action('add_meta_boxes', 'rotaAddMetaBoxRotate360Images');
    add_action('woocommerce_new_product', 'rotaSaveRotate360ImagesIDForProductWoocommerce');
    add_action('woocommerce_update_product', 'rotaSaveRotate360ImagesIDForProductWoocommerce');
}

function rotaSaveRotate360ImagesIDForProductWoocommerce($product_id)
{
    update_post_meta(
        $product_id,
        'rota-rotate-360-image-product-woocommerce',
        sanitize_text_field($_POST['rota-rotate-360-images-id'])
    );
}

function rotaAddMetaBoxRotate360Images()
{
    add_meta_box(
        'rotaMetaBoxRotate360Images',
        "چرخش ۳۶۰ درجه",
        'rotaMetaBoxRotate360Images',
        'product',
        'side',
        'default'
    );
}

function rotaMetaBoxRotate360Images()
{
    global $post;
    $product_id = $post->ID;

    wp_enqueue_style('rota-style.css', ROTA_ASSETS_DASHBOARD_URL . '/css/select2.min.css', false, '1.0.0');
    wp_enqueue_script('rota-add-image-rotate.js', ROTA_ASSETS_DASHBOARD_URL . '/js/select2.min.js', array('jquery'), '', true);

    $allRotate = array_reverse(rotaGetAllRotate());

    $rotate360ImageID = get_post_meta($product_id, 'rota-rotate-360-image-product-woocommerce');
    if ($rotate360ImageID) {
        $rotate360ImageID = $rotate360ImageID[0];
    }

    include ROTA_DIR . "template/meta-box/woocommerce-edit-product-panel-admin-rotate-360-images.php";
}
