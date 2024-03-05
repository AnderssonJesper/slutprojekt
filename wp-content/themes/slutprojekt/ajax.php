<?php
function init_ajax()
{
    add_action("wp_ajax_mytheme_getbyajax", "mytheme_getbyajax");
    add_action("wp_ajax_nopriv_mytheme_getbyajax", "mytheme_getbyajax");

    add_action("wp_enqueue_scripts", "mytheme_enqueue_scripts");
}

add_action("init", "init_ajax");


function mytheme_enqueue_scripts()
{
    wp_enqueue_script("mytheme_jquery", get_template_directory_uri() . "/resources/js/jquery.js", array(), false, array());
    wp_enqueue_script("mytheme_ajax", get_template_directory_uri() . "/resources/js/ajax.js", array("mytheme_jquery"), false, array());

    wp_localize_script("mytheme_ajax", "ajax_variables", array(
        "ajaxUrl" => admin_url("admin-ajax.php"),
        "nonce" => wp_create_nonce("mytheme_ajax_nonce")
    ));
}

function mytheme_getbyajax()
{
   
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
   
    );

    
    $query = new WP_Query($args);

    
    $products = array();

    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
           
            $product_id = get_the_ID();
            $product = wc_get_product($product_id);

           
            $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
            $product_rating = $product->get_average_rating();

         
            $currency_symbol = get_woocommerce_currency_symbol();
            $product_url = get_permalink($product_id);

          
            $products[] = array(
                'name'    => $product->get_name(),
                'price'   => $product->get_price() . ' ' . $currency_symbol,
                'image'   => $product_image[0], 
                'rating'  => $product_rating,
                'product_url' => $product_url, 

            );
        }
    }

    
    wp_send_json($products);
}




