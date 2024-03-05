<?php
require_once("settings.php");

function baseTheme_enqueue()
{
    $theme_directory = get_template_directory_uri();
    wp_enqueue_style("myStyle", $theme_directory . "/style.css");
    wp_enqueue_script('mytheme-ajax', get_template_directory_uri() . '/resources/js/app.js', array('jquery'), null, true);

   
    wp_localize_script('mytheme-ajax', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('ajax_nonce')
    ));
}


add_action('wp_enqueue_scripts', 'baseTheme_enqueue');

function baseTheme_init()
{
    $menu = array(
        'huvudmeny' => 'Huvudmeny',
        'header_information' => 'header_information',
        'footer_information' => 'footer_information',
    );

    register_nav_menus($menu);
}

add_action('after_setup_theme', 'baseTheme_init');