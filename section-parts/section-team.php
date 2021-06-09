<?php
/**
 * Section Team
 *
 * @package coletivo
 */

$coletivo_team_id       = get_theme_mod( 'coletivo_team_id', esc_html__( 'team', 'coletivo' ) );
$coletivo_team_disable  = get_theme_mod( 'coletivo_team_disable' ) === 1 ? true : false;
$coletivo_team_title    = get_theme_mod( 'coletivo_team_title', esc_html__( 'Our Team', 'coletivo' ) );
$coletivo_team_subtitle = get_theme_mod( 'coletivo_team_subtitle', esc_html__( 'Section subtitle', 'coletivo' ) );
$coletivo_team_layout   = intval( get_theme_mod( 'coletivo_team_layout', 3 ) );
if ( $coletivo_team_layout <= 0 ) {
	$coletivo_team_layout = 3;
}
$user_ids = coletivo_get_section_team_data();
if ( coletivo_is_selective_refresh() ) {
	$coletivo_team_disable = false;
}
if ( ! empty( $user_ids ) ) {
	$desc = get_theme_mod( 'coletivo_team_desc' );
	if ( ! $coletivo_team_disable ) {
		if ( ! coletivo_is_selective_refresh() ) {
			?>
			<section id="<?php if ( '' !== $coletivo_team_id ) echo esc_attr( $coletivo_team_id ); ?>" <?php do_action( 'coletivo_section_atts', 'team' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-team section-padding section-meta onepage-section', 'team' ) ); // phpcs:ignore ?>">
			<?php
		}
		do_action( 'coletivo_section_before_inner', 'team' );
		?>
		<div class="container">
			<?php if ( $coletivo_team_title || $coletivo_team_subtitle || $desc ) { ?>
			<div class="section-title-area">
				<?php
				if ( '' !== $coletivo_team_subtitle ) {
					echo '<h5 class="section-subtitle">' . esc_html( $coletivo_team_subtitle ) . '</h5>';
				}

				if ( '' !== $coletivo_team_title ) {
					echo '<h2 class="section-title">' . esc_html( $coletivo_team_title ) . '</h2>';
				}

				if ( $desc ) {
					echo '<div class="section-desc">' . wp_kses_post( apply_filters( 'the_content', $desc ) ) . '</div>';
				}
				?>
			</div>
			<?php } ?>
			<div class="team-members row team-layout-<?php echo esc_attr( intval( 12 / $coletivo_team_layout ) ); ?>">
				<?php
				if ( ! empty( $user_ids ) ) {
					$n = 0;

					foreach ( $user_ids as $member ) {
						$member = wp_parse_args(
							$member,
							array(
								'user_id' => array(),
							)
						);

						$the_link = isset( $member['link'] ) ? $member['link'] : '';
						$user_id  = wp_parse_args(
							$member['user_id'],
							array(
								'id' => '',
							)
						);

						$image_attributes = wp_get_attachment_image_src( $user_id['id'], 'coletivo-small' );
						if ( $image_attributes ) {
							$image = $image_attributes[0];
							$data  = get_post( $user_id['id'] );
							$n ++;
							?>
							<div class="team-member wow slideInUp">
								<div class="member-thumb">
									<?php if ( $the_link ) { ?>
										<a href="<?php echo esc_url( $the_link ); ?>">
									<?php } ?>
									<img src="<?php echo esc_url( $image ); ?>" alt="">
									<?php if ( $the_link ) { ?>
										</a>
									<?php } ?>
									<?php do_action( 'coletivo_section_team_member_media', $member ); ?>
								</div>
								<div class="member-info">
									<h5 class="member-name">
										<?php if ( $the_link ) { ?>
											<a href="<?php echo esc_url( $the_link ); ?>">
										<?php } ?>
										<?php echo esc_html( $data->post_title ); ?>
										<?php if ( $the_link ) { ?>
											</a>
										<?php } ?>
									</h5>
									<span class="member-position"><?php echo wp_kses_post( $data->post_content ); ?></span>
								</div>
							</div>
							<?php
						}
					} // end foreach
				}
				?>
			</div>
		</div>
		<?php
		do_action( 'coletivo_section_after_inner', 'team' );
		if ( ! coletivo_is_selective_refresh() ) {
			?>
			</section>
			<?php
		}
	}
}
