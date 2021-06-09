<?php
/**
 * Add theme dashboard page
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme Info
 */
function coletivo_theme_info() {

	$actions      = coletivo_get_actions_required();
	$n            = array_count_values( $actions );
	$number_count = 0;
	if ( $n && isset( $n['active'] ) ) {
		$number_count = $n['active'];
	}

	if ( $number_count > 0 ) {
		$update_label = sprintf( _n( '%1$s action required', '%1$s actions required', $number_count, 'coletivo' ), $number_count );
		$count        = '<span class="update-plugins count-' . esc_attr( $number_count ) . '" title="' . esc_attr( $update_label ) . '"><span class="update-count">' . number_format_i18n( $number_count ) . '</span></span>';
		$menu_title   = sprintf( esc_html__( 'Coletivo Theme %s', 'coletivo' ), $count );
	} else {
		$menu_title = esc_html__( 'Coletivo Theme', 'coletivo' );
	}

	add_theme_page( esc_html__( 'Coletivo Dashboard', 'coletivo' ), $menu_title, 'edit_theme_options', 'ft_coletivo', 'coletivo_theme_info_page' );
}
add_action( 'admin_menu', 'coletivo_theme_info' );

/**
 * Add admin notice when active theme, just show one timetruongsa@200811
 *
 * @return bool|null
 */
function coletivo_admin_notice() {
	if ( ! function_exists( 'coletivo_get_actions_required' ) ) {
		return false;
	}
	$actions       = coletivo_get_actions_required();
	$n             = array_count_values( $actions );
	$number_action = 0;
	if ( $n && isset( $n['active'] ) ) {
		$number_action = $n['active'];
	}
	if ( $number_action > 0 ) {
		$theme_data = wp_get_theme();
		?>
		<div class="updated notice is-dismissible">
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'coletivo' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=ft_coletivo' ) ) ); // phpcs:ignore ?></p>
		</div>
		<?php
	}
}

/**
 * Activation notice
 */
function coletivo_one_activation_admin_notice() {
	global $pagenow;
	wp_verify_nonce( $nonce );
	if ( is_admin() && ( 'themes.php' === $pagenow ) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'coletivo_admin_notice' );
	}
}
add_action( 'load-themes.php', 'coletivo_one_activation_admin_notice' );

/**
 * Theme info page
 */
