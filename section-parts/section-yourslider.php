
<?php
$coletivo_yourslider_id       = get_theme_mod( 'coletivo_yourslider_id', esc_html__('yourslider', 'coletivo') );
$coletivo_yourslider_disable  = get_theme_mod( 'coletivo_yourslider_disable' ) == 1 ? true : false ;
$coletivo_yourslider_title    = get_theme_mod( 'coletivo_yourslider_title', esc_html__('Your Slider', 'coletivo' ));
$coletivo_yourslider_subtitle = get_theme_mod( 'coletivo_yourslider_subtitle', esc_html__('See all we Do', 'coletivo' ));
$coletivo_yourslider_shortcode = get_theme_mod( 'coletivo_yourslider_shortcode');
if ( coletivo_is_selective_refresh() ) {
    $coletivo_yourslider_disable = false;
}
?>
<?php if ( !$coletivo_yourslider_disable && !empty( $coletivo_yourslider_shortcode ) ) :
$coletivo_yourslider_shortcode = get_theme_mod( 'coletivo_yourslider_shortcode' );
?>
<?php if ( ! coletivo_is_selective_refresh() ){ ?>
    <section id="<?php if ($coletivo_yourslider_id != '') echo $coletivo_yourslider_id; ?>"<?php do_action('coletivo_section_atts', 'yourslider'); ?>
                 class="<?php echo esc_attr(apply_filters('coletivo_section_class', 'section-yourslider section-padding section-meta onepage-section', 'yourslider')); ?>">
            <?php do_action('coletivo_section_before_inner', 'yourslider'); ?>
        <div class="content">
    <?php if ( $coletivo_yourslider_title || $coletivo_yourslider_subtitle || $coletivo_yourslider_shortcode ){ ?>
                <div class="section-title-area">
                    <?php if ($coletivo_yourslider_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($coletivo_yourslider_subtitle) . '</h5>'; ?>
                    <?php if ($coletivo_yourslider_title != '') echo '<h2 class="section-title">' . esc_html($coletivo_yourslider_title) . '</h2>'; ?>
                </div>       
                    <?php if ( $coletivo_yourslider_shortcode ) {
                        echo '<div id="coletivo-slider">' . apply_filters( 'the_content', wp_kses_post( $coletivo_yourslider_shortcode  ) ) . '</div>';
                    } ?>
                <?php } ?>        
                <?php wp_reset_postdata();?>
        </div>
    <?php do_action( 'coletivo_section_after_inner', 'yourslider' ); ?>
<?php if ( ! coletivo_is_selective_refresh() ){ ?>
</section>
<?php }
} endif;