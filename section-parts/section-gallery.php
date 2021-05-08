<?php
/**
 * Section Gallery
 *
 * @package coletivo
 */

$coletivo_gallery_id       = get_theme_mod( 'coletivo_gallery_id', esc_html__( 'gallery', 'coletivo' ) );
$coletivo_gallery_disable  = get_theme_mod( 'coletivo_gallery_disable', 1 ) === 1 ? true : false;
$coletivo_gallery_title    = get_theme_mod( 'coletivo_gallery_title', esc_html__( 'Gallery', 'coletivo' ) );
$coletivo_gallery_subtitle = get_theme_mod( 'coletivo_gallery_subtitle', esc_html__( 'Section subtitle', 'coletivo' ) );
$coletivo_gallery_desc     = get_theme_mod( 'coletivo_gallery_desc' );

if ( coletivo_is_selective_refresh() ) {
	$coletivo_gallery_disable = false;
}
$layout = get_theme_mod( 'coletivo_gallery_layout', 'default' );

?>
<?php if ( ! $coletivo_gallery_disable ) { ?>
	<?php if ( ! coletivo_is_selective_refresh() ) { ?>
		<section id="<?php if ( '' !== $coletivo_gallery_id ) echo esc_attr( $coletivo_gallery_id ); ?>" <?php do_action( 'coletivo_section_atts', 'gallery' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-gallery ' . ( ( $coletivo_gallery_title || $coletivo_gallery_subtitle || $coletivo_gallery_desc ) ? 'section-padding' : '' ) . ' section-meta onepage-section', 'gallery' ) ); // phpcs:ignore ?>">
	<?php } ?>
	<?php do_action( 'coletivo_section_before_inner', 'gallery' ); ?>
	<div class="g-layout-<?php echo esc_attr( $layout ); ?> container">
		<?php if ( $coletivo_gallery_title || $coletivo_gallery_subtitle || $coletivo_gallery_desc ) { ?>
			<div class="section-title-area">
				<?php
				if ( '' !== $coletivo_gallery_subtitle ) {
					echo '<h5 class="section-subtitle">' . esc_html( $coletivo_gallery_subtitle ) . '</h5>';
				}

				if ( '' !== $coletivo_gallery_title ) {
					echo '<h2 class="section-title">' . esc_html( $coletivo_gallery_title ) . '</h2>';
				}

				if ( $coletivo_gallery_desc ) {
					echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $coletivo_gallery_desc ) ) . '</div>'; // phpcs:ignore
				}
				?>
			</div>
		<?php } ?>
		<div class="gallery-content">
			<?php
			coletivo_gallery_generate();
			?>
		</div>
		<?php
		$readmore_link = get_theme_mod( 'coletivo_g_readmore_link' );
		$readmore_text = get_theme_mod( 'coletivo_g_readmore_text', esc_html__( 'View More', 'coletivo' ) );
		if ( $readmore_link ) {
			?>
			<div class="all-gallery">
				<a class="btn btn-theme-primary btn-lg" href="<?php echo esc_attr( $readmore_link ); ?>"><?php echo esc_html( $readmore_text ); ?></a>
			</div>
		<?php } ?>

	</div>
	<?php
	do_action( 'coletivo_section_after_inner', 'gallery' );
	if ( ! coletivo_is_selective_refresh() ) {
		?>
		</section>
		<?php
	}
}
