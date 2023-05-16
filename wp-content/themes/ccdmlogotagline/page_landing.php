<?php
/**
 * CCD Genesis Laning Page
 *
 * Template Name: CCDM Landing
 *
 */

// Add landing page body class to the head
add_filter( 'body_class', 'genesis_sample_add_body_class' );
function genesis_sample_add_body_class( $classes ) {

    $classes[] = 'landing';

    return $classes;

}

// Remove Skip Links
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue Skip Links Script
add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
function genesis_sample_dequeue_skip_links() {
    wp_dequeue_script( 'skip-links' );
}

// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Remove page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Remove site inner wrap
add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

// Remove edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

// Load landing page styles
add_action( 'wp_enqueue_scripts', 'landing_do_custom_styles' );
function landing_do_custom_styles() {
    wp_enqueue_style( 'landing', CHILD_URL . '/landing.css', array(), PARENT_THEME_VERSION );
}

//======================================================================
// BEGIN ACF CONTENT
//======================================================================

// Display main header
add_action( 'genesis_entry_header', 'landing_do_optional_logo' );
function landing_do_optional_logo() {
    if( get_field('logo_image') ) { ?>
        <div class="landing-main-header" style="background:<?php echo get_field('header_bg_color'); ?>;">
            <div class="wrap">
                <div class="inner">
                <div class="logo">
                    <img src="<?php echo get_field('logo_image'); ?>" />
                </div>
                <div class="info">
                    <div class="phone"><a style="color:<?php echo get_field('header_phone_color'); ?>;" href="tel:+1<?php echo get_field('tracking_number'); ?>"><span class="icon"><i class="fa fa-phone-square" aria-hidden="true"></i></span> <span class="number"><?php echo get_field('tracking_number'); ?></span></a></div>
                    <div class="request"><a style="background: <?php echo get_field('modal_background_color'); ?>; color: <?php echo get_field('modal_button_text_color'); ?> !important; box-shadow: 0 3px 0 <?php echo get_field('modal_button_shadow_color'); ?>;" class="btn top form openmodal" href="#"><?php echo get_field('modal_button_text'); ?></a></div>
                </div>
                </div>
            </div>
        </div>
    <?php }
}

// Display modal form
add_action( 'genesis_entry_header', 'landing_modal_popup' );
function landing_modal_popup() {
  if( get_field('modal_title') ) { ?>
        <div id="xmodal-overlay" class="xmodal-overlay"></div>
        <div id="xmodal" class="xmodal">
            <div class="xmodal-guts">
                <?php if ( get_field( 'image') ) { ?>              
                    <p class="center-text"><img src="<?php echo get_field('image'); ?>"></p>
                <?php } ?>                  
                <?php if ( get_field( 'modal_title') ) { ?>              
                    <h1 style="font-size:<?php echo get_field('modal_title_size'); ?>;color:<?php echo get_field('modal_title_color'); ?>;"><?php echo get_field('modal_title'); ?></h1>
                <?php } ?> 
                <?php if ( get_field( 'extra_information') ) { ?>              
                    <?php echo get_field('extra_information'); ?>
                <?php } ?>         

                <?php echo do_shortcode("[gravityform id='".get_field('gravity_form_id')."' title='false' description='false']"); ?> 
            </div>
            <i class="fa fa-times"><a class="openmodal">CLOSE</a></i>
        </div>


  <?php }
}    

// Display main footer
add_action( 'genesis_entry_footer', 'landing_do_optional_logo2' );
function landing_do_optional_logo2() {
    if( get_field('logo_image') ) { ?>
        <div class="landing-main-footer" style="background:<?php echo get_field('header_bg_color'); ?>;">
            <div class="wrap center-text">
                <p><a style="color:<?php echo get_field('header_phone_color'); ?>;" href="tel:+1<?php echo get_field('tracking_number'); ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo get_field('tracking_number'); ?></a></p>
                <p><a class="btn top form openmodal" href="#" style="background: <?php echo get_field('modal_background_color'); ?>; color: <?php echo get_field('modal_button_text_color'); ?> !important; box-shadow: 0 3px 0 <?php echo get_field('modal_button_shadow_color'); ?>;"><?php echo get_field('modal_button_text'); ?></a></p>
                <p><img src="<?php echo get_field('logo_image'); ?>" /></p>
                <p class="company">*Disclaimer: Individual Results May Vary</p>
                <p class="tos">Privacy Policy &amp; Terms of Service</p>
            </div>
        </div>
    <?php }
}

