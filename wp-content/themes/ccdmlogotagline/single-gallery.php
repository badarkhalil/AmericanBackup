<?php
/*
* Post singles
*
*/

add_filter( 'body_class', 'single_body_class' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function single_body_class( $classes ) {
	$classes[] = 'procedures';
	return $classes;
}

//* Remove the entry meta in the entry header and footer (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//adding the post navigation links
add_action('genesis_entry_footer', 'navigate_single');
function navigate_single(){
?>
	<div class="archive-pagination pagination">
	<div class="previous-post-link"><?php next_post_link('%link', __('Previous Case'), true, ' ', 'post-type'); ?></div>
	<div class="next-post-link"><?php previous_post_link('%link', __('Next Case'), true, ' ', 'post-type'); ?></div>
	</div>
	<?php
}
genesis();
