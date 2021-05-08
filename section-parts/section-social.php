<?php
/**
 * Section Social
 *
 * @package coletivo
 */

$coletivo_social_id           = get_theme_mod( 'coletivo_social_id', esc_html__( 'social', 'coletivo' ) );
$coletivo_social_disable      = get_theme_mod( 'coletivo_social_disable', 1 ) === 1 ? true : false;
$coletivo_social_footer_title = get_theme_mod( 'coletivo_social_footer_title', esc_html__( 'Keep Updated', 'coletivo' ) );
$coletivo_footer_info_bg      = get_theme_mod( 'coletivo_footer_info_bg' );
if ( coletivo_is_selective_refresh() ) {
	$coletivo_social_disable = false;
}
if ( ! $coletivo_social_disable ) {
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		<section id="<?php if ( '' !== $coletivo_social_id ) echo esc_attr( $coletivo_social_id ); ?>" <?php do_action( 'coletivo_section_atts', 'social' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-social section-padding section-meta onepage-section', 'social' ) ); // phpcs:ignore ?>">
	<?php } ?>
	<?php do_action( 'coletivo_section_before_inner', 'social' ); ?>
	<div class="footer-connect">
		<div class="container">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<?php
					if ( '1' !== $coletivo_social_disable ) {
						?>
						<div class="footer-social">
							<?php
							if ( '' !== $coletivo_social_footer_title ) {
								echo '<h5 class="follow-heading">' . esc_html( $coletivo_social_footer_title ) . '</h5>';
							}

							$socials = coletivo_get_social_profiles();
							/**
							 * New Socials profiles
							 *
							 * @since 1.1.4
							 * @change 1.2.1
							 */
							echo '<div class="footer-social-icons">';
							if ( $socials ) {
								echo wp_kses_post( $socials );
							} else {
								/**
								 * Deprecated
								 *
								 * @since 1.1.4
								 */
								$twitter   = get_theme_mod( 'coletivo_social_twitter' );
								$facebook  = get_theme_mod( 'coletivo_social_facebook' );
								$google    = get_theme_mod( 'coletivo_social_google' );
								$instagram = get_theme_mod( 'coletivo_social_instagram' );
								$rss       = get_theme_mod( 'coletivo_social_rss' );

								if ( '' !== $twitter ) {
									echo '<a target="_blank" href="' . esc_url( $twitter ) . '" title="Twitter"><i class="fa fa-twitter"></i></a>';
								}
								if ( '' !== $facebook ) {
									echo '<a target="_blank" href="' . esc_url( $facebook ) . '" title="Facebook"><i class="fa fa-facebook"></i></a>';
								}
								if ( '' !== $google ) {
									echo '<a target="_blank" href="' . esc_url( $google ) . '" title="Google Plus"><i class="fa fa-google-plus"></i></a>';
								}
								if ( '' !== $instagram ) {
									echo '<a target="_blank" href="' . esc_url( $instagram ) . '" title="Instagram"><i class="fa fa-instagram"></i></a>';
								}
								if ( '' !== $rss ) {
									echo '<a target="_blank" href="' . esc_url( $rss ) . '"><i class="fa fa-rss"></i></a>';
								}
							}
							echo '</div>';
							?>
						</div>
					<?php } ?>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</div>
	<?php
	do_action( 'coletivo_section_after_inner', 'social' );
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		</section>
		<?php
	}
}