// Display content of flexible content layouts
add_action( 'genesis_entry_content', 'landing_do_acf_content' );
function landing_do_acf_content() {
    if( have_rows('landing_page_content') ) { ?>

        <section class="landing-content">

        <?php while ( have_rows('landing_page_content') ) : the_row();

            // Main Headline Banner
            if( get_row_layout() == 'main_headline_banner' ) { ?>
                <div class="landing-headline-banner" style="background-image: url(<?php echo get_sub_field('header_bg_image'); ?>);">
                    <div class="wrap">
                        <div class="inner-box">
                            <?php echo get_sub_field('header_content_area'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php } 

            // Gravity Top Form Box
            else if( get_row_layout() == 'form_box' ) { ?>
                <div class="lead-form-box">
                    <div class="wrap">
                        <?php if ( get_sub_field( 'cta_gravity_top') ) { ?>                          
                        <h4 class="center-text"><?php echo get_sub_field('cta_gravity_top'); ?></h4>
                        <?php } ?>  
                        <?php echo do_shortcode("[gravityform id='".get_sub_field('gravity_form_shortcode')."' title='false' description='false']"); ?>
                    </div>
                </div>
            <?php } 

            // Gravity Regular Form Box
            else if( get_row_layout() == 'regular_form_box' ) { ?>
                <div class="lead-form-box2" style="background: url(<?php echo get_sub_field('background_image'); ?>) <?php echo get_sub_field('background_color'); ?>; background-size: cover;">
                    <div class="wrap">
                        <?php if ( get_sub_field( 'title_form_box') ) { ?>                          
                        <h1 class="center-text" style="font-size: <?php echo get_sub_field('title_size_form_box'); ?>; color: <?php echo get_sub_field('title_color_form_box'); ?>;"><?php echo get_sub_field('title_form_box'); ?></h1>
                        <?php } ?>
                        <?php if ( get_sub_field( 'sub_title_form_box') ) { ?>                          
                        <h3 class="center-text" style="font-size: <?php echo get_sub_field('subtitle_size_form_box'); ?>; color: <?php echo get_sub_field('subtitle_color_form_box'); ?>;"><?php echo get_sub_field('sub_title_form_box'); ?></h3>
                        <?php } ?>
                        <div class="inner-box">
                        <?php echo do_shortcode("[gravityform id='".get_sub_field('gravity_form_shortcode')."' title='false' description='false']"); ?>
                        </div>
                    </div>
                </div>
            <?php }             


            // Headline with WYSIWYG
            else if( get_row_layout() == 'headline_with_wysiwyg' ) { ?>

                <div class="heading-text" style="background-color: <?php echo get_sub_field('background_color'); ?>">
                    <div class="wrap">
                        <h2 class="plain-title"><?php echo get_sub_field('headline'); ?></h2>
                        <?php echo get_sub_field('content'); ?>
                    </div>
                </div>

            <?php }

            // Left image right text
            else if( get_row_layout() == 'left_image_right_text' ) { ?>

                <div class="left-image-right-text" style="background-color: <?php echo get_sub_field('background_color'); ?>">
                    <div class="wrap">
                        <div class="one-half first">
                            <img class="aligncenter" src="<?php echo get_sub_field('image'); ?>" />
                        </div>
                        <div class="one-half">
                            <?php echo get_sub_field('text'); ?>
                        </div>
                    </div>
                </div>

            <?php }


            // Large Left Image Text Right
            else if( get_row_layout() == 'large_left_image_right_text' ) { ?>

                <div class="large-left-image-right-text" style="background-image: url(<?php echo get_sub_field('background_image'); ?>); background-color: <?php echo get_sub_field('background_color'); ?>">
                    <div class="mobilebox"><img src="<?php echo get_sub_field('mobile_image'); ?>" /></div>
                    <div class="wrap">
                        <div class="inner-box">
                            <?php echo get_sub_field('text'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            <?php }


            // Large Right Image Text Right
            else if( get_row_layout() == 'large_right_image_left_text' ) { ?>

                <div class="large_right_image_left_text" style="background-image: url(<?php echo get_sub_field('background_image'); ?>); background-color: <?php echo get_sub_field('background_color'); ?>">
                    <div class="mobilebox"><img src="<?php echo get_sub_field('mobile_image'); ?>" /></div>
                    <div class="wrap">
                        <div class="inner-box">
                            <?php echo get_sub_field('text'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            <?php }         

            // Regular Text Areaa
            else if( get_row_layout() == 'regular_text_area' ) { ?>

                <div class="regular-textarea <?php echo get_sub_field('area_class'); ?>" style="background-image: url(<?php echo get_sub_field('background_image'); ?>); background-color: <?php echo get_sub_field('background_color'); ?>">
                    <div class="wrap">
                        <div class="inner">
                            <?php echo get_sub_field('text'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            <?php }

            // 2 column content
            else if( get_row_layout() == '2_column_content' ) { ?>

                <div class="two-columns">
                    <div class="wrap">
                        <h2 class="center-text" style="font-size:<?php echo get_sub_field('title_size'); ?>; color: <?php echo get_sub_field('title_color'); ?>;"><?php echo get_sub_field('title_area'); ?></h2>
                        <?php if( have_rows('columns') ) { 
                            
                            $columns = 2;
                            $increment = 0; ?>

                        <div class="all-columns">

                        <?php while ( have_rows('columns') ) : the_row(); ?>

                            <div class="one-half <?php if($increment % $columns == 0){echo'first';}$increment++; ?>">
                                <img src="<?php echo get_sub_field('image'); ?>">
                                <div class="inner"> 
                                    <?php if ( get_sub_field( 'column_heading') ) { ?>                          
                                    <h3><?php echo get_sub_field('column_heading'); ?></h3>
                                    <?php } ?>
                                    <?php if ( get_sub_field( 'text_content') ) { ?>                            
                                    <?php echo get_sub_field('text_content'); ?>
                                    <?php } ?>      
                                    <?php if ( get_sub_field( 'video_content') ) { ?>                           
                                    <?php echo get_sub_field('video_content'); ?>
                                    <?php } ?>  
                                </div>
                            </div>
                        <?php endwhile; ?>
                            <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                        <?php if( get_sub_field('modal_button_need') == 'Yes' ): ?>
                          <p class="center-text"><a style="background: <?php echo get_field('modal_background_color'); ?>; color: <?php echo get_field('modal_button_text_color'); ?> !important; box-shadow: 0 3px 0 <?php echo get_field('modal_button_shadow_color'); ?>;" class="btn top form openmodal" href="#"><?php echo get_field('modal_button_text'); ?></a></p>
                        <?php endif; ?>                         
                    </div>
                </div>

            <?php }     

            // 3 column content
            else if( get_row_layout() == '3_column_content' ) { ?>

                <div class="three-columns">
                    <div class="wrap">
                         <?php if ( get_sub_field( 'title_area') ) { ?><h2 class="center-text" style="font-size:<?php echo get_sub_field('title_size'); ?>; color: <?php echo get_sub_field('title_color'); ?>;"><?php echo get_sub_field('title_area'); ?></h2><?php } ?> 
                        <?php if( have_rows('columns') ) { 
                            
                            $columns = 3;
                            $increment = 0; ?>

                        <div class="all-columns">

                        <?php while ( have_rows('columns') ) : the_row(); ?>

                            <div class="one-third <?php if($increment % $columns == 0){echo'first';}$increment++; ?>">
                                <img src="<?php echo get_sub_field('image'); ?>">
                                <div class="inner"> 
                                    <?php if ( get_sub_field( 'column_heading') ) { ?>                          
                                    <h3><?php echo get_sub_field('column_heading'); ?></h3>
                                    <?php } ?>
                                    <?php if ( get_sub_field( 'text_content') ) { ?>                            
                                    <?php echo get_sub_field('text_content'); ?>
                                    <?php } ?>      
                                    <?php if ( get_sub_field( 'video_content') ) { ?>                           
                                    <?php echo get_sub_field('video_content'); ?>
                                    <?php } ?>  
                                </div>
                            </div>
                        <?php endwhile; ?>
                            <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                        <?php if( get_sub_field('modal_button_need') == 'Yes' ): ?>
                          <p class="center-text"><a style="background: <?php echo get_field('modal_background_color'); ?>; color: <?php echo get_field('modal_button_text_color'); ?> !important; box-shadow: 0 3px 0 <?php echo get_field('modal_button_shadow_color'); ?>;" class="btn top form openmodal" href="#"><?php echo get_field('modal_button_text'); ?></a></p>
                        <?php endif; ?>                         
                    </div>
                </div>

            <?php }

            // 4 column content
            else if( get_row_layout() == '4_column_content' ) { ?>

                <div class="four-columns">
                    <div class="wrap">
                        <h2 class="center-text" style="font-size:<?php echo get_sub_field('title_size'); ?>; color: <?php echo get_sub_field('title_color'); ?>;"><?php echo get_sub_field('title_area'); ?></h2>
                        <?php if( have_rows('columns') ) { 
                            
                            $columns = 4;
                            $increment = 0; ?>

                        <div class="all-columns">

                        <?php while ( have_rows('columns') ) : the_row(); ?>

                         <div class="one-fourth <?php if($increment % $columns == 0){echo'first';}$increment++; ?>" style="background-image: url(<?php echo get_sub_field('image'); ?>);">
                                <div class="inner"> 
                                    <?php if ( get_sub_field( 'column_heading') ) { ?>                          
                                    <h3><?php echo get_sub_field('column_heading'); ?></h3>
                                    <?php } ?>
                                    <?php if ( get_sub_field( 'text_content') ) { ?>                            
                                    <?php echo get_sub_field('text_content'); ?>
                                    <?php } ?>      
                                    <?php if ( get_sub_field( 'video_content') ) { ?>                           
                                    <?php echo get_sub_field('video_content'); ?>
                                    <?php } ?>  
                                </div>
                            </div>
                        <?php endwhile; ?>
                            <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                        <?php if( get_sub_field('modal_button_need') == 'Yes' ): ?>
                          <p class="center-text"><a style="background: <?php echo get_field('modal_background_color'); ?>; color: <?php echo get_field('modal_button_text_color'); ?> !important; box-shadow: 0 3px 0 <?php echo get_field('modal_button_shadow_color'); ?>;" class="btn top form openmodal" href="#"><?php echo get_field('modal_button_text'); ?></a></p>
                        <?php endif; ?> 
                    </div>
                </div>

            <?php }


            endwhile; ?>

            

        </section> 

    <?php }




}



//======================================================================
// END ACF CONTENT
//======================================================================

genesis();