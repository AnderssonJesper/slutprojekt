<?php
require_once("vite.php");
require_once("settings.php");

require_once(get_template_directory() . "/init.php");

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


// MENYER

function slutprojekt_register_menus()
{
    register_nav_menus(array(
        'primary-menu' => esc_html__('Primary Menu', 'slutprojekt'),
        'footer-menu'  => esc_html__('Footer Menu', 'slutprojekt'),
        'header-icon'  => esc_html__('Header-Icon', 'slutprojekt'),
        'Shopping'  => esc_html__('Shopping', 'slutprojekt'),
        'More link'  => esc_html__('More link', 'slutprojekt'),
    ));
}
add_action('init', 'slutprojekt_register_menus');


//Wordpress admin inställningar
function theme_customize_register($wp_customize)
{
    $wp_customize->add_section('header_settings', array(
        'title' => __('Header Settings', 'mytheme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('header_title', array(
        'default' => __('Default Header Title', 'mytheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_title', array(
        'label' => __('Header Title', 'mytheme'),
        'section' => 'header_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('banner_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_image', array(
        'label' => __('Banner Image', 'mytheme'),
        'section' => 'header_settings',
        'settings' => 'banner_image',
    )));

    $wp_customize->add_setting('h1_text', array(
        'default' => __('Default H1 Text', 'mytheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('h1_text', array(
        'label' => __('H1 Text', 'mytheme'),
        'section' => 'header_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('h2_text', array(
        'default' => __('Default H2 Text', 'mytheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('h2_text', array(
        'label' => __('H2 Text', 'mytheme'),
        'section' => 'header_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('p_text', array(
        'default' => __('Default P Text', 'mytheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('p_text', array(
        'label' => __('P Text', 'mytheme'),
        'section' => 'header_settings',
        'type' => 'text',
    ));
    
}
add_action('customize_register', 'theme_customize_register');


//Produkt sida
add_filter('gettext', 'change_related_products_text', 20, 3);
function change_related_products_text($translated_text, $text, $domain)
{
    if ($text === 'Related products') {
        $translated_text = __('Also You May Like', 'woocommerce');
    }
    return $translated_text;
}

add_action('woocommerce_single_product_summary', 'add_miniature_image_after_short_description', 25);
function add_miniature_image_after_short_description()
{
    global $product;

    if (has_post_thumbnail($product->get_id())) {
        $thumbnail_url = get_the_post_thumbnail_url($product->get_id(), 'thumbnail');
        echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '" class="miniature-image" />';
    }
}





