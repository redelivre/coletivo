
<?php
$onepress_yourslider_id       = get_theme_mod( 'onepress_yourslider_id', esc_html__('yourslider', 'onepress') );
$onepress_yourslider_disable  = get_theme_mod( 'onepress_yourslider_disable' ) == 1 ? true : false ;
$onepress_yourslider_title    = get_theme_mod( 'onepress_yourslider_title', esc_html__('Your Slider', 'onepress' ));
$onepress_yourslider_subtitle = get_theme_mod( 'onepress_yourslider_subtitle', esc_html__('See all we Do', 'onepress' ));
$onepress_yourslider_shortcode = get_theme_mod( 'onepress_yourslider_shortcode');
if ( onepress_is_selective_refresh() ) {
    $onepress_yourslider_disable = false;
}    ?>
    <?php if (!$onepress_yourslider_disable) { ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
            <?php do_action('onepress_section_before_inner', 'yourslider'); ?>
    <section id="<?php if ($onepress_yourslider_id != '') echo $onepress_yourslider_id; ?>" <?php do_action('onepress_section_atts', 'yourslider'); ?>
                 class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-yourslider section-padding section-meta onepage-section', 'yourslider')); ?>">
        <div class="content"> 
            <div class="container">
    <?php if ( $onepress_yourslider_title || $onepress_yourslider_subtitle || $onepress_yourslider_shortcode ){ ?>
                <div class="section-title-area">
                    <?php if ($onepress_yourslider_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($onepress_yourslider_subtitle) . '</h5>'; ?>
                    <?php if ($onepress_yourslider_title != '') echo '<h2 class="section-title">' . esc_html($onepress_yourslider_title) . '</h2>'; ?>
                    <?php if ( $onepress_yourslider_shortcode ) {
                        echo '<p>' . apply_filters( 'the_content', wp_kses_post( $onepress_yourslider_shortcode  ) ) . '</p>';
                    } ?>
                </div>
                <?php } ?>        
                <?php wp_reset_postdata();?>
            </div>
        </div>
    </section>
                    <?php do_action('onepress_section_after_inner', 'featuredpage'); ?>
        <?php } }