<?php
$coletivo_store_id        = get_theme_mod( 'coletivo_store_id', esc_html__('store', 'coletivo') );
$coletivo_store_disable   = get_theme_mod( 'coletivo_store_disable' ) == 1 ? true : false;
$coletivo_store_title     = get_theme_mod( 'coletivo_store_title', esc_html__('Latest Products', 'coletivo' ));
$coletivo_store_subtitle  = get_theme_mod( 'coletivo_store_subtitle', esc_html__('Section subtitle', 'coletivo' ));
$coletivo_store_number    = get_theme_mod( 'coletivo_store_number', '4' );
$coletivo_store_columns   = get_theme_mod( 'coletivo_store_columns', '4' );
$coletivo_store_paginate  = get_theme_mod( 'coletivo_store_paginate', 'false' );
$coletivo_store_orderby	  = get_theme_mod( 'coletivo_store_orderby', 'title' );
$coletivo_store_order	  = get_theme_mod( 'coletivo_store_order', 'ASC' );
$coletivo_store_on_sale	  = get_theme_mod( 'coletivo_store_on_sale', 'false' );
$coletivo_store_more_link = get_theme_mod( 'coletivo_store_more_link', '#' );
$coletivo_store_more_text = get_theme_mod( 'coletivo_store_more_text', esc_html__('Browse our store', 'coletivo' ));
if ( coletivo_is_selective_refresh() ) {
    $coletivo_store_disable = false;
}
?>
<?php if ( ! $coletivo_store_disable  ) :

$desc = get_theme_mod( 'coletivo_store_desc' );
?>
<?php if ( ! coletivo_is_selective_refresh() ){ ?>
<section id="<?php if ( $coletivo_store_id != '' ) echo $coletivo_store_id; ?>" <?php do_action( 'coletivo_section_atts', 'store' ); ?> class="<?php echo esc_attr( apply_filters( 'coletivo_section_class', 'section-news section-padding onepage-section', 'store' ) ); ?>">
<?php } ?>
    <?php do_action( 'coletivo_section_before_inner', 'store' ); ?>
	<div class="container">
		<?php if ( $coletivo_store_title ||  $coletivo_store_subtitle ||  $desc ) { ?>
		<div class="section-title-area">
			<?php if ( $coletivo_store_subtitle != '' ) echo '<h5 class="section-subtitle">' . esc_html( $coletivo_store_subtitle ) . '</h5>'; ?>
			<?php if ( $coletivo_store_title != '' ) echo '<h2 class="section-title">' . esc_html( $coletivo_store_title ) . '</h2>'; ?>
            <?php if ( $desc ) {
                echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $desc ) ) . '</div>';
            } ?>
        </div>
		<?php } ?>
		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="blog-entry wow slideInUp">
						<?php
						if(class_exists("WC_Shortcodes")) { //check if WC is activated
							echo WC_Shortcodes::products(
								array(
									'limit'		=> $coletivo_store_number,
									'columns'	=> $coletivo_store_columns,
									'paginate'	=> $coletivo_store_paginate,
									'orderby'	=> $coletivo_store_orderby,
									'order'		=> $coletivo_store_order,
									'on_sale'	=> $coletivo_store_on_sale,
									'suppress_filters' => 0
								)
							);
						}
						if ( $coletivo_store_more_link != '' ) { ?>
						<div class="all-products">
							<a class="btn btn-theme-primary btn-lg" href="<?php echo esc_url($coletivo_store_more_link) ?>"><?php if ( $coletivo_store_more_text != '' ) echo esc_html( $coletivo_store_more_text ); ?></a>
						</div>
						<?php } ?>

					</div>
				</div>
			</div>

		</div>
	</div>
	<?php do_action( 'coletivo_section_after_inner', 'store' ); ?>
<?php if ( ! coletivo_is_selective_refresh() ){ ?>
</section>
<?php } ?>
<?php endif;
wp_reset_query();

