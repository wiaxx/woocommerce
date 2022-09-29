<?php
$site_title = get_bloginfo('name');
$site_url = network_site_url();
?>

<header>

    <?php
    wp_nav_menu(array('theme_location' => 'main-menu'));
    ?>

    <a href="<?php echo $site_url ?>">
        <h2 class="header-title">
            <?php echo $site_title; ?>
        </h2>
    </a>

    <div class="header-account">
        <?php if (is_user_logged_in()) { ?>
            <a href="<?php echo $site_url . '/my-account' ?>">
                My account
            </a>
        <?php } else { ?>
            <a href="<?php echo $site_url . '/my-account' ?>">
                Log in
            </a>
        <?php } ?>
    </div>

    <div class="header-icons">
        <a href="<?php echo $site_url . '/cart' ?>">cart icon</a>
        <a href="<?php echo $site_url . '/search' ?>">search icon</a>
    </div>

</header>