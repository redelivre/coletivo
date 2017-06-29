<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package coletivo
 */

get_header(); ?>

	<div id="content" class="site-content">
		<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
			<img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div id="content-inside" class="container no-sidebar">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

			<div class="container">
				<?php the_title( '<h2 class="fullheader-title">', '</h2>' ); ?>
				<div class="nav-links">
					<div class="col-sm-6">
					<div class="nav-previous"><?php previous_post_link( '%link', __( '<i class="fa fa-caret-left" aria-hidden="true"></i> Previous', 'coletivo' ) ); ?></div>
					</div>
					<div class="col-sm-6">
					<div class="nav-next"><?php next_post_link( '%link', __( 'Next <i class="fa fa-caret-right" aria-hidden="true"></i>', 'coletivo' ) ); ?></div>
					</div>
				</div>
			</div>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
