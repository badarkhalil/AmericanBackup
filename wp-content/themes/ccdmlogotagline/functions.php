<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'outreach', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'outreach' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Outreach Pro Theme', 'outreach' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/outreach/' );
define( 'CHILD_THEME_VERSION', '3.0.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Remove the entry meta in the entry header and footer (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );


//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'outreach_google_fonts' );
function outreach_google_fonts() {

    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,600,700&display=swap', array(), CHILD_THEME_VERSION );
    
}

//* Enqueue Backstretch script and prepare images for loading
add_action( 'wp_enqueue_scripts', 'outreach_enqueue_backstretch_scripts' );
function outreach_enqueue_backstretch_scripts() {

    //* Load scripts only if custom background is being used
    if ( ! get_background_image() )
        return;

    wp_enqueue_script( 'outreach-pro-backstretch', '/wp-content/themes/ccdmlogotagline/shared/js/backstretch.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'outreach-pro-backstretch-set', '/wp-content/themes/ccdmlogotagline/shared/js/backstretch-set.js' , array( 'jquery', 'outreach-pro-backstretch' ), '1.0.0' );

    wp_localize_script( 'outreach-pro-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );

}

//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'outreach_enqueue_responsive_script' );
function outreach_enqueue_responsive_script() {

    wp_enqueue_script( 'outreach-responsive-menu', '/wp-content/themes/ccdmlogotagline/shared/js/slideout.js', array( 'jquery' ), '1.0.0' );

    wp_enqueue_style( 'outreach-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css', array(), '5.15.1' );

}

//add custom menu classes
function add_menuclass($ulclass) {
return preg_replace('/<a href="#"/', '<a href="#" class="sub-item"', $ulclass, -1);
}
add_filter('wp_nav_menu','add_menuclass');

//* Featured Image After Single Post title

add_action( 'genesis_entry_header', 'single_post_featured_image', 15 );

function single_post_featured_image() {
    
    if ( ! is_singular( 'post' ))
        return;
    
    $img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'image_size' ), 'attr' => array( 'class' => 'post-image' ) ) );
    printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
    
}

//*All Specials functionality
// Change posts per page in the specials category
add_action( 'pre_get_posts', 'specials_cat_posts_per_page' );
function specials_cat_posts_per_page( $query ) {
    if( $query->is_main_query() && (is_category( 'specials' ) || is_category( 'monthly' ) || is_category( 'flash' )) && ! is_admin() ) {
        $query->set( 'posts_per_page', '1' );
    }
}

/** Change Text Shown When No Posts Are Found */
add_filter('genesis_noposts_text', 'eo_noposts_text');
function eo_noposts_text($text)
{

if( is_category( 'specials' ) || is_category( 'monthly' ) || is_category( 'flash' )  ){
  $text = '<span class="noposts-text">' . __('<header class="entry-header"><h1 class="entry-title">Specials</h1></header>No current specials – coming soon!', 'eo') . '</span>';

  return $text;
}

if( is_category( 'blog' )  ){
  $text = '<span class="noposts-text">' . __('<header class="entry-header"><h1 class="entry-title">Blogs</h1></header>There are no current blogs at this time.', 'eo') . '</span>';

  return $text;
}
}

function new_subcategory_hierarchy() {  
    $category = get_queried_object();
 
    $parent_id = $category->category_parent;
 
    $templates = array();
     
    if ( $parent_id == 0 ) {
        // Use default values from get_category_template()
        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
        $templates[] = 'category.php';      
    } else {
        // Create replacement $templates array
        $parent = get_category( $parent_id );
 
        // Current first
        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
 
        // Parent second
        $templates[] = "category-{$parent->slug}.php";
        $templates[] = "category-{$parent->term_id}.php";
        $templates[] = 'category.php';  
    }
    return locate_template( $templates );
}
 
add_filter( 'category_template', 'new_subcategory_hierarchy' );

//* Add new image sizes
add_image_size( 'home-top', 1140, 460, TRUE );
add_image_size( 'home-bottom', 285, 160, TRUE );
add_image_size( 'sidebar', 300, 150, TRUE );
add_image_size( 'portfolio', 340, 230, TRUE );
add_image_size( 'specials', 2000, 2000, TRUE );


