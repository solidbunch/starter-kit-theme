<?php

defined('ABSPATH') || exit;

?>
<footer class="footer py-4">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <p class="mb-0">
                    &copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?>
                </p>
            </div>
            <div class="col-auto">
                <?php
                wp_nav_menu([
                    'theme_location' => 'bottom_menu',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav flex-row',
                    'fallback_cb'    => false,
                ]);
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
