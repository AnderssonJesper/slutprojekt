<?php
require_once("settings.php");

function baseTheme_enqueue()
{
    $theme_directory = get_template_directory_uri();
    wp_enqueue_style("myStyle", $theme_directory . "/style.css");
    wp_enqueue_script("app", $theme_directory . "/app.js");
    
   
    
    wp_localize_script("app", "myVariables","");
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