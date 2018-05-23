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

	<?php if ( has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true ) ) : ?>
		<div class="page-fullheader">
			<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php the_title(); ?>">
		</div><!-- .page-fullheader -->
	<?php endif; ?>
	
	<div class="page-header">
		<div class="container">
			<header class="entry-header">
				<div class="col-sm-9">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<div class="entry-meta">
						<?php coletivo_posted_on(); ?>
					</div><!-- .entry-meta -->	
				</div>
				<div class="col-sm-3">
					<div class="nav-previous nav-links">
						<?php previous_post_link( '%link', __( '<i class="fa fa-caret-left" aria-hidden="true"></i> Previous', 'coletivo' ) ); ?>
					</div>
					<div class="nav-next nav-links">
						<?php next_post_link( '%link', __( 'Next <i class="fa fa-caret-right" aria-hidden="true"></i>', 'coletivo' ) ); ?>
					</div>
				</div>
			</header><!-- .entry-header -->
		</div><!-- .container -->
	</div><!-- .page-header -->

	<div id="content-inside" class="container right-sidebar">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'single' );
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar( 'sidebar-1' ); ?>

	</div><!-- #content-inside -->

</div><!-- #content -->

<?php get_footer();