//* Add support for custom header
add_theme_support( 'custom-header', array(
    'header-selector' => '.site-title a',
    'header-text'     => false,
    'height'          => 90,
    'width'           => 220,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );


//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'nav',
    'subnav',
    'site-inner',
    'footer-widgets',
    'footer',
) );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );


//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'outreach_after_entry', 5 );
function outreach_after_entry() {

    if ( is_singular( 'post' ) )
        genesis_widget_area( 'after-entry', array(
            'before' => '<div class="after-entry widget-area">',
            'after'  => '</div>',
        ) );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'outreach_author_box_gravatar_size' );
function outreach_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'outreach_remove_comment_form_allowed_tags' );
function outreach_remove_comment_form_allowed_tags( $defaults ) {
    
    $defaults['comment_notes_after'] = '';
    return $defaults;

}

/** Customize Genesis Footer */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'blogvkp_footer' );
function blogvkp_footer() {
    ?>
   <div class="copyright">&copy; <?php echo date("Y") ?> Crystal Clear Digital Marketing | <a href="/site-map/" target="_blank">Site Map</a> | <a href="/terms-service-privacy-policy/" target="_blank">TOS/Privacy Policy</a> | <a href="/" target="_blank">American Urgent Care</a></div><div class="ccdmlogo"><a href="https://crystalcleardm.com" target="_blank"><img src="/wp-content/uploads/2021/04/CCDM_Logo-Footer-white.png" rel="nofollow"></a></div><div class="clearfix"></div>
    <?php
}


//* Add the sub footer section
add_action( 'genesis_before_footer', 'outreach_sub_footer', 5 );
function outreach_sub_footer() {

    if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
        echo '<div class="sub-footer"><div class="wrap">';
        
           genesis_widget_area( 'sub-footer-left', array(
               'before' => '<div class="sub-footer-left">',
               'after'  => '</div>',
           ) );
    
           genesis_widget_area( 'sub-footer-right', array(
               'before' => '<div class="sub-footer-right">',
               'after'  => '</div>',
           ) );
    
        echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';  
    }
    
}

//*add powered by text to review footer
add_action( 'genesis_entry_footer', 'crystal_clear_powered' );
function crystal_clear_powered() {
    if(is_page('reviews'))
        echo '<p class="powered">Powered by Crystal Clear Digital Marketing Reviews</p>';
    return;
}

add_action("gform_post_submission", "set_post_content", 10, 2);
 function set_post_content($entry, $form){
 // Lets get the IDs of the relevant fields and prepare an email message
 $message = print_r($entry, true);
 // In case any of our lines are larger than 70 characters, we should use wordwrap()
 $message = wordwrap($message, 70);
 // Send
 mail('info@crystalcleardm.com', 'Getting the Gravity Form Field IDs', $message);
 function post_to_url($url, $data) {
 $fields = '';
 foreach($data as $key => $value) {
 $fields .= $key . '=' . $value . '&';
 }
 rtrim($fields, '&');
 $post = curl_init();
 curl_setopt($post, CURLOPT_URL, $url);
 curl_setopt($post, CURLOPT_POST, count($data));
 curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
 curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
 $result = curl_exec($post);
 curl_close($post);
 }
 if($form["id"] == 1  || $form["id"] == 6){//Join Our Mailing List
 $data = array(
 "FullName" =>     $entry["2"],
 "Mobile" =>         $entry["3"],
 "Email" =>         $entry["4"],
 "SkillsInterests" =>     $entry["5"],
 "Location" =>     $entry["6"]
 );
 post_to_url("https://app.aestheticnow.com/form/iBq-UBI0v56iUVemp9bCLKBsSlMuL9DPfdocTdahxNY/", $data);
 }
 if($form["id"] == 5  || $form["id"] == 7){//Join Our Mailing List
 $data = array(
 "FullName" =>     $entry["2"],
 "Mobile" =>         $entry["3"],
 "Email" =>         $entry["4"],
 "SkillsInterests" =>     $entry["5"]
 );
 post_to_url("https://app.aestheticnow.com/form/iBq-UBI0v56iUVemp9bCLKBsSlMuL9DPfdocTdahxNY/", $data);
 } 
 if($form["id"] == 3){
$data = array(
   "FullName" =>     $entry["1.3"],
   "Email" =>         $entry["2"],
   "Mobile" =>         $entry["3"],
   "SkillsInterests" =>   $entry["4"],
   "UTM Campaign" =>     $entry["5"],
   "UTM Source" =>     $entry["6"],
   "UTM Medium" =>     $entry["7"],
   "UTM Term" =>     $entry["8"],
   "UTM Content" =>     $entry["9"]
);
post_to_url("https://app.aestheticnow.com/form/iBq-UBI0v56iUVemp9bCLKBsSlMuL9DPfdocTdahxNY/", $data);
 }
 if($form["id"] == 2){
$data = array(
   "FullName" =>     $entry["1.3"],
   "Email" =>         $entry["2"],
   "Mobile" =>         $entry["3"],
   "SkillsInterests" =>   $entry["4"],
   "UTM Campaign" =>     $entry["5"],
   "UTM Source" =>     $entry["6"],
   "UTM Medium" =>     $entry["7"],
   "UTM Term" =>     $entry["8"],
   "UTM Content" =>     $entry["9"]
);
post_to_url("https://app.aestheticnow.com/form/iBq-UBI0v56iUVemp9bCLKBsSlMuL9DPfdocTdahxNY/", $data);
 } 
 }

