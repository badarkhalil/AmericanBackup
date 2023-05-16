<?php
/*
* Template Name:  Then and Now Gallery
*/
 
 
 
//remove emoji script
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
# Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

# Remove the breadcrumb
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the entry header markup (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );


/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
add_filter( 'body_class', 'procedures_body_class' );
function procedures_body_class( $classes ) {
	$classes[] = 'procedures-grid';
	return $classes;
}

/**
 * enqueue the all the scripts
 * we'll need in order to make
 * this page operate. we will
 * be use Jquery UI accordion
 * as well as we'll need code
 * to perform the ajax requests
 * for updating exactly which
 * gallery/album we're looking
 * at, also we'll need a script
 * to handle the light box display
 * of our images.
 */
add_action( 'wp_enqueue_scripts', 'then_and_now_template_enqueue_script' );
function then_and_now_template_enqueue_script() {
	
	//make sure we're not on an admin page
	if ( !is_admin() ) {
		//actually enqueue the script containing the front end JS for ajax and accordion
		wp_enqueue_script( 'then_and_now_front_end_js_script',
			plugins_url( '/js/then-and-now-front-end.js', THEN_AND_NOW ),
			array( 'jquery', 'jquery-ui-accordion' )
		);
			
		/**
		 *generate the nonce for selecting new albums
		 */
		$tan_album_nonce = wp_create_nonce( 'tan_view_album' );
			
		//localize the script
		wp_localize_script( 'then_and_now_front_end_js_script', 'tan_select_album_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $tan_album_nonce,
			'loader_url' => plugins_url( '/img/ajax-loader-big.gif', THEN_AND_NOW ),
		) );
		
		//register the jquery ui styles as well.
		wp_register_style('jquery-ui', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		
		//enqueue the the jquery ui styles
		wp_enqueue_style( 'jquery-ui' );
		
		//enqueue front end styles.
		wp_enqueue_style('then_and_now_font_end_styles', plugins_url( '/css/then-and-now-front-end-style.css', THEN_AND_NOW ) );
	}
	
	/**
	 * enqueue featherlight JS/CSS.
	 * Feather light is a library
	 * for our gallery lightbox.
	 */
	wp_enqueue_script('featherlight-lightbox', '//cdn.rawgit.com/noelboss/featherlight/1.4.1/release/featherlight.min.js', array('jquery'), false, true);
	wp_enqueue_script('featherlight-lightbox-gallery', '//cdn.rawgit.com/noelboss/featherlight/1.4.1/release/featherlight.gallery.min.js', array('jquery'), false, true);
    wp_enqueue_style('featherlight-css', '//cdn.rawgit.com/noelboss/featherlight/1.4.1/release/featherlight.min.css');
    wp_enqueue_style('featherlight-gallery-css', '//cdn.rawgit.com/noelboss/featherlight/1.4.1/release/featherlight.gallery.min.css');
} 

#output custom styles to the header
add_action( 'genesis_before', 'tan_custom_css');
function tan_custom_css() {
	$styles = CustomStylesModel::get_styles();
	//make sure we were able to retrieve styles;
	if($styles) {
		//output the styles
		?>
		<style type="text/css">
		h4.ui-accordion-header {<?php echo 'color: '.$styles[0]->rule.' !important;'; ?> }
		.ui-widget-content a { <?php echo 'color: '.$styles[1]->rule.' !important;'; ?> }
		.ui-widget-content a:hover { <?php echo 'color: '.$styles[2]->rule.' !important;'; ?> }
		.ui-widget-content a.selected { <?php echo 'color: '.$styles[3]->rule.' !important;'; ?> }
		</style>
		<?php
	}
}

# Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

# Add custom post content
add_action( 'genesis_entry_content', 'tan_do_post_content' );
 
/**
 * Outputs custom post content
 * we will load render the template
 * as 2 column (one-third/two-thirds)
 * full width layout. the left one-thir 
 * will contain the accordion menu of the 
 * galleries and it's albums, the right
 * (two-thirds) will contain the actual
 * display of the content within each of
 * the albums.
 */
function tan_do_post_content() {
	
	//get all the galleries in our db
	$galleries = GalleryModel::get_all_galleries();
	
	if($galleries) {
	
		//start outputting html for the left (one-third column)
		echo '<div class="one-fourth first tan-gallery-accordion-wrap">';
		echo '<h2 class="tan-gallery-accordion">Before & After Gallery</h2>';
		
		//start accordion html
		echo '<div id="accordion" class="ui-accordion">';
		
		//loop through the galleries and display them.
		foreach($galleries as $gallery) {
			
			//get all the albums for our gallery.
			$albums = AlbumModel::get_all_albums($gallery->gallery_id);
			
			if($albums) {
			
				echo '<h4 class="tan-gallery-title ui-accordion-header"><strong>'.$gallery->name.'</strong></h4>';
			
				//inner wrapper for each accordion element
				echo '<div class="tan-gallery-accordion-inner ui-accordion-content">';
				
				//loop through the albums in our gallery.
				foreach($albums as $album) {
					//make sure we have pages for this album.
					$pages = PageModel::get_all_pages($album->album_id);
					if($pages) {
						$id_string = strtolower(str_replace(' ', '_', $album->name)).'_'.$album->album_id;
						//also make sure we actually have images.
						foreach($pages as $page) {
							$photos = PhotosetModel::get_photosets($page->page_id);
							if($photos) {
								echo '<p class="tan-album"><a href="#" class="tan-album-list-item" data-count="1" data-album-id="'.$album->album_id.'" id="'.$id_string.'">'.$album->name.'</a></p>';
								break;
							}
						}
					}
				}
				
				//close accordion item inner wrapper
				echo '</div>';
			}
			
		}
		
		
		//close accordion
		echo '</div>';

		//widget area for the form on the left.
		genesis_widget_area( 'tan-left-sidebar', array(
			'before' => '<div class="tan-left-sidebar sidebar widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>'; //close the left (one-fourth) column
		
		/**
		 * begin our HTML to output the right (two-thirds) column.
		 * this will be the actual content, images, in the albums.
		 */
		echo '<div class="three-fourths tan-gallery-item-display">';
		
		//container to hold the gallery images on screen
		echo '<div class="tan-album-page">';
		
		genesis_widget_area( 'tan-entry-content', array(
			'before' => '<div class="tan-entry-content widget-area">',
			'after'  => '</div>',
		) );
		
		//close the right (two-thirds) column and the container
		echo '</div></div>';
		
		//clear the floats
		echo '<div class="clearfix"></div>';
	}
	else {
		echo '<h2>Currently no galleries, please check back soon.</h2>';
	}
}

//method to display the results may vary message to the users
add_action( 'genesis_entry_footer', 'tan_results_may_vary' );
function tan_results_may_vary() {
	//echo message to user about results may vary.
	echo '<p class="results_message">Actual patients and results. Please note results may vary.</p>';
}

//* Hook after entry widget after the entry content
add_action( 'genesis_after_entry', 'tan_after_entry', 5 );
function tan_after_entry() {

	genesis_widget_area( 'tan-after-entry', array(
		'before' => '<div class="after-entry widget-area tan-after-entry">',
		'after'  => '</div>',
	) );

}
 
genesis();