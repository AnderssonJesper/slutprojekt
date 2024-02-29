<?php
/*
 * Template Name: Homepage
 */
get_header();
?>

<head>

    <title><?php the_title(); ?></title>
</head>

<body>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            while (have_posts()) :
                the_post();

            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="top-icons">
                        <div class="icon-box">
                            <img src="<?php echo get_theme_mod('icon_image_1', 'http://slutprojekt.test/wp-content/uploads/2024/02/Delivery.png'); ?>" alt="Icon 1">
                            <p><?php echo esc_html(get_theme_mod('icon_text_1', 'Icon 1 Text')); ?></p>
                        </div>
                        <div class="icon-box">
                            <img src="<?php echo get_theme_mod('icon_image_2', 'url_to_icon_image_2'); ?>" alt="Icon 2">
                            <p><?php echo esc_html(get_theme_mod('icon_text_2', 'Icon 2 Text')); ?></p>
                        </div>
                        <div class="icon-box">
                            <img src="<?php echo get_theme_mod('icon_image_3', 'url_to_icon_image_3'); ?>" alt="Icon 3">
                            <p><?php echo esc_html(get_theme_mod('icon_text_3', 'Icon 3 Text')); ?></p>
                        </div>
                    </div>

                    <div class="banner" style="background-image: url('<?php echo esc_url(get_theme_mod('banner_background_image', 'url_to_default_background_image')); ?>');">
                        <div class="head-banner">
                            <h1><?php echo get_theme_mod('banner_heading', 'Banner Heading'); ?></h1>
                            <h2><?php echo get_theme_mod('banner_subheading', 'Banner Subheading'); ?></h2>
                            <button><?php echo get_theme_mod('banner_button_text', 'Button Text'); ?></button>
                        </div>
                    </div>


                    <div class="two-column-layout">
                        <div class="left-column">
                            <h2><?php echo get_theme_mod('left_column_heading', 'Left Column Heading'); ?></h2>
                            <button><?php echo get_theme_mod('left_column_button_text', 'Button Text'); ?></button>
                            <img src="<?php echo get_theme_mod('left_column_image', 'url_to_left_column_image'); ?>" alt="Left Column Image">

                        </div>
                        <div class="right-column">
                            <h2><?php echo get_theme_mod('right_column_heading', 'Right Column Heading'); ?></h2>
                            <button><?php echo get_theme_mod('right_column_button_text', 'Button Text'); ?></button>
                            <img src="<?php echo get_theme_mod('right_column_image', 'url_to_right_column_image'); ?>" alt="Right Column Image">

                        </div>
                    </div>

                    


                    <div class="image-container">
                        <div class="first-image">
                            <img src="<?php echo esc_url(get_theme_mod('first_image_background', 'url_to_first_image_background')); ?>" alt="First Image">
                            <div class="image-content">
                                <h1><?php echo get_theme_mod('first_image_heading', 'First Image Heading'); ?></h1>
                                <p><?php echo get_theme_mod('first_image_paragraph', 'First Image Paragraph'); ?></p>
                                <button><?php echo get_theme_mod('first_image_button_text', 'Button Text'); ?></button>

                            </div>

                        </div>

                    </div>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>







                    <div class="banner-second" style="background-image: url('<?php echo esc_url(get_theme_mod('banner_second_background_image', 'url_to_banner_background_image')); ?>');">
                        <div class="banner-content">
                            <h1><?php echo esc_html(get_theme_mod('banner_second_heading', 'Banner Heading - Second')); ?></h1>
                            <div class="price">
                                <span class="sale-price"><?php echo esc_html(get_theme_mod('second_sale_price', '$99.99')); ?></span>
                                <span class="regular-price"><?php echo esc_html(get_theme_mod('second_regular_price', '$129.99')); ?></span>
                            </div>
                            <p><?php echo esc_html(get_theme_mod('banner_second_paragraph', 'Banner Paragraph - Second')); ?></p>
                            <button><?php echo esc_html(get_theme_mod('banner_second_button_text', 'Button Text - Second')); ?></button>
                        </div>
                    </div>





                    <?php if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif; ?>
                </article>
            <?php endwhile; ?>
        </main>
    </div>

    <?php get_footer(); ?>
</body>

</html>