/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
 */
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}


//*Allow Span Tag in WordPress Editor
function override_mce_options($initArray) 
{
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
 }
 add_filter('tiny_mce_before_init', 'override_mce_options'); 



//* Register widget areas
genesis_register_sidebar( array(
  'id'          => 'header-extra',
  'name'        => __( 'Header Extra', 'outreach' ),
  'description' => __( 'This is the extra top header section of the Home page.', 'outreach' ),
) );
//* Register widget areas
genesis_register_sidebar( array(
    'id'          => 'home-top',
    'name'        => __( 'Home - Top', 'outreach' ),
    'description' => __( 'This is the top section of the Home page.', 'outreach' ),
) );
//* Register widget areas
genesis_register_sidebar( array(
    'id'          => 'home-top-2',
    'name'        => __( 'Home - Top - 2', 'outreach' ),
    'description' => __( 'This is the section of the Home page under the slider.', 'outreach' ),
) );
//* Register widget areas
genesis_register_sidebar( array(
    'id'          => 'home-middle',
    'name'        => __( 'Home - Middle', 'outreach' ),
    'description' => __( 'This is the middle section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'home-bottom',
    'name'        => __( 'Home - Bottom', 'outreach' ),
    'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'home-bottom-2',
    'name'        => __( 'Home - Bottom - 2', 'outreach' ),
    'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'home-bottom-3',
    'name'        => __( 'Home - Bottom - 3', 'outreach' ),
    'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'home-bottom-4',
    'name'        => __( 'Home - Bottom - 4', 'outreach' ),
    'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'home-bottom-5',
    'name'        => __( 'Home - Bottom - 5', 'outreach' ),
    'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'after-entry',
    'name'        => __( 'After Entry', 'outreach' ),
    'description' => __( 'This is the after entry widget area.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'portfolio',
    'name'        => __( 'Portfolio', 'outreach' ),
    'description' => __( 'This is the widget area on the portfolio page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'checkin',
    'name'        => __( 'Check In', 'outreach' ),
    'description' => __( 'This is the widget area on the check in page.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'sub-footer-left',
    'name'        => __( 'Sub Footer - Left', 'outreach' ),
    'description' => __( 'This is the left section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
    'id'          => 'sub-footer-right',
    'name'        => __( 'Sub Footer - Right', 'outreach' ),
    'description' => __( 'This is the right section of the sub footer.', 'outreach' ),
) );

//* Add the header extra area. Currently setup at the tpo of page.
//* Chagne the 3 to a higher number if wanted inside Site Header.
add_action( 'genesis_header', 'hd_header_extra', 3 );
function hd_header_extra() {

  if ( is_active_sidebar( 'header-extra' )) {
    echo '<div id="header-extra">';
    
       genesis_widget_area( 'header-extra', array(
           'before' => '<div class="wrap">',
           'after'  => '<div class="clearfix"></div></div>',
       ) );
  
    echo '</div>';  
  }
  
}

//* Reposition the primary navigation menu, to postion the menu higher,
//* change the 12 to a lower number. 
//*  remove_action( 'genesis_after_header', 'genesis_do_nav' );
//*  add_action( 'genesis_header', 'genesis_do_nav', 12 );


function custom_login_logo() { ?>
    <style type="text/css">
         #bitnami-banner { display: none; }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );