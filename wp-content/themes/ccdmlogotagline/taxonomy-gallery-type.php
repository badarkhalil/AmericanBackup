<?php
/**
 * Gallery Archives
 *
 */

//* Force full width content layout
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


add_filter( 'body_class', 'gallery_tax_body_class' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function gallery_tax_body_class( $classes ) {
	$classes[] = 'procedures-grid';
	return $classes;
}

 
// Remove items from loop
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

/**
 * Add Portfolio Image
 *
 */

add_action( 'genesis_entry_content', 'post_meta_image' );
function post_meta_image() {
	echo '<div class="procedures">';
	echo '<div class="procedure-content">'; 
	$images = get_post_meta(get_the_ID(), 'Gallery', true);?>
	<?php if( ! empty($images) ){
		$img = apply_filters( 'the_content', $images );?>
		<div class="one-half first">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $img; ?></a>
		</div>
		<div class="one-half">
			<?php 
			     genesis_do_post_content();
			echo '<p>Individual results may vary.</p>';
			echo '<p><a href="/contact-us">Contact Dr.</a> and set up a consultation.</p>';
			?>
		</div>
	<?php }
	      else{ the_content(); }

	echo '</div></div>';
}

add_filter( 'genesis_pre_get_option_content_archive_thumbnail', '__return_false' );
 
genesis();