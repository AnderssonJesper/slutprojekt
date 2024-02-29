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


add_filter('woocommerce_get_breadcrumb', 'remove_first_breadcrumb', 10, 2);

function remove_first_breadcrumb($crumbs, $breadcrumb)
{
    array_shift($crumbs);
    return $crumbs;
}

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

add_action('woocommerce_single_product_summary', 'add_not_available_text', 25);
function add_not_available_text()
{
    echo '<div class="not-available">';
    echo '<img src="http://slutprojekt.test/wp-content/uploads/2024/02/pin.png">';
    echo '<span class="text">Not available in stores</span>';
    echo '</div>';
}

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'custom_dropdown_options_args', 10, 1);
function custom_dropdown_options_args($args)
{
    $args['show_option_none'] = __('Select size', 'woocommerce');
    return $args;
}

add_filter('woocommerce_product_single_add_to_cart_text', 'change_add_to_cart_button_text');

function change_add_to_cart_button_text($text)
{
    return __('ADD TO SHOPPING BAG', 'woocommerce');
}

//CART


add_filter('gettext', 'change_subtotal_to_order_value', 20, 3);
function change_subtotal_to_order_value($translated_text, $text, $domain)
{
    if ($text === 'Subtotal') {
        $translated_text = __('Order Value:', 'woocommerce');
    }
    return $translated_text;
}

add_filter('gettext', 'change_shipping_label', 20, 3);
function change_shipping_label($translated_text, $text, $domain)
{
    if ($text === 'Shipping') {
        $translated_text = __('Shipping:', 'woocommerce');
    }
    return $translated_text;
}

add_filter('gettext', 'change_proceed_to_checkout_text', 20, 3);
function change_proceed_to_checkout_text($translated_text, $text, $domain)
{
    if ($text === 'Proceed to checkout') {
        $translated_text = __('CONTINUE TO CHECKOUT', 'woocommerce');
    }
    return $translated_text;
}






/// HOMEPAGE

function custom_theme_customize_register($wp_customize)
{
    $wp_customize->add_section('homepage_settings', array(
        'title'    => __('Homepage inställningar', 'textdomain'),
        'priority' => 120,
    ));

    //Ikon 1

    $wp_customize->add_setting('icon_image_1', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'icon_image_1', array(
        'label'    => __('Bild för ikon 1', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'icon_image_1',
    )));

    
    $wp_customize->add_setting('icon_text_1', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('icon_text_1', array(
        'label'    => __('Text för ikon 1', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));


    // Ikon 2
    $wp_customize->add_setting('icon_image_2', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'icon_image_2', array(
        'label'    => __('Bild för ikon 2', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'icon_image_2',
    )));

    
    $wp_customize->add_setting('icon_text_2', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('icon_text_2', array(
        'label'    => __('Text för ikon 2', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // Ikon 3
    
    $wp_customize->add_setting('icon_image_3', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'icon_image_3', array(
        'label'    => __('Bild för ikon 3', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'icon_image_3',
    )));

   
    $wp_customize->add_setting('icon_text_3', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('icon_text_3', array(
        'label'    => __('Text för ikon 3', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

   

    // Banner

    $wp_customize->add_setting('banner_heading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banner_heading', array(
        'label'    => __('Banner Rubrik', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('banner_subheading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banner_subheading', array(
        'label'    => __('Banner Subheading', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('banner_background_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_background_image', array(
        'label'    => __('Banner Bakgrundsbild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'banner_background_image',
    )));

    $wp_customize->add_setting('banner_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banner_button_text', array(
        'label'    => __('Banner Knapp Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // Kolumner under Banner

    $wp_customize->add_setting('left_column_heading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('left_column_heading', array(
        'label'    => __('Vänster Kolumn Rubrik', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('left_column_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'left_column_image', array(
        'label'    => __('Vänster Kolumn Bild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'left_column_image',
    )));

    $wp_customize->add_setting('left_column_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('left_column_button_text', array(
        'label'    => __('Vänster Kolumn Knapp Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // Höger kolumn inställningar
    $wp_customize->add_setting('right_column_heading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('right_column_heading', array(
        'label'    => __('Höger Kolumn Rubrik', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('right_column_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'right_column_image', array(
        'label'    => __('Höger Kolumn Bild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'right_column_image',
    )));

    $wp_customize->add_setting('right_column_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('right_column_button_text', array(
        'label'    => __('Höger Kolumn Knapp Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // Produkt bilder 1

    $wp_customize->add_setting('first_image_background', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'first_image_background', array(
        'label'    => __('Första Bildens Bakgrundsbild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'first_image_background',
    )));

    $wp_customize->add_setting('first_image_heading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('first_image_heading', array(
        'label'    => __('Första Bildens Rubrik', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('first_image_paragraph', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('first_image_paragraph', array(
        'label'    => __('Första Bildens Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('first_image_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('first_image_button_text', array(
        'label'    => __('Första Bildens Knapp Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));


    $wp_customize->add_setting('banner_second_background_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_second_background_image', array(
        'label'    => __('Banner Bakgrundsbild - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'settings' => 'banner_second_background_image',
    )));

    // Product 1

    // Hämta 6 produkter från kategorin "Decor"
   

    






    // Banner-second

    $wp_customize->add_section('homepage_settings', array(
        'title'    => __('Homepage Settings', 'textdomain'),
        'priority' => 30,
    ));

    $wp_customize->add_section('banner_second_settings', array(
        'title'    => __('Second Banner Settings', 'textdomain'),
        'priority' => 31,
    ));

    $wp_customize->add_setting('banner_second_heading', array(
        'default'   => 'Banner Heading - Second',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('banner_second_heading', array(
        'label'    => __('Banner Heading - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('second_sale_price', array(
        'default'   => '$99.99',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('second_sale_price', array(
        'label'    => __('Sale Price - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('second_regular_price', array(
        'default'   => '$129.99',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('second_regular_price', array(
        'label'    => __('Regular Price - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('banner_second_paragraph', array(
        'default'   => 'Banner Paragraph - Second',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('banner_second_paragraph', array(
        'label'    => __('Banner Paragraph - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('banner_second_button_text', array(
        'default'   => 'Button Text - Second',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('banner_second_button_text', array(
        'label'    => __('Banner Button Text - Second', 'textdomain'),
        'section'  => 'banner_second_settings',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'custom_theme_customize_register');












