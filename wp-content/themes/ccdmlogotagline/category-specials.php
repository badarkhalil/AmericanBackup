<?php
/**
 * Specials Archive
 *
 */
 
/**
 * Display as Columns
 *
 */


add_filter( 'genesis_pre_get_option_content_archive', 'sb_do_full_content' );
add_filter( 'genesis_pre_get_option_content_archive_limit', 'sb_no_content_limit' );

// Set the content archives to full
function sb_do_full_content() {

	global $wp_query;

	if ($wp_query->current_post == 0)
		return 'full';
}

// Make sure the content limit isn't set
function sb_no_content_limit() {

	global $wp_query;

	if ($wp_query->current_post == 0)
		return '0';

}

/**
 * Change Image Alignment of Featured Image From Left to Right
 *
 */
function sb_change_image_alignment( $attributes ) {

	$attributes['class'] = str_replace( 'alignleft', 'aligncenter', $attributes['class'] );
		return $attributes;

}
add_filter( 'genesis_attr_entry-image', 'sb_change_image_alignment' );

//* Force full width content layout
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Add specials body class
add_filter( 'body_class', 'special_body_class' );

function special_body_class( $classes ) {

	$classes[] = 'specials';
	return $classes;
	
}
 
// Remove items from loop
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

// Force featured images (if present) to be displayed regardless of theme's Content Archive settings
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'special_post_image' );
function special_post_image() {
	return '1';
}


remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

 
genesis();