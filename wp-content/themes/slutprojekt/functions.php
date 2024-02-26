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
    ));
}
add_action('init', 'slutprojekt_register_menus');

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
}
add_action('customize_register', 'theme_customize_register');
