<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */

$blog_style = get_theme_mod( 'coletivo_blog_page_style', 'grid' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( coletivo_get_blog_post_class() ); ?>>
	<?php if ( 'list' === $blog_style ) { ?>
		<div class="list-article-content">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->
		</div>
	<?php } ?>
	<?php if ( has_post_thumbnail() ) { ?>
	<div class="list-article-thumb">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			if ( 'list' === $blog_style ) {
				the_post_thumbnail( 'large' );
			} else {
				the_post_thumbnail( 'coletivo-blog-small' );
			}
			?>
		</a>
	</div>
	<?php } ?>
	<div class="list-article-content">
		<div class="list-article-meta">
			<?php the_category( '/' ); ?>
		</div>
		<?php if ( 'list' !== $blog_style ) { ?>
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->
		<?php } ?>
		<div class="entry-excerpt">
			<?php
			if ( 'list' === $blog_style ) {
				the_content();
			} else {
				the_excerpt();
			}
			?>
			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'coletivo' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
	</div>

</article><!-- #post-## -->
