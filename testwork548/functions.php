<?php

// Add WP Scripts
add_action('wp_enqueue_scripts', 'testwork548_scripts');

function testwork548_scripts()
{
    wp_enqueue_style('testwork548-css', get_stylesheet_uri());

    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.6.0.min.js', false, false, true);
        wp_enqueue_script('jquery');
    }

    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

    wp_enqueue_script('testwork548-scripts', get_template_directory_uri() . '/js/scripts-wp.js', array('jquery'), null, true);
}


// Woo Support
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    function ark_add_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }

    add_action('after_setup_theme', 'ark_add_woocommerce_support');
}


// Add Admin Scripts
add_action('admin_enqueue_scripts', 'testwork548_admin_scripts');

function testwork548_admin_scripts()
{
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_script('myuploadscript', get_stylesheet_directory_uri() . '/js/scripts-admin.js', array('jquery'), null, false);

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);
}


/* MetaBox */

// Register Metaboxes
add_action('add_meta_boxes', 'arkanzas_meta_boxes');

function arkanzas_meta_boxes()
{
    add_meta_box('ark-div', 'Дополнительные поля для testwork548', 'arkanzas_show_metaboxes', 'product', 'normal', 'high');
}

function arkanzas_show_metaboxes($post)
{
    if (function_exists('product_custom_img_meta_box')) {
        product_custom_img_meta_box(array(
            'name' => 'product_custom_img',
            'value' => get_post_meta($post->ID, 'product_custom_img', true),
        ));
    }
    if (function_exists('product_date_meta_box')) {
        product_date_meta_box(array(
            'name' => 'product_date',
            'value' => get_post_meta($post->ID, 'product_date', true),
        ));
    }
    if (function_exists('product_select_meta_box')) {
        product_select_meta_box(array(
            'name' => 'product_select',
            'value' => get_post_meta($post->ID, 'product_select', true),
        ));
    }
}


// Save Metaboxes Data
add_action('save_post', 'arkanzas_save_metaboxes_data');
function arkanzas_save_metaboxes_data($post_id)
{

    if (isset($_POST['product_custom_img'])) {
        update_post_meta($post_id, 'product_custom_img', absint($_POST['product_custom_img']));
    }
    if (isset($_POST['product_date'])) {
        update_post_meta($post_id, 'product_date', $_POST['product_date']);
    }
    if (isset($_POST['product_select'])) {
        update_post_meta($post_id, 'product_select', $_POST['product_select']);
    }
    return $post_id;
}


// Metaboxes Content
function product_custom_img_meta_box($args)
{
    $value = $args['value'];
    $default = get_stylesheet_directory_uri() . '/img/camera.png';

    if ($value && ($image_attributes = wp_get_attachment_image_src($value, array(150, 110)))) {
        $src = $image_attributes[0];
    } else {
        $src = $default;
    } ?>
    <div>
        <img data-src="<?php echo $default ?>" src="<?php echo $src ?>" width="50" />
        <div>
            <input type="hidden" name="<?php echo $args['name'] ?>" id="<?php echo  $args['name'] ?>" value="<?php echo $args['value']; ?>" />
            <button type="submit" class="upload_image_button button">Выбрать</button>
            <button type="submit" class="remove_image_button button">×</button>
        </div>
    </div>
<?php }


function product_date_meta_box($args)
{ ?>
    <table>
        <tr>
            <td>Продукт был создан:</td>
            <td>
                <input type="text" name="<?php echo $args['name']; ?>" id="<?php echo $args['name']; ?>" value="<?php echo $args['value']; ?>" />
            </td>
        </tr>
    </table>
<?php
}


function product_select_meta_box($args)
{ ?>
    <span>Тип продукта:</span>
    <select id="product-select" name="<?php echo $args['name']; ?>">
        <option <?php if ($args['value'] == 'rare') : ?>selected<?php endif; ?> value="rare">rare</option>
        <option <?php if ($args['value'] == 'frequent') : ?>selected<?php endif; ?> value="frequent">frequent</option>
        <option <?php if ($args['value'] == 'unusual') : ?>selected<?php endif; ?> value="unusual">unusual</option>
    </select>
    <br>
    <br>
    <button id="product-reset-btn" style="padding: 15px 50px; color: #fff; background: red; font-size: 20px; font-weight: bold;">Сбросить все значения</button>
    <br>
    <br>
    <button id="product-update-btn" style="padding: 15px 50px; color: #fff; background: green; font-size: 20px; font-weight: bold;" onclick="<?php wp_update_post($post->ID); ?>">Обновить запись</button>
<?php }


// Image Through POST
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    if ($_FILES) {
        $files = $_FILES["new-product-img"];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key],
                );
                $_FILES = array("new-product-img" => $file);
                foreach ($_FILES as $file => $array) {
                    $newupload = arkanzas_handle_attachment($file, $pid);
                }
            }
        }
    }
}

function arkanzas_handle_attachment($file_handler, $post_id, $set_thumb = false)
{
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload($file_handler, $post_id);

    return $attach_id;
}


// Create New Products
if (isset($_POST["new-product-name"])) {
    $wordpress_page = array(
        'post_title'    => $_POST["new-product-name"],
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'product',
        'meta_input'    => ['product_date' => $_POST["new-product-date"], 'product_select' => $_POST["new-product-select"], 'product_custom_img' => $newupload],
    );
    $post_ID = wp_insert_post($wordpress_page);
    set_post_thumbnail($post_ID, $newupload);

    $product = new WC_Product($post_ID);
    $product->set_price($_POST["new-product-price"]);
    $product->set_regular_price($_POST["new-product-price"]);
    $product->save();
}


// Register Menu
register_nav_menus(
    array(
        'header-menu' => esc_html__('header-menu', 'testwork548'),
    )
);
