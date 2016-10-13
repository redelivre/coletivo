
<?php
$onepress_featuredpage_id       = get_theme_mod( 'onepress_featuredpage_id', esc_html__('featuredpage', 'onepress') );
$onepress_featuredpage_disable  = get_theme_mod( 'onepress_featuredpage_disable' ) == 1 ? true : false ;
$onepress_featuredpage_desc     = get_theme_mod( 'onepress_featuredpage_desc');
if ( onepress_is_selective_refresh() ) {
    $onepress_featuredpage_disable = false;
}

// Get data
$page_ids =  onepress_get_section_featuredpage_data();
$content_source = get_theme_mod( 'onepress_featuredpage_content_source' );
if ( ! empty( $page_ids ) ) {
    ?>
    <?php if (!$onepress_featuredpage_disable) { ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        <section id="<?php if ($onepress_featuredpage_id != '') {
            echo $onepress_featuredpage_id;
        }; ?>" <?php do_action('onepress_section_atts', 'featuredpage'); ?> class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-featuredpage section-padding onepage-section', 'featuredpage')); ?>">
        <?php } ?>

            <?php do_action('onepress_section_before_inner', 'featuredpage'); ?>
            <div class="container">
                <div class="content">
                    <?php
                    if ( ! empty ( $page_ids ) ) {
                        global $post;
                            $post_id = $page_ids[0];
                            $post_id = apply_filters( 'wpml_object_id', $post_id, 'page', true );
                            $post = get_post( $post_id );
                            setup_postdata( $post );
                            ?>
                            <div class="<?php echo esc_attr($class); ?> wow slideInUp">
                                <h2 class="section-title"><?php the_title(); ?></h2>
                                <?php
                                if ( $content_source == 'excerpt' ) {
                                    the_excerpt();
                                } else {
                                    the_content();
                                }

                                ?>
                            </div>
                            
                            <?php
                        wp_reset_postdata();
                    }// ! empty pages ids
                    ?>
                </div>
            </div>
            <?php do_action('onepress_section_after_inner', 'featuredpage'); ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php }
}