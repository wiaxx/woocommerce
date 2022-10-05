<div class="footer-wrap">
    <?php wp_footer(); ?>

    <h3 class="footer-nav">Navigate</h3>
    <div class="nav-links">
        <?php wp_nav_menu(array('theme_location' => 'first-footer-menu')); ?>
    </div>

    <h3 class="footer-info">Information</h3>
    <div class="nav-links-2">
        <?php wp_nav_menu(array('theme_location' => 'second-footer-menu')); ?>
        <h2 class="footer-logo">SHOPPIS</h2>
    </div>

</div>

</body>
</html>