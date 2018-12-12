<?php
$coletivo_contact_id            = get_theme_mod( 'coletivo_contact_id', esc_html__('contact', 'coletivo') );
$coletivo_contact_disable       = get_theme_mod( 'coletivo_contact_disable' ) == 1 ?  true : false;
$coletivo_contact_title         = get_theme_mod( 'coletivo_contact_title', esc_html__('Get in touch', 'coletivo' ));
$coletivo_contact_subtitle      = get_theme_mod( 'coletivo_contact_subtitle', esc_html__('Section subtitle', 'coletivo' ));
$coletivo_contact_cf7           = get_theme_mod( 'coletivo_contact_cf7' );
$coletivo_contact_cf7_disable   = get_theme_mod( 'coletivo_contact_cf7_disable' );
$coletivo_contact_address_title = get_theme_mod( 'coletivo_contact_address_title' );
$coletivo_contact_text          = get_theme_mod( 'coletivo_contact_text' );
$coletivo_contact_address       = get_theme_mod( 'coletivo_contact_address' );
$coletivo_contact_phone         = get_theme_mod( 'coletivo_contact_phone' );
$coletivo_contact_whats         = get_theme_mod( 'coletivo_contact_whats' );
$coletivo_contact_email         = get_theme_mod( 'coletivo_contact_email' );
$coletivo_contact_fb            = get_theme_mod( 'coletivo_contact_fb' );
$coletivo_contact_instagram     = get_theme_mod( 'coletivo_contact_instagram' );
$coletivo_contact_twitter       = get_theme_mod( 'coletivo_contact_twitter' );

if ( coletivo_is_selective_refresh() ) {
    $coletivo_contact_disable = false;
}

if ( $coletivo_contact_cf7 || $coletivo_contact_text || $coletivo_contact_address_title || $coletivo_contact_phone || $coletivo_contact_email || $coletivo_contact_fb || $coletivo_contact_instagram || $coletivo_contact_twitter ) {
    $desc = get_theme_mod( 'coletivo_contact_desc' );
    ?>
    <?php if (!$coletivo_contact_disable) : ?>
        <?php if ( ! coletivo_is_selective_refresh() ){ ?>
        <section id="<?php if ($coletivo_contact_id != '') echo $coletivo_contact_id; ?>" <?php do_action('coletivo_section_atts', 'counter'); ?>
                 class="<?php echo esc_attr(apply_filters('coletivo_section_class', 'section-contact section-padding  section-meta onepage-section', 'contact')); ?>">
        <?php } ?>
            <?php do_action('coletivo_section_before_inner', 'contact'); ?>
            <div class="container">
                <?php if ( $coletivo_contact_title || $coletivo_contact_subtitle || $desc ){ ?>
                <div class="section-title-area">
                    <?php if ($coletivo_contact_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($coletivo_contact_subtitle) . '</h5>'; ?>
                    <?php if ($coletivo_contact_title != '') echo '<h2 class="section-title">' . esc_html($coletivo_contact_title) . '</h2>'; ?>
                    <?php if ( $desc ) {
                        echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $desc ) ) . '</div>';
                    } ?>
                </div>
                <?php } ?>
                <div class="row">
                    <?php
					if ($coletivo_contact_cf7_disable != '1') :
						$classe = 'col-sm-6';
						if (isset($coletivo_contact_cf7) && $coletivo_contact_cf7 != '') { ?>
                            <div class="contact-form col-sm-6 wow slideInUp">
                                <?php
								echo apply_filters( 'the_content', wp_kses_post( $coletivo_contact_cf7  ) );
                                ?>
                            </div>
                        <?php };
					else :
						$classe = 'col-sm-12';
					endif; ?>

                    <div class="<?php echo $classe; ?> wow slideInUp">
                            <h3><?php if ($coletivo_contact_address_title != '') echo wp_kses_post($coletivo_contact_address_title); ?></h3>
                            <div class="contact-text"><?php if ($coletivo_contact_text != '') echo wp_kses_post($coletivo_contact_text); ?>
                            </div>
                        <div class="address-box">

                            <?php if ($coletivo_contact_address != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-map-marker fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><?php echo wp_kses_post($coletivo_contact_address); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($coletivo_contact_phone != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><?php echo wp_kses_post($coletivo_contact_phone); ?></div>
                                </div>
                            <?php endif; ?>

							<?php if ($coletivo_contact_whats != ''): ?>
								<div class="address-contact">
									<span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-whatsapp fa-stack-1x fa-inverse"></i></span>

									<div class="address-content">
										<?php
										$coletivo_contact_whats_number = preg_replace( '/[^0-9]/', '', $coletivo_contact_whats );
										?>
										<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $coletivo_contact_whats_number  ?>"><?php echo wp_kses_post($coletivo_contact_whats); ?></a>
									</div>
								</div>
							<?php endif; ?>

                            <?php if ($coletivo_contact_email != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><a href="mailto:<?php echo antispambot($coletivo_contact_email); ?>"><?php echo antispambot($coletivo_contact_email); ?></a></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($coletivo_contact_fb != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><a href="http://<?php echo wp_kses_post($coletivo_contact_fb); ?>" target="_blank"><?php echo wp_kses_post($coletivo_contact_fb); ?></a></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($coletivo_contact_instagram != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><a href="http://instagram.com/<?php echo wp_kses_post($coletivo_contact_instagram); ?>" target="_blank"><?php echo wp_kses_post($coletivo_contact_instagram); ?></a></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($coletivo_contact_twitter != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><a href="http://twitter.com/<?php echo wp_kses_post($coletivo_contact_twitter); ?>" target="_blank"><?php echo wp_kses_post($coletivo_contact_twitter); ?></a></div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>


                </div>
            </div>
            <?php do_action('coletivo_section_after_inner', 'contact'); ?>
        <?php if ( ! coletivo_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php endif;
}
