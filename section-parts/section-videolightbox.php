<?php
/**
 * Section Video
 *
 * @package coletivo
 */

$coletivo_videolightbox_id      = get_theme_mod( 'coletivo_videolightbox_id', 'videolightbox' );
$coletivo_videolightbox_disable = get_theme_mod( 'coletivo_videolightbox_disable' ) === 1 ? true : false;
$coletivo_videolightbox_heading = get_theme_mod( 'coletivo_videolightbox_title' );
$coletivo_videolightbox_video   = get_theme_mod( 'coletivo_videolightbox_url' );
if ( coletivo_is_selective_refresh() ) {
	$coletivo_videolightbox_disable = false;
}
if ( ( ! $coletivo_videolightbox_disable && ( $coletivo_videolightbox_video || $coletivo_videolightbox_heading ) ) || coletivo_is_selective_refresh() ) {

	$coletivo_videolightbox_image = get_theme_mod( 'coletivo_videolightbox_image' );
	if ( ! coletivo_is_selective_refresh() ) {
		if ( $coletivo_videolightbox_image ) {
			echo '<div class="section-parallax">';
			echo ' <div class="parallax-bg" data-stellar-ratio="0.5" data-stellar-offset-parent="true" style="background-image: url(' . esc_url( $coletivo_videolightbox_image ) . ');"></div>';
		}
		?>
		<section id="<?php if ( '' !== $coletivo_videolightbox_id ) echo esc_attr( $coletivo_videolightbox_id ); ?>" <?php do_action( 'coletivo_section_atts', 'videolightbox' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-videolightbox section-padding section-padding-larger section-inverse onepage-section', 'videolightbox' ) ); // phpcs:ignore ?>">
	<?php } ?>

	<?php do_action( 'coletivo_section_before_inner', 'videolightbox' ); ?>
	<div class="container">
		<?php if ( $coletivo_videolightbox_video ) { ?>
		<div class="videolightbox__icon videolightbox-popup">
			<a href="<?php echo esc_url( $coletivo_videolightbox_video ); ?>" data-scr="<?php echo esc_attr( $coletivo_videolightbox_video ); ?>" class="popup-video">
				<span class="video_icon"><i class="fa fa-play"></i></span>
			</a>
		</div>
		<?php } ?>
		<?php if ( $coletivo_videolightbox_heading ) { ?>
		<h2 class="videolightbox__heading"><?php echo do_shortcode( wp_kses_post( $coletivo_videolightbox_heading ) ); ?></h2>
		<?php } ?>
	</div>
	<?php do_action( 'coletivo_section_after_inner', 'videolightbox' ); ?>

	<?php if ( ! coletivo_is_selective_refresh() ) { ?>
		</section>
		<?php
		if ( $coletivo_videolightbox_image ) {
			echo '</div>';
		}
	}
}
