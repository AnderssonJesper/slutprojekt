<?php
require_once("ajax.php");
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




function mytheme_filter_product_rating($html, $rating, $count)
{
    $max_rating = 5;
    $stars = '';

    $stars .= '<div class="star-rating" role="img" aria-label="' . sprintf(esc_html__('Rated %s out of 5', 'woocommerce'), $rating) . '">';
    $filled_stars = min(5, max(0, round($rating)));
    $stars .= str_repeat('<img src="http://slutprojekt.test/wp-content/uploads/2024/03/star-filled.png" class="filled-star" alt="Filled Star">', $filled_stars);

    $empty_stars = $max_rating - $filled_stars;
    $stars .= str_repeat('<img src="http://slutprojekt.test/wp-content/uploads/2024/03/star-unfilled.png" class="empty-star" alt="Empty Star">', $empty_stars);

    $stars .= '</div>';

    return $stars;
}

add_filter("woocommerce_product_get_rating_html", "mytheme_filter_product_rating", 10, 3);



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



    $wp_customize->add_setting('second_image_background', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'second_image_background', array(
        'label'    => __('Andra Bildens Bakgrundsbild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'second_image_background',
    )));

    $wp_customize->add_setting('second_image_heading', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('second_image_heading', array(
        'label'    => __('Andra Bildens Rubrik', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('second_image_paragraph', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('second_image_paragraph', array(
        'label'    => __('Andra Bildens Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('second_image_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('second_image_button_text', array(
        'label'    => __('Andra Bildens Knapp Text', 'textdomain'),
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


    ///MAIL
    $wp_customize->add_setting('homepage_h1_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('homepage_h1_text', array(
        'label'    => __('H1 Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // P Text
    $wp_customize->add_setting('homepage_p_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('homepage_p_text', array(
        'label'    => __('P Text', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'textarea',
    ));

    // Knappens Bild
    $wp_customize->add_setting('homepage_button_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'homepage_button_image', array(
        'label'    => __('Knappens Bild', 'textdomain'),
        'section'  => 'homepage_settings',
        'settings' => 'homepage_button_image',
    )));

    // Knappens Text
    $wp_customize->add_setting('homepage_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('homepage_email_placeholder', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('homepage_email_placeholder', array(
        'label'    => __('Email Placeholder', 'textdomain'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));


    // Product 1

}
add_action('customize_register', 'custom_theme_customize_register');


function save_newsletter_settings()
{
    if (isset($_POST['newsletter_settings_nonce']) && wp_verify_nonce($_POST['newsletter_settings_nonce'], 'save_newsletter_settings')) {
        update_option('newsletter_h1', $_POST['newsletter_h1']);
        update_option('newsletter_p', $_POST['newsletter_p']);
        update_option('newsletter_button_image', $_POST['newsletter_button_image']);
    }
}

add_action('admin_post_save_newsletter_settings', 'save_newsletter_settings');


// functions.php eller ett plugin-fil

add_action('init', 'remove_woocommerce_result_count');

function remove_woocommerce_result_count()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
}

function custom_bedroom_page_content()
{
    echo '<p class="custom-page-content">Its easy to transform your bedroom interior with our great selection of accessories.</p>';
}

add_action('woocommerce_archive_description', 'custom_bedroom_page_content');



//Shortcode för related products i cart


function custom_related_products_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => 2,
        'left_arrow_image' => 'http://slutprojekt.test/wp-content/uploads/2024/03/left-arrow.png',
        'right_arrow_image' => 'http://slutprojekt.test/wp-content/uploads/2024/03/right-arrow.png',
        'title' => 'Also You May Buy',
    ), $atts, 'custom_related_products');

    $cart_items = WC()->cart->get_cart();
    $related_product_ids = array();

    foreach ($cart_items as $cart_item) {
        $product_id = $cart_item['product_id'];
        $related_products = wc_get_products(array(
            'limit' => intval($atts['limit']),
            'exclude' => array($product_id),
            'orderby' => 'rand',
            'return' => 'ids',
        ));

        $related_product_ids = array_merge($related_product_ids, $related_products);
    }

    $related_product_ids = array_unique($related_product_ids);
    $related_products = wc_get_products(array(
        'include' => $related_product_ids,
    ));

    if (!empty($related_products)) {
        ob_start();
        echo '<div class="related-products">';
        echo '<h2>' . esc_html($atts['title']) . '</h2>';
        echo '<div class="related-products-container">';

        echo '<div class="related-product-arrow-left"><img src="' . esc_url($atts['left_arrow_image']) . '" alt="Left Arrow"></div>';

        foreach ($related_products as $related_product) {
            echo '<div class="related-product">';
            echo '<a href="' . esc_url($related_product->get_permalink()) . '">' . $related_product->get_image() . '</a>';
            echo '<h3>' . $related_product->get_name() . '</h3>';
            if ($related_product->get_rating_count() > 0) {
                echo '<div class="product-rating">' . wc_get_rating_html($related_product->get_average_rating(), $related_product->get_rating_count()) . '</div>';
            } else {
                echo '<div class="product-rating">' . wc_get_rating_html(0, 5) . '</div>';
            }
            echo '<p>' . $related_product->get_price_html() . '</p>';
            echo '</div>';
        }

        echo '<div class="related-product-arrow-right"><img src="' . esc_url($atts['right_arrow_image']) . '" alt="Right Arrow"></div>';

        echo '</div>'; 
        echo '</div>'; 
        return ob_get_clean();
    } else {
        return ''; 
    }
}
add_shortcode('custom_related_products', 'custom_related_products_shortcode');











