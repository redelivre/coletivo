<?php
$coletivo_content_id       = get_theme_mod( 'coletivo_content_id', esc_html__('content', 'coletivo') );
$coletivo_content_disable  = get_theme_mod( 'coletivo_content_disable' ) == 1 ? true : false ;
$title    = get_theme_mod( 'coletivo_content_title', esc_html__('Content', 'coletivo' ));
$subtitle = get_theme_mod( 'coletivo_content_subtitle', esc_html__('Section subtitle', 'coletivo' ));
$coletivo_content_fullwidth_enable  = get_theme_mod( 'coletivo_content_fullwidth' ) == 1 ? true : false ;
if ( coletivo_is_selective_refresh() ) {
    $coletivo_content_disable = false;
}
// Get data
$page_ids =  coletivo_get_section_content_data();
if ( ! empty( $page_ids ) ) {
    ?>
    <?php if (!$coletivo_content_disable) { ?>
        <?php
        global $post;
        $post_id = $page_ids[0];
        $post_id = apply_filters( 'wpml_object_id', $post_id, 'page', true );
        $post = get_post( $post_id );
        setup_postdata( $post );
        ?>
        <section style="<?php echo esc_attr( $style );?>" id="<?php if ($coletivo_content_id != '') {
            echo $coletivo_content_id; }; ?>" <?php do_action('coletivo_section_atts', 'content'); ?> class="section-content-home section-padding">

            <div class="content"> 
	            <div class="container">
	                <?php do_action('coletivo_section_before_inner', 'content'); ?>
                <div class="title-area-<?php echo esc_attr( $layout ); ?> container">
        <?php if ( $title || $subtitle ){ ?>
            <div class="section-title-area">
                <?php if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; ?>
                <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
               <?php } ?>
            </div>
        <?php if ($coletivo_content_fullwidth_enable === false ) { ?>
                    <div class="section-content-area">
                            <div class="section-desc">
                              <?php
                                    the_content();
                                ?>
                            </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                ?>
        <?php } ?>
                </div>
                </div>

            <?php if ($coletivo_content_fullwidth_enable === true ) { ?>
                                <div class="section-content-fullwidth">
                                        <div class="section-desc">
                                          <?php
                                                the_content();
                                            ?>
                                        </div>
                                </div>
                                <?php
                                wp_reset_postdata();
                            ?>
            <?php } ?>

            </div>
            <?php do_action('coletivo_section_after_inner', 'content'); ?>
        <?php if ( ! has_post_thumbnail( $post_id ) ) ?>
        </section>
    <?php } ?>
    <?php }