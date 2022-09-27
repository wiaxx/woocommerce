<?php

$site_title = get_bloginfo('name');
$site_url = network_site_url();
?>

<header>
    <?php
    wp_nav_menu(array('theme-location' => 'main-menu'));
    ?>
</header>