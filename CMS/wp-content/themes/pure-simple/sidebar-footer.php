<?php
/**
 * Footer sidebar at the bottom of the page 
 * @package Pure_and_Simple
 * @since 1.0.0
 */


if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}
?>

<aside class="widget-area" role="complementary">
    <div class="container">
      <div id="footer-content" class="row">
        <div class="col-md-12">
          <?php dynamic_sidebar( 'footer' ); ?>
        </div>
      </div>
    </div>
</aside>