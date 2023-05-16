<?php
/**
 * This file adds the Home Page to the Outreach Pro Theme.
 *
 * @author StudioPress
 * @package Outreach Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'outreach_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function outreach_home_genesis_meta() {

    if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-top-2' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {

        //* Force full-width-content layout setting
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
        
        //* Add outreach-pro-home body class
        add_filter( 'body_class', 'outreach_body_class' );
        
        //* Remove breadcrumbs
        remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

        //* Remove the default Genesis loop
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        
        //* Add home top widgets
        add_action( 'genesis_loop', 'outreach_home_top_widgets');

        //* Add home middle widgets
        add_action( 'genesis_before_footer', 'outreach_home_top_2_widgets', 1);

        //* Add home middle widgets
        add_action( 'genesis_before_footer', 'outreach_home_middle_widgets', 2);

        //* Add home bottom widgets
        add_action( 'genesis_before_footer', 'outreach_home_bottom_widgets', 3);

        //* Add home bottom widgets
        add_action( 'genesis_before_footer', 'outreach_home_bottom_2_widgets', 4);

        //* Add home bottom widgets
        add_action( 'genesis_before_footer', 'outreach_home_bottom_3_widgets', 5);

        //* Add home bottom widgets
        add_action( 'genesis_before_footer', 'outreach_home_bottom_4_widgets', 6);

        //* Add home bottom widgets
        add_action( 'genesis_before_footer', 'outreach_home_bottom_5_widgets', 7);

    }

}

function outreach_body_class( $classes ) {

    $classes[] = 'outreach-pro-home';
    return $classes;
    
}

function outreach_home_top_widgets() {

    genesis_widget_area( 'home-top', array(
        'before' => '<div class="home-top widget-area">',
        'after'  => '</div>',
    ) );
 
}

function outreach_home_top_2_widgets() {

    genesis_widget_area( 'home-top-2', array(
        'before' => '<div class="home-top-2 widget-area"><div class="wrap">',
        'after'  => '</div></div>',
    ) );

}

function outreach_home_middle_widgets() {

    genesis_widget_area( 'home-middle', array(
        'before' => '<div class="home-middle widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}

function outreach_home_bottom_widgets() {
    
    genesis_widget_area( 'home-bottom', array(
        'before' => '<div class="home-bottom widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}

function outreach_home_bottom_2_widgets() {
    
    genesis_widget_area( 'home-bottom-2', array(
        'before' => '<div class="home-bottom-2 widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}


function outreach_home_bottom_3_widgets() {
    
    genesis_widget_area( 'home-bottom-3', array(
        'before' => '<div class="home-bottom-3 widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}

function outreach_home_bottom_4_widgets() {
    
    genesis_widget_area( 'home-bottom-4', array(
        'before' => '<div class="home-bottom-4 widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}

function outreach_home_bottom_5_widgets() {
    
    genesis_widget_area( 'home-bottom-5', array(
        'before' => '<div class="home-bottom-5 widget-area"><div class="wrap">',
        'after'  => '<div class="clearfix"></div></div></div>',
    ) );

}


genesis();