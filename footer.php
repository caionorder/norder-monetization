<footer id="footer" role="contentinfo">
    <div class="container">
        <div class="footer-widgets">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
            <?php endif; ?>
        </div>

        <nav class="footer-navigation" role="navigation" aria-label="Menu do rodapé">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu',
                'depth'          => 1,
                'fallback_cb'    => false,
            ));
            ?>
        </nav>

        <div class="site-info">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos os direitos reservados.</p>
            <?php
            if (function_exists('the_privacy_policy_link')) {
                the_privacy_policy_link('<p>', '</p>');
            }
            ?>
        </div>

    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
