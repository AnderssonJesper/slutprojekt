<?php
function init_ajax()
{
add_action("wp_ajax_slutprojekt_getbyajax", "slutprojekt_getbyajax");

add_action("wp_ajax_nopriv_slutprojekt_getbyajax", "slutprojekt_getbyajax");

add_action("wp_enqueue_scripts", "slutprojekt_enqueue_scripts");
}

add_action("init", "init_ajax");

function slutprojekt_enqueue_scripts()
{
wp_enqueue_script("slutprojekt_jquery", get_template_directory_uri() . "/resources/js/jquery.js", array(), false, true);

wp_enqueue_script("slutprojekt_ajax", get_template_directory_uri() . "/resources/js/ajax.js", array("jquery"), false, true);

wp_localize_script("slutprojekt_ajax", "ajax_object", array(
"ajaxUrl" => admin_url("admin-ajax.php"),
"nonce" => wp_create_nonce("slutprojekt_ajax_nonce")
));
}