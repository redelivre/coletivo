<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package coletivo
 */

get_header(); ?>
	<div id="content" class="site-content">
		<div id="content-inside" class="container no-sidebar">
				<h1 class="fullheader-title">404</h1>
				<h2 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'coletivo' ); ?></h2>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<section class="error-404 not-found">

						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'coletivo' ); ?></p>

							<?php get_search_form(); ?>

							<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

							<?php if ( coletivo_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
								<div class="widget widget_categories">
									<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'coletivo' ); ?></h2>
									<ul>
									<?php
										wp_list_categories( array(
											'orderby'    => 'count',
											'order'      => 'DESC',
											'show_count' => 1,
											'title_li'   => '',
											'number'     => 3,
										) );
									?>
									</ul>
								</div><!-- .widget -->
							<?php endif; ?>

							<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->

		</div><!--#content-inside -->
	</div><!-- #content -->
	
<?php get_footer(); ?>