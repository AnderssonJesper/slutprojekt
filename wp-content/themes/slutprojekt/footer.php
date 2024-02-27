<footer>
    <div class="footer-content">
        <div class="footer-column footer-column-1">
            <h2>URBAN OUTFITTERS</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
            <div class="footer-links">
                <a href="#link1">121 king street, Melbourne 3000</a>
            </div>
            <div class="footer-links">
                <a href="#link2">+61 3 8376 6284</a>
            </div>
            <div class="footer-links">
                <a href="#link3">contact@urbanoutfitters.com</a>
            </div>
            <div class="footer-icons">
                <img src="http://slutprojekt.test/wp-content/uploads/2024/02/Vector-1.png" alt="Icon 1">
                <img src="http://slutprojekt.test/wp-content/uploads/2024/02/vaadin_youtube.png" alt="Icon 2">
                <img src="http://slutprojekt.test/wp-content/uploads/2024/02/ant-design_instagram-filled.png" alt="Icon 3">
                <img src="http://slutprojekt.test/wp-content/uploads/2024/02/ant-design_twitter-outlined.png" alt="Icon 4">
            </div>
        </div>
        <div class="footer-column footer-column-2">
            <h2>Shopping</h2>
            <?php
            $menu_args = array(
                'menu'            => 'Shopping',
                'menu_id'         => 'shopping-menu',
                'container'       => 'nav',
                'container_class' => 'menu',
            );
            wp_nav_menu($menu_args);
            ?>
        </div>
        <div class="footer-column footer-column-3">
            <h2>More Link</h2>
            <?php
            $menu_args = array(
                'menu'            => 'More link',
                'menu_id'         => 'more-link-menu',
                'container'       => 'nav',
                'container_class' => 'menu',
            );
            wp_nav_menu($menu_args);
            ?>
        </div>
        <div class="footer-column footer-column-4">
            <h2>From the blog</h2>
            <?php
            // Skapa en ny WP_Query för att hämta de senaste två inläggen
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 2, // Antal inlägg att visa
            );
            $query = new WP_Query($args);

            // Loopa igenom inläggen
            if ($query->have_posts()) :
                echo '<ul>'; // Öppna en lista för att visa inläggen
                while ($query->have_posts()) : $query->the_post();
            ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php
                endwhile;
                echo '</ul>'; // Stäng listan
                wp_reset_postdata(); // Återställ postdata
            else :
                // Om inga inlägg hittades
                echo 'Inga inlägg hittades.';
            endif;
            ?>
        </div>
    </div>
    <div class="footer-rights">
        <p>Urban Outfitters © – All rights reserved</p>
    </div>
</footer>