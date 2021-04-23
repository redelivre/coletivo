<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */

get_header();
?>

	<div id="content" class="site-content">

		<div class="page-header">
			<div class="container">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</div><!-- container -->
		</div><!-- page-header -->

		<?php
		if ( function_exists( 'coletivo_breadcrumb' ) ) {
			echo coletivo_breadcrumb();
		}
		?>

		<div id="content-inside" class="container">
			<main id="main" class="site-main" role="main">

				<?php
				if ( have_posts() ) {

					while ( have_posts() ) {
						the_post();

						/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
						get_template_part( 'template-parts/content', 'list' );

					}

					the_posts_navigation();

				} else {

					get_template_part( 'template-parts/content', 'none' );

				}
				?>

			</main><!-- #main -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
