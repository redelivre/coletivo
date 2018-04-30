<?php
$coletivo_content_id       = get_theme_mod( 'coletivo_content_id', esc_html__('content', 'coletivo') );
$coletivo_content_disable  = get_theme_mod( 'coletivo_content_disable' ) == 1 ? true : false ;
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
            echo $coletivo_content_id;
        }; ?>" <?php do_action('coletivo_section_atts', 'content'); ?> class="<?php echo esc_attr(apply_filters('coletivo_section_class', 'section-content section-padding onepage-section', 'content')); ?>">

            <div class="content"> 
	            <div class="container">
	                <?php do_action('coletivo_section_before_inner', 'content'); ?>
                            <div class="section-title-area">
                                <h2 class="section-title"><?php the_title(); ?></h2>
		                            <div class="section-desc">
		                              <?php
		                                    the_content();
		                                ?>
		                            </div>
                                <br />
		                    </div>
                            <?php
                        wp_reset_postdata();
                    ?>
            </div>
        </div>
            <?php do_action('coletivo_section_after_inner', 'content'); ?>
        <?php if ( ! has_post_thumbnail( $post_id ) ) ?>
        </section>
    <?php }
}