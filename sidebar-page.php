<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

if ( ! is_active_sidebar( 'sidebar-page' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-page' ); ?>
</div><!-- #secondary -->
