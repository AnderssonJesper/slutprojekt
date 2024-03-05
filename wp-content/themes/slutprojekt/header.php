<html>


<head>


    <?php wp_head() ?>
</head>

<body>
    <?php wp_body_open(); ?>

    <header class="header">
        <div class="header1">
            <h1><?php echo esc_html(get_theme_mod('header_title', 'Default Header Title')); ?></h1>

            <?php

            $menu = array(
                'theme_location' => 'header-icon',
                'menu_id' => 'header-Icon',
                'container' => 'nav',
                'container_class' => 'menu'
            );

            wp_nav_menu($menu);
            ?>
        </div>

        <div class="header2">
            <?php
            $menu = array(
                'theme_location' => 'huvudmeny',
                'menu_id' => 'primary-menu',
                'container' => 'nav',
                'container_class' => 'menu'
            );

            wp_nav_menu($menu);
            ?>
        </div>


    </header>

</html>