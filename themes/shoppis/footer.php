<!-- 
<div class="footer-wrap">

<h3 class="footer-nav">Navigate</h3>
<div class="nav-links">
<a href="/">Shop</a>
<a href="/about-us">Om oss</a>
<a href="/stores">Våra butiker</a>
<a href="/my-account">Logga in</a>
</div>

<h3 class="footer-info">Information</h3>
<div class="nav-links-2"> 
<a href="/privacy-policy">Privacy Policy</a>
<a href="/terms">Terms & Agreement</a>
<h2 class="logo">SHOPPIS</h2>
</div>

</div>


 -->


 <div class="footer-wrap">

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