function coletivo_theme_info_page() {

	$theme_data = wp_get_theme();

	wp_verify_nonce( $nonce );
	if ( isset( $_GET['coletivo_action_dismiss'] ) ) {
		$actions_dismiss = get_option( 'coletivo_actions_dismiss' );
		if ( ! is_array( $actions_dismiss ) ) {
			$actions_dismiss = array();
		}
		$actions_dismiss[ sanitize_key( wp_unslash( $_GET['coletivo_action_dismiss'] ) ) ] = 'dismiss';
		update_option( 'coletivo_actions_dismiss', $actions_dismiss );
	}

	// Check for current viewing tab.
	$tab = null;
	if ( isset( $_GET['tab'] ) ) {
		$tab = sanitize_key( wp_unslash( $_GET['tab'] ) );
	} else {
		$tab = null;
	}

	$actions       = coletivo_get_actions_required();
	$n             = array_count_values( $actions );
	$number_action = 0;
	if ( $n && isset( $n['active'] ) ) {
		$number_action = $n['active'];
	}
	$nonce               = wp_create_nonce( 'coletivo_action_dismiss' );
	$current_action_link = admin_url( 'themes.php?page=ft_coletivo&tab=actions_required&_wpnonce=' . $nonce . '' );
	?>
	<div class="wrap about-wrap theme_info_wrapper">
		<h1><?php printf( esc_html__( 'Welcome to Coletivo - Version %1s', 'coletivo' ), esc_html( $theme_data->Version ) ); // phpcs:ignore ?></h1>
		<div class="about-text"><?php esc_html_e( 'Coletivo is a creative and flexible WordPress theme well suited for business, social projects, portfolio, digital agency, product showcase, freelancers websites.', 'coletivo' ); ?></div>
		<a target="_blank" href="<?php echo esc_url( THEME_URI ); ?>" class="wp-badge"><span>ColetivoWP</span></a>
		<h2 class="nav-tab-wrapper">
			<a href="?page=ft_coletivo" class="nav-tab<?php echo is_null( $tab ) ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'Coletivo', 'coletivo' ); ?></a>
			<a href="?page=ft_coletivo&tab=actions_required" class="nav-tab<?php echo 'actions_required' === $tab ? ' nav-tab-active' : null; ?>">
				<?php
				esc_html_e( 'Actions Required', 'coletivo' );
				echo ( $number_action > 0 ) ? '<span class="theme-action-count">' . esc_html( $number_action ) . '</span>' : '';
				?>
			</a>
			<?php do_action( 'coletivo_admin_more_tabs' ); ?>
		</h2>

		<?php if ( is_null( $tab ) ) { ?>
			<div class="theme_info info-tab-content">
				<div class="theme_info_column clearfix">
					<div class="theme_info_left">

						<div class="theme_link">
							<h3><?php esc_html_e( 'Theme Customizer', 'coletivo' ); ?></h3>
							<p class="about"><?php printf( esc_html__( '%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'coletivo' ), esc_html( $theme_data->Name ) ); // phpcs:ignore ?></p>
							<p>
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Start Customize', 'coletivo' ); ?></a>
							</p>
						</div>
						<div class="theme_link">
							<h3><?php esc_html_e( 'Theme Documentation', 'coletivo' ); ?></h3>
							<p class="about"><?php printf( esc_html__( 'Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'coletivo' ), esc_html( $theme_data->Name ) ); // phpcs:ignore ?></p>
							<p>
								<a href="<?php echo esc_url( THEME_WIKI_GITHUB_URI ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Coletivo Documentation', 'coletivo' ); ?></a>
							</p>
							<?php do_action( 'coletivo_dashboard_theme_links' ); ?>
						</div>
					</div>

					<div class="theme_info_right">
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="Theme Screenshot" />
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ( 'actions_required' === $tab ) { ?>
			<div class="action-required-tab info-tab-content">
				<?php if ( $number_action > 0 ) { ?>
					<?php
					$actions = wp_parse_args(
						$actions,
						array(
							'page_on_front' => '',
							'page_template',
						)
					);
					?>
					<?php if ( 'active' === $actions['page_on_front'] ) { ?>
						<div class="theme_link  action-required">
							<a title="<?php esc_attr_e( 'Dismiss', 'coletivo' ); ?>" class="dismiss" href="<?php echo esc_url( add_query_arg( array( 'coletivo_action_dismiss' => 'page_on_front' ), $current_action_link ) ); ?>"><span class="dashicons dashicons-dismiss"></span></a>
							<h3><?php esc_html_e( 'Switch "Front page displays" to "A static page"', 'coletivo' ); ?></h3>
							<div class="about">
								<p><?php esc_html_e( 'In order to have the one page look for your website, please go to Customize -&gt; Static Front Page and switch "Front page displays" to "A static page".', 'coletivo' ); ?></p>
							</div>
							<p>
								<a  href="<?php echo esc_url( admin_url( 'options-reading.php' ) ); ?>" class="button"><?php esc_html_e( 'Setup front page displays', 'coletivo' ); ?></a>
							</p>
						</div>
					<?php } ?>

					<?php if ( 'active' === $actions['page_template'] ) { ?>
						<div class="theme_link  action-required">
							<a  title="<?php esc_attr_e( 'Dismiss', 'coletivo' ); ?>" class="dismiss" href="<?php echo esc_url( add_query_arg( array( 'coletivo_action_dismiss' => 'page_template' ), $current_action_link ) ); ?>"><span class="dashicons dashicons-dismiss"></span></a>
							<h3><?php esc_html_e( 'Set your homepage page template to "Frontpage".', 'coletivo' ); ?></h3>

							<div class="about">
								<p><?php esc_html_e( 'In order to change homepage section contents, you will need to set template "Frontpage" for your homepage.', 'coletivo' ); ?></p>
							</div>
							<p>
								<?php
								$front_page = get_option( 'page_on_front' );
								if ( $front_page <= 0 ) {
									?>
									<a  href="<?php echo esc_url( admin_url( 'options-reading.php' ) ); ?>" class="button"><?php esc_html_e( 'Setup front page displays', 'coletivo' ); ?></a>
									<?php
								}

								if ( $front_page > 0 && get_post_meta( $front_page, '_wp_page_template', true ) !== 'template-frontpage.php' ) {
									?>
									<a href="<?php echo esc_url( get_edit_post_link( $front_page ) ); ?>" class="button"><?php esc_html_e( 'Change homepage page template', 'coletivo' ); ?></a>
									<?php
								}
								?>
							</p>
						</div>
					<?php } ?>
					<?php do_action( 'coletivo_more_required_details', $actions ); ?>
				<?php } else { ?>
					<h3><?php printf( esc_html__( 'Keep update with %s', 'coletivo' ), esc_html( $theme_data->Name ) ); // phpcs:ignore ?></h3>
					<p><?php esc_html_e( 'Hooray! There are no required actions for you right now.', 'coletivo' ); ?></p>
				<?php } ?>
			</div>
		<?php } ?>

		<?php do_action( 'coletivo_more_tabs_details', $actions ); ?>

	</div> <!-- END .theme_info -->
	<?php
}
