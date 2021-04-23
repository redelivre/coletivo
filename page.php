<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Coletivo
 */

get_header()
?>

<div id="content" class="site-content">

	<?php if ( has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true ) ) { ?>
		<div class="page-fullheader">
			<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php the_title(); ?>">
		</div><!-- .page-fullheader -->
	<?php } ?>

	<div id="content-inside" class="container no-sidebar">

		<?php the_title( '<h2 class="fullheader-title">', '</h2>' ); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				} // End of the loop.
				?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!--#content-inside -->

</div><!-- #content -->

<?php get_footer(); ?>
