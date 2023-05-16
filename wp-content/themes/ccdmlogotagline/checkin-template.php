<?php
 
/**
* Template Name: Check In
* Description: Check in page
*/
 
// Add our custom loop
add_action( 'genesis_meta', 'checkin_meta' );
 
function checkin_meta() {

	if ( is_active_sidebar( 'checkin' )) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add referral-content body class
		add_filter( 'body_class', 'checkin_body_class' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add portfolio widget
		add_action( 'genesis_loop', 'checkin_widgets' );

	}
 
}

function checkin_body_class( $classes ) {

	$classes[] = 'checkin';
	return $classes;
	
}

function checkin_widgets() {
	
	echo '<section id="referral" class="checkin widget-area"><div class="wrap">';

	//client checkin form
	genesis_widget_area( 'checkin', array(
		'before' => '<div id="check-in" class="checkinForm"><div class="wrap">',
		'after'  => '</div></div>',
	) );
	
	echo '</div><!-- end wrap --></section><!-- end checkin -->';

}


//* Remove site header elements for rest
//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header', 10 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// remove navigation
remove_action( 'genesis_after_header', 'genesis_do_nav');

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//remove footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action( 'genesis_footer', 'blogvkp_footer' );
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
 
genesis();