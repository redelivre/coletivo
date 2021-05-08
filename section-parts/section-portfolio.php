<?php
/**
 * Section Portfolio
 *
 * @package coletivo
 */

$coletivo_portfolio_id        = get_theme_mod( 'coletivo_portfolio_id', esc_html__( 'portfolio', 'coletivo' ) );
$coletivo_portfolio_disable   = get_theme_mod( 'coletivo_portfolio_disable', 1 ) === 1 ? true : false;
$coletivo_portfolio_title     = get_theme_mod( 'coletivo_portfolio_title', esc_html__( 'Our Work', 'coletivo' ) );
$coletivo_portfolio_subtitle  = get_theme_mod( 'coletivo_portfolio_subtitle', esc_html__( 'Section subtitle', 'coletivo' ) );
$coletivo_portfolio_number    = get_theme_mod( 'coletivo_portfolio_number', '3' );
$coletivo_portfolio_more_link = get_theme_mod( 'coletivo_portfolio_more_link', '#' );
$coletivo_portfolio_more_text = get_theme_mod( 'coletivo_portfolio_more_text', esc_html__( 'See our portfolio', 'coletivo' ) );
if ( coletivo_is_selective_refresh() ) {
	$coletivo_portfolio_disable = false;
}

if ( ! $coletivo_portfolio_disable ) {
	$desc = get_theme_mod( 'coletivo_portfolio_desc' );
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		<section id="<?php if ( '' !== $coletivo_portfolio_id ) echo esc_attr( $coletivo_portfolio_id ); ?>" <?php do_action( 'coletivo_section_atts', 'portfolio' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-portfolio section-padding onepage-section', 'portfolio' ) ); // phpcs:ignore ?>">
	<?php } ?>
	<?php do_action( 'coletivo_section_before_inner', 'portfolio' ); ?>
	<div class="container">
		<?php if ( $coletivo_portfolio_title || $coletivo_portfolio_subtitle || $desc ) { ?>
			<div class="section-title-area">
				<?php
				if ( '' !== $coletivo_portfolio_subtitle ) {
					echo '<h5 class="section-subtitle">' . esc_html( $coletivo_portfolio_subtitle ) . '</h5>';
				}

				if ( '' !== $coletivo_portfolio_title ) {
					echo '<h2 class="section-title">' . esc_html( $coletivo_portfolio_title ) . '</h2>';
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
						$args  = array(
							'post_type'        => 'jetpack-portfolio',
							'posts_per_page'   => $coletivo_portfolio_number,
							'suppress_filters' => 0,
						);
						$query = new WP_Query( $args );
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
						}

						if ( '' !== $coletivo_portfolio_more_link ) {
							?>
							<div class="all-portfolio">
								<a class="btn btn-theme-primary btn-lg" href="<?php echo esc_url( $coletivo_portfolio_more_link ); ?>">
									<?php
									if ( '' !== $coletivo_portfolio_more_text ) {
										echo esc_html( $coletivo_portfolio_more_text );
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
	do_action( 'coletivo_section_after_inner', 'portfolio' );
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		</section>
		<?php
	}
}
wp_reset_postdata();
