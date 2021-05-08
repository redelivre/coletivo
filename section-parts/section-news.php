<?php
/**
 * Section News
 *
 * @package coletivo
 */

$coletivo_news_id        = get_theme_mod( 'coletivo_news_id', esc_html__( 'news', 'coletivo' ) );
$coletivo_news_disable   = get_theme_mod( 'coletivo_news_disable' ) === 1 ? true : false;
$coletivo_news_title     = get_theme_mod( 'coletivo_news_title', esc_html__( 'Latest News', 'coletivo' ) );
$coletivo_news_subtitle  = get_theme_mod( 'coletivo_news_subtitle', esc_html__( 'Section subtitle', 'coletivo' ) );
$coletivo_news_number    = get_theme_mod( 'coletivo_news_number', '3' );
$coletivo_news_more_link = get_theme_mod( 'coletivo_news_more_link', '#' );
$coletivo_news_more_text = get_theme_mod( 'coletivo_news_more_text', esc_html__( 'Read Our Blog', 'coletivo' ) );
if ( coletivo_is_selective_refresh() ) {
	$coletivo_news_disable = false;
}
?>
<?php
if ( ! $coletivo_news_disable ) {
	$desc = get_theme_mod( 'coletivo_news_desc' );

	if ( ! coletivo_is_selective_refresh() ) {
		?>
		<section id="<?php if ( '' !== $coletivo_news_id ) echo esc_attr( $coletivo_news_id ); ?>" <?php do_action( 'coletivo_section_atts', 'news' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-news section-padding onepage-section', 'news' ) ); // phpcs:ignore ?>">
		<?php
	}

	do_action( 'coletivo_section_before_inner', 'news' );
	?>
	<div class="container">
		<?php if ( $coletivo_news_title || $coletivo_news_subtitle || $desc ) { ?>
			<div class="section-title-area">
				<?php
				if ( '' !== $coletivo_news_subtitle ) {
					echo '<h5 class="section-subtitle">' . esc_html( $coletivo_news_subtitle ) . '</h5>';
				}

				if ( '' !== $coletivo_news_title ) {
					echo '<h2 class="section-title">' . esc_html( $coletivo_news_title ) . '</h2>';
				}

				if ( $desc ) {
					echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $desc ) ) . '</div>'; // phpcs:ignore
				}
				?>
			</div>
		<?php } ?>
		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="blog-entry wow slideInUp">
						<?php
						$query = new WP_Query(
							array(
								'posts_per_page'   => $coletivo_news_number,
								'suppress_filters' => 0,
							)
						);

						if ( $query->have_posts() ) {
							/* Start the Loop */
							while ( $query->have_posts() ) {
								$query->the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'list' );
							}
						} else {
							get_template_part( 'template-parts/content', 'none' );
						}

						if ( '' !== $coletivo_news_more_link ) {
							?>
							<div class="all-news">
								<a class="btn btn-theme-primary btn-lg" href="<?php echo esc_url( $coletivo_news_more_link ); ?>">
									<?php
									if ( '' !== $coletivo_news_more_text ) {
										echo esc_html( $coletivo_news_more_text );
									}
									?>
								</a>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>

		</div>
	</div>
	<?php
	do_action( 'coletivo_section_after_inner', 'news' );
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		</section>
		<?php
	}
}
wp_reset_postdata();
