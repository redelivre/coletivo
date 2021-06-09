<?php
/**
 * Section Featured Page
 *
 * @package coletivo
 */

$coletivo_featuredpage_id        = get_theme_mod( 'coletivo_featuredpage_id', esc_html__( 'featuredpage', 'coletivo' ) );
$coletivo_featuredpage_disable   = get_theme_mod( 'coletivo_featuredpage_disable' ) === 1 ? true : false;
$coletivo_featuredpage_more_text = get_theme_mod( 'coletivo_featuredpage_more_text', esc_html__( 'Discover', 'coletivo' ) );
$coletivo_featuredpage_desc      = get_theme_mod( 'coletivo_featuredpage_desc' );
if ( coletivo_is_selective_refresh() ) {
	$coletivo_featuredpage_disable = false;
}
// Get data.
$page_ids       = coletivo_get_section_featuredpage_data();
$content_source = get_theme_mod( 'coletivo_featuredpage_content_source' );
if ( ! empty( $page_ids ) ) {
	?>
	<?php if ( ! $coletivo_featuredpage_disable ) { ?>
		<?php
		if ( ! empty( $page_ids ) ) {
			global $post;
			$postid  = $page_ids[0];
			$postid  = apply_filters( 'wpml_object_id', $postid, 'page', true );
			$thepost = get_post( $postid );
			setup_postdata( $thepost );

			if ( ! coletivo_is_selective_refresh() ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'full' );
				if ( ! $thumb || empty( $thumb ) ) {
					$style = 'background:#222;';
				} else {
					$style = sprintf( 'background:url( %s ) center no-repeat;background-size:cover;', $thumb[0] );
				}
				?>
				<section style="<?php echo esc_attr( $style ); ?>" id="<?php if ( '' !== $coletivo_featuredpage_id ) echo esc_attr( $coletivo_featuredpage_id ); ?>" <?php do_action( 'coletivo_section_atts', 'featuredpage' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-featuredpage section-padding onepage-section', 'featuredpage' ) ); // phpcs:ignore ?>">
				<?php } ?>
			<?php } ?>
			<div class="content">
				<div class="container">
					<?php do_action( 'coletivo_section_before_inner', 'featuredpage' ); ?>
					<div class="section-title-area">
						<h2 class="section-title"><?php the_title(); ?></h2>
						<div class="section-desc">
							<?php
							if ( 'excerpt' === $content_source ) {
								the_excerpt();
							} else {
								the_content();
							}
							?>
						</div>
						<br />
						<?php if ( '' !== $coletivo_featuredpage_more_text ) { ?>
							<a id="featuredpage" class="btn btn-theme-primary btn-lg" href="<?php echo esc_url( get_permalink() ); ?>">
							<?php echo esc_html( $coletivo_featuredpage_more_text ); ?>
							</a>
						<?php } ?>
					</div>
					<?php
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php do_action( 'coletivo_section_after_inner', 'featuredpage' ); ?>
		<?php if ( ! has_post_thumbnail( $postid ) ) { ?>
			</section>
			<?php
		}
	}
}
