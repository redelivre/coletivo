<?php
/**
 * Template Name: With Sidebar
 *
 * @package Coletivo
 */

get_header();
?>

	<div id="content" class="site-content">
		<div class="page-header">
			<div class="container">
				<header class="entry-header">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
			</div>
		</div>
		<?php echo coletivo_breadcrumb(); ?>
		<div id="content-inside" class="container right-sidebar">
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

			<?php get_sidebar( 'page' ); ?>

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
