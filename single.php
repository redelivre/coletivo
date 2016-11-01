<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package OnePress
 */

get_header(); ?>

	<div id="content" class="site-content">
		<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
			<img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div class="page-header">
	<div class="container">
		<header class="entry-header">
			<div class="col-sm-9">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<?php onepress_posted_on(); ?>
				</div><!-- .entry-meta -->	
			</div>
			<div class="col-sm-3">
			<div class="nav-previous nav-links"><?php previous_post_link( '%link', __( '<i class="fa fa-caret-left" aria-hidden="true"></i> Previous', 'onepress' ) ); ?></div>
			<div class="nav-next nav-links"><?php next_post_link( '%link', __( 'Next <i class="fa fa-caret-right" aria-hidden="true"></i>', 'onepress' ) ); ?></div>

			</div>
		</header><!-- .entry-header -->
	</div>
		</div>
		<div id="content-inside" class="container right-sidebar">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
