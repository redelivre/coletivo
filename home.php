<?php
$onepress_news_id        = get_theme_mod( 'onepress_news_id', esc_html__('news', 'onepress') );
$onepress_news_title     = get_theme_mod( 'onepress_news_title', esc_html__('Latest News', 'onepress' ));
$onepress_news_subtitle  = get_theme_mod( 'onepress_news_subtitle', esc_html__('Section subtitle', 'onepress' ));

if ( onepress_is_selective_refresh() ) {
    $onepress_news_disable = false;
}
?>
<?php
/**
 * The front page template file.
 *
 * The front-page.php template file is used to render your site’s front page,
 * whether the front page displays the blog posts index (mentioned above) or a static page.
 * The front page template takes precedence over the blog posts index (home.php) template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package OnePress
 */

get_header(); ?>
	<div id="content" class="site-content">
	    <div class="news-header">
	   		<div class="container">
			    <?php if ( $onepress_news_title != '' ) echo '<h2 class="news-large-text">' . esc_html( $onepress_news_title ) . '</h2>'; ?>
			    <?php if ( $onepress_news_subtitle != '' ) echo '<h4 class="news-subtitle">' . esc_html( $onepress_news_subtitle ) . '</h4>'; ?>
			</div>
	    </div>
		<?php echo onepress_breadcrumb(); ?>

		<div id="content-inside" class="container">
			<div class="content-area">
				<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php the_posts_navigation(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

				</main><!-- #main -->

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
