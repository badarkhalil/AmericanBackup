<?php
 
/**
* Template Name: Portfolio Template
* Description: Used as a page template to show page contents
*/
 
// Add our custom loop
add_action( 'genesis_meta', 'pp_meta' );
 
function pp_meta() {

	if ( is_active_sidebar( 'portfolio' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add pp-content body class
		add_filter( 'body_class', 'pp_body_class' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add portfolio widget
		add_action( 'genesis_loop', 'pp_widgets' );

	}
 
}

function pp_body_class( $classes ) {

	$classes[] = 'pp-content';
	return $classes;
	
}

function pp_widgets() {

	genesis_widget_area( 'portfolio', array(
		'before' => '<div id="portfolio"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}
 
genesis();