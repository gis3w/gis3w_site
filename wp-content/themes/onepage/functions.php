<?php
/*-----------------------------------------------------------------------------------*/
/*	Do not remove these lines, sky will fall on your head.
/*-----------------------------------------------------------------------------------*/
define('MTS_THEME_NAME', 'onepage');

/*-----------------------------------------------------------------------------------*/
/*	Use pattern as background image for specific options
/*-----------------------------------------------------------------------------------*/
add_filter( 'option_'.MTS_THEME_NAME, 'mts_background_patterns' );
function mts_background_patterns( $option ) {
    if (!is_admin()) {
        $use_pattern = array('homepage', 'homepage_features', 'homepage_counter', 'homepage_team', 'homepage_service',
            'homepage_team', 'homepage_service', 'homepage_twitter', 'homepage_portfolio', 'homepage_pricing',
            'homepage_testimonials', 'homepage_client', 'homepage_blog', 'homepage_contact');
        foreach ($use_pattern as $section) {
            if (!empty($option["mts_{$section}_background_pattern"]) && $option["mts_{$section}_background_pattern"] != 'nobg' && empty($option["mts_{$section}_background_image"])) {
                $option["mts_{$section}_background_image"] = get_template_directory_uri().'/images/'.$option["mts_{$section}_background_pattern"].'.png';
            }
        }
    }
    return $option;
}

require_once( dirname( __FILE__ ) . '/theme-options.php' );
if ( ! isset( $content_width ) ) $content_width = 1060;

/*-----------------------------------------------------------------------------------*/
/*	Load Options
/*-----------------------------------------------------------------------------------*/
$mts_options = get_option(MTS_THEME_NAME);

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'mythemeshop', get_template_directory().'/lang' );

// Custom translations
if (!empty($mts_options['translate'])) {
    $mts_translations = get_option('mts_translations_'.MTS_THEME_NAME);//$mts_options['translations'];
    function mts_custom_translate( $translated_text, $text, $domain ) {
        if ($domain == 'mythemeshop' || $domain == 'nhp-opts') {
        	// get options['translations'][$text] and return value
            global $mts_translations;
            
            if (!empty($mts_translations[$text])) {
                $translated_text = $mts_translations[$text];
            }
        }
    	return $translated_text;
        
    }
    add_filter( 'gettext', 'mts_custom_translate', 20, 3 );
}

if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/*  Custom menu walker
/*-----------------------------------------------------------------------------------*/
include('functions/nav-menu.php');

/*-----------------------------------------------------------------------------------*/
/*  Create Blog page on Theme Activation
/*-----------------------------------------------------------------------------------*/
if (isset($_GET['activated']) && is_admin()){
        $new_page_title = 'Blog';
        $new_page_content = '';
        $new_page_template = 'page-blog.php';
        //don't change the code bellow, unless you know what you're doing
        $page_check = get_page_by_title($new_page_title);
        $new_page = array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
                'post_author' => 1,
        );
        if(!isset($page_check->ID)){
                $new_page_id = wp_insert_post($new_page);
                if(!empty($new_page_template)){
                        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                }
		$page_id = $new_page_id;
        } else {
		$page_id = $page_check->ID;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Disable theme updates from WordPress.org theme repository
/*-----------------------------------------------------------------------------------*/
function mts_disable_theme_update( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}
add_filter( 'http_request_args', 'mts_disable_theme_update', 5, 2 );
add_filter( 'auto_update_theme', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 282, 240, true );
	add_image_size( 'featured', 762, 294, true ); //featured
	add_image_size( 'featured-small', 538, 294, true ); //grid layout
	add_image_size( 'widgetthumb', 70, 70, true ); //widget
	add_image_size( 'widgetfull', 340, 200, true ); //Large widget thumb
	add_image_size( 'related', 166, 102, true ); //Related Posts thumb
	add_image_size( 'portfolio', 380, 380, true ); //Portfolio thumb
	add_image_size( 'team', 282, 240, true ); // Team image
	add_image_size( 'testifier', 164, 164, true ); // Testimonial image
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Menu Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'primary-menu' => 'Primary Menu',
		  'footer-menu' => 'Footer Menu'
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar and Footer
/*-----------------------------------------------------------------------------------*/
if ( function_exists('register_sidebar') ) {   
    function mts_register_sidebars() {
        $mts_options = get_option(MTS_THEME_NAME);
        
        register_sidebar(array(
    		'name' => 'Sidebar',
    		'description'   => __( 'Default sidebar.', 'mythemeshop' ),
    		'id' => 'sidebar',
    		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
    		'after_widget' => '</div></div>',
    		'before_title' => '<h3 class="widget-title">',
    		'after_title' => '</h3>',
    	));
        
        // Custom sidebars
        if (!empty($mts_options['mts_custom_sidebars']) && is_array($mts_options['mts_custom_sidebars'])) {
			foreach($mts_options['mts_custom_sidebars'] as $sidebar) {
				if (!empty($sidebar['mts_custom_sidebar_id']) && !empty($sidebar['mts_custom_sidebar_id']) && $sidebar['mts_custom_sidebar_id'] != 'sidebar-') {
					register_sidebar(array('name' => ''.$sidebar['mts_custom_sidebar_name'].'','id' => ''.sanitize_title(strtolower($sidebar['mts_custom_sidebar_id'])).'','before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">','after_widget' => '</div></div>','before_title' => '<h3 class="widget-title">','after_title' => '</h3>'));
				}
			}
		}
    }
    
    add_action('widgets_init', 'mts_register_sidebars');
}

function mts_custom_sidebar() {
    $mts_options = get_option(MTS_THEME_NAME);
    
	// Default sidebar
	$sidebar = 'Sidebar';
	
    if (is_single() && !empty($mts_options['mts_sidebar_for_post'])) $sidebar = $mts_options['mts_sidebar_for_post'];
    if (is_page() && !empty($mts_options['mts_sidebar_for_page'])) $sidebar = $mts_options['mts_sidebar_for_page'];
    
    // Archives
	if (is_archive() && !empty($mts_options['mts_sidebar_for_archive'])) $sidebar = $mts_options['mts_sidebar_for_archive'];
	if (is_category() && !empty($mts_options['mts_sidebar_for_category'])) $sidebar = $mts_options['mts_sidebar_for_category'];
    if (is_tag() && !empty($mts_options['mts_sidebar_for_tag'])) $sidebar = $mts_options['mts_sidebar_for_tag'];
    if (is_date() && !empty($mts_options['mts_sidebar_for_date'])) $sidebar = $mts_options['mts_sidebar_for_date'];
	if (is_author() && !empty($mts_options['mts_sidebar_for_author'])) $sidebar = $mts_options['mts_sidebar_for_author'];
    
    // Other
    if (is_search() && !empty($mts_options['mts_sidebar_for_search'])) $sidebar = $mts_options['mts_sidebar_for_search'];
	if (is_404() && !empty($mts_options['mts_sidebar_for_notfound'])) $sidebar = $mts_options['mts_sidebar_for_notfound'];
	
	// Page/post specific custom sidebar
	if (is_page() || is_single()) {
		wp_reset_postdata();
		global $post;
        $custom = get_post_meta($post->ID,'_mts_custom_sidebar',true);
		if (!empty($custom)) $sidebar = $custom;
	}

	return $sidebar;
}

/*-----------------------------------------------------------------------------------*/
/*  Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/
// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad300.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add Recent Posts Widget
include("functions/widget-recentposts.php");

// Add Related Posts Widget
include("functions/widget-relatedposts.php");

// Add Author Posts Widget
include("functions/widget-authorposts.php");

// Add Popular Posts Widget
include("functions/widget-popular.php");

// Add Facebook Like box Widget
include("functions/widget-fblikebox.php");

// Add Google Plus box Widget
include("functions/widget-googleplus.php");

// Add Subscribe Widget
include("functions/widget-subscribe.php");

// Add Social Profile Widget
include("functions/widget-social.php");

// Add Category Posts Widget
include("functions/widget-catposts.php");

// Add Category Posts Widget
include("functions/widget-postslider.php");

// Add Welcome message
include("functions/welcome-message.php");

// Theme Functions
include("functions/theme-actions.php");

// TGM Plugin Activation
include( "functions/plugin-activation.php" );

/*-----------------------------------------------------------------------------------
	Function to detect light and dark colors
	Used in to detect color of homepage section and accordigly give them a light or dark border color
-----------------------------------------------------------------------------------*/

//Generates RGB value to be used by HSL function
function mts_HTMLToRGB($htmlCode){
    if($htmlCode[0] == '#')
      $htmlCode = substr($htmlCode, 1);

    if (strlen($htmlCode) == 3) {
      $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
    }

    $r = hexdec($htmlCode[0] . $htmlCode[1]);
    $g = hexdec($htmlCode[2] . $htmlCode[3]);
    $b = hexdec($htmlCode[4] . $htmlCode[5]);

    return $b + ($g << 0x8) + ($r << 0x10);
  }

//Generates the HSL value of corresponding RGB value
function mts_RGBToHSL($RGB) {
    $r = 0xFF & ($RGB >> 0x10);
    $g = 0xFF & ($RGB >> 0x8);
    $b = 0xFF & $RGB;

    $r = ((float)$r) / 255.0;
    $g = ((float)$g) / 255.0;
    $b = ((float)$b) / 255.0;

    $maxC = max($r, $g, $b);
    $minC = min($r, $g, $b);

    $l = ($maxC + $minC) / 2.0;

    if($maxC == $minC){
      $s = 0;
      $h = 0;
    }else{
      if($l < .5){
        $s = ($maxC - $minC) / ($maxC + $minC);
      }else{
        $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
      }
      if($r == $maxC)
        $h = ($g - $b) / ($maxC - $minC);
      if($g == $maxC)
        $h = 2.0 + ($b - $r) / ($maxC - $minC);
      if($b == $maxC)
        $h = 4.0 + ($r - $g) / ($maxC - $minC);

      $h = $h / 6.0; 
    }

    $h = (int)round(255.0 * $h);
    $s = (int)round(255.0 * $s);
    $l = (int)round(255.0 * $l);

    return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
}
// CHeck if the color is of light intensity or dark, based upon the lightness value supplied by HSL conversion
function is_light_color($color){
	$rgb = mts_HTMLToRGB($color);
	$hsl = mts_RGBToHSL($rgb);
	
	return ($hsl->lightness > 200) ? true : false;
}

/*-----------------------------------------------------------------------------------*/
/*	Function to get avg luminence to find the bightness of image
/*-----------------------------------------------------------------------------------*/
function mts_get_avg_luminance($filename, $num_samples=10) {
  $img = imagecreatefromjpeg($filename);

  $width = imagesx($img);
  $height = imagesy($img);

  $x_step = intval($width/$num_samples);
  $y_step = intval($height/$num_samples);

  $total_lum = 0;

  $sample_no = 1;

  for ($x=0; $x<$width; $x+=$x_step) {
	  for ($y=0; $y<$height; $y+=$y_step) {

		  $rgb = imagecolorat($img, $x, $y);
		  $r = ($rgb >> 16) & 0xFF;
		  $g = ($rgb >> 8) & 0xFF;
		  $b = $rgb & 0xFF;

		  // choose a simple luminance formula from here
		  $lum = ($r+$r+$b+$g+$g+$g)/6;
		  $total_lum += $lum;
		  $sample_no++;
	  }
  }
  // work out the average
  $avg_lum  = $total_lum/$sample_no;

  return $avg_lum;
}
function is_light_image($image){
	if(empty($image) || !file_exists($image)) return false;
	
	$luminance = get_avg_luminance($image,10);
	return ($luminance < 170) ? true : false;
}

/*-----------------------------------------------------------------------------------*/
/*	Checks if the blog index page is being displayed
/*-----------------------------------------------------------------------------------*/
function is_blog () {
	global $post;
	$posttype = get_post_type($post );
	return ( ( (is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}

/*-----------------------------------------------------------------------------------*/
/*	Checks if the portfolio index page is being displayed
/*-----------------------------------------------------------------------------------*/
function is_portfolio () {
	global $post;
	$posttype = get_post_type($post );
	return ($posttype == 'portfolio') ? true : false ;
}

/*-----------------------------------------------------------------------------------*/
/*	Filters customize wp_title
/*-----------------------------------------------------------------------------------*/
function mts_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'mythemeshop' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'mts_wp_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*	Javascsript
/*-----------------------------------------------------------------------------------*/
function mts_add_scripts() {
	$mts_options = get_option(MTS_THEME_NAME);
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}else if(empty($homepage_layout)) {
		$homepage_layout = array();
	}
	wp_enqueue_script('jquery');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply', array(), null, true);
	}
	
    if (is_front_page()) {
        wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), null, true);
	    wp_enqueue_script ('isotope');
    }

	global $is_IE;
    if ($is_IE) {
        wp_register_script ('html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js");
        wp_enqueue_script ('html5shim');
	}  
    
}
add_action('wp_enqueue_scripts','mts_add_scripts');
   
function mts_load_footer_scripts() {  
	$mts_options = get_option(MTS_THEME_NAME);

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css', array(), null );

	wp_register_script('customscript', get_template_directory_uri() . '/js/customscript.js', array(), null, true);
	wp_localize_script('customscript', 'mts_customscript', array('ajaxurl' => admin_url('admin-ajax.php')));
	wp_enqueue_script('customscript');
        
	// Slider
    wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), null, true);
    wp_localize_script('owl-carousel', 'slideropts', array('twitter_slider' => $mts_options['homepage_twitter_slider']));
	wp_enqueue_script ('owl-carousel');
	
	$homepage_layout = array();
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}else if(empty($homepage_layout)) {
		$homepage_layout = array('blog' => 'blog');
	}
	
	//Lightbox
	if($mts_options['mts_lightbox'] == '1') {
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), null, true);
		wp_enqueue_script('prettyPhoto');
	}
	
	//Sticky Nav
	if($mts_options['mts_sticky_nav'] == '1') {
		wp_register_script('StickyNav', get_template_directory_uri() . '/js/sticky.js', array(), null, true);
		wp_enqueue_script('StickyNav');
	}

    if(array_key_exists('counter',$homepage_layout) || array_key_exists('slider',$homepage_layout) || array_key_exists('service',$homepage_layout) || array_key_exists('team',$homepage_layout) || array_key_exists('pricing',$homepage_layout) || array_key_exists('testimonial',$homepage_layout) || array_key_exists('clients',$homepage_layout) || array_key_exists('contact',$homepage_layout) || array_key_exists('twitter',$homepage_layout) || array_key_exists('feature',$homepage_layout)){
        wp_enqueue_script( 'parallax-js', get_template_directory_uri() . '/js/jquery.parallax.min.js', array(), null, true);
    }
    
    // Ajax Load More and Search Results
    wp_register_script('mts_ajax', get_template_directory_uri() . '/js/ajax.js', array(), null, true);
	if(!empty($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] >= 2) {
		wp_enqueue_script('mts_ajax');
        
        wp_register_script('historyjs', get_template_directory_uri() . '/js/history.js', array(), null, true);
        wp_enqueue_script('historyjs');
        
        // Add parameters for the JS
        global $wp_query;
        $max = $wp_query->max_num_pages;
        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
        if ($max == 0) {
        	$my_query = new WP_Query(array('post_type' => 'post'));
        	$max = $my_query->max_num_pages;
        	wp_reset_query();
        }
        $autoload = ($mts_options['mts_pagenavigation_type'] == 3);
        wp_localize_script(
        	'mts_ajax',
        	'mts_ajax_loadposts',
        	array(
        		'startPage' => $paged,
        		'maxPages' => $max,
        		'nextLink' => next_posts($max, false),
                'autoLoad' => $autoload,
                'i18n_loadmore' => __('Load More Posts', 'mythemeshop'),
                'i18n_loading' => __('Loading...', 'mythemeshop'),
                'i18n_nomore' => __('No more posts.', 'mythemeshop')
        	)
        );
	}
    if(!empty($mts_options['mts_ajax_search'])) {
        wp_enqueue_script('mts_ajax');
        wp_localize_script(
        	'mts_ajax',
        	'mts_ajax_search',
        	array(
				'url' => admin_url('admin-ajax.php'),
        		'ajax_search' => '1'
        	)
        );
        
    }

    
}  
add_action('wp_footer', 'mts_load_footer_scripts');

if(!empty($mts_options['mts_ajax_search'])) {
    add_action('wp_ajax_mts_search', 'ajax_mts_search');
    add_action('wp_ajax_nopriv_mts_search', 'ajax_mts_search');
}

function mts_nojs_js_class() {
    echo '<script type="text/javascript">document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,\'js\');</script>';
}
add_action('wp_head', 'mts_nojs_js_class');

/*-----------------------------------------------------------------------------------*/
/* Enqueue CSS
/*-----------------------------------------------------------------------------------*/
function mts_enqueue_css() {
	$mts_options = get_option(MTS_THEME_NAME);
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}else if(empty($homepage_layout)) {
		$homepage_layout = array();
	}

	// Slider
    // register_style() taken out of IF() to be able to enqueue it from the slider widget
    wp_register_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), null);
	wp_enqueue_style('owl-carousel');
	
	//lightbox
	if($mts_options['mts_lightbox'] == '1') {
		wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), null);
		wp_enqueue_style('prettyPhoto');
	}

	wp_enqueue_style('stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), null);
	
        wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css', array(), null);
	
    $mts_bg = '';
	if ($mts_options['mts_bg_pattern_upload'] != '') {
		$mts_bg = $mts_options['mts_bg_pattern_upload'];
	} else {
		if(!empty($mts_options['mts_bg_pattern'])) {
			$mts_bg = get_template_directory_uri().'/images/'.$mts_options['mts_bg_pattern'].'.png';
		}
	}
    $mts_header_bg = '';
	if ($mts_options['mts_header_background_pattern_upload'] != '') {
		$mts_header_bg = $mts_options['mts_header_background_pattern_upload'];
	} else {
		if(!empty($mts_options['mts_header_background_pattern'])) {
			$mts_header_bg = get_template_directory_uri().'/images/'.$mts_options['mts_header_background_pattern'].'.png';
		}
	}
    $mts_footer_bg = '';
	if ($mts_options['mts_footer_background_pattern_upload'] != '') {
		$mts_footer_bg = $mts_options['mts_footer_background_pattern_upload'];
	} else {
		if(!empty($mts_options['mts_footer_background_pattern'])) {
			$mts_footer_bg = get_template_directory_uri().'/images/'.$mts_options['mts_footer_background_pattern'].'.png';
		}
	}
	$mts_sclayout = '';
	$mts_author = '';
	$mts_header_section = '';
    if (is_page() || is_single()) {
        $mts_sidebar_location = get_post_meta( get_the_ID(), '_mts_sidebar_location', true );
    } else {
        $mts_sidebar_location = '';
    }
	if ($mts_sidebar_location != 'right' && ($mts_options['mts_layout'] == 'sclayout' || $mts_sidebar_location == 'left')) {
		$mts_sclayout = '.article, div#content_box.sidebar_layout { float: right;}
		.sidebar.c-4-12 { float: left; padding-right: 0; }';
	}
	if ($mts_options['mts_header_section2'] == '0') {
		$mts_header_section = '.logo-wrap, .widget-header { display: none; } .secondary-navigation {float: left; margin-left: 0; }';
	}
	if($mts_options['mts_author_comment'] == '1') {
		$mts_author = '.bypostauthor:after { content: "'.__('Author','mythemeshop').'"; position: absolute; right: 0px; top:4px; padding: 1px 10px; background: #818181; color: #FFF; }';
	}
	
	$custom_css = "
		body {background-color:{$mts_options['mts_bg_color']}; }
		body {background-image: url({$mts_bg});}
        .main-header, #navigation ul ul { background-color:{$mts_options['mts_header_background_color']}; background-image: url({$mts_header_bg}); box-shadow: 0 4px {$mts_options['mts_header_background_color']}; }
        footer { background-color:{$mts_options['mts_footer_background_color']}; background-image: url({$mts_footer_bg}); box-shadow: 0 -4px 0 {$mts_options['mts_footer_background_color']}; }
        body.home #homepage-title-slider { background-image: url({$mts_options['mts_homepage_background_image']}); }
        
        .pace .pace-progress, #mobile-menu-wrapper ul li a:hover, .blog-title { background: {$mts_options['mts_color_scheme']}; }
		.postauthor h5, .copyrights a, .single_post a, .textwidget a, .pnavigation2 a, .sidebar.c-4-12 a:hover, .copyrights a:hover, footer .widget li a:hover, .sidebar.c-4-12 a:hover, .related-posts a:hover, .reply a, .title a:hover, .post-info a:hover, #tabber .inside li a:hover, .readMore a:hover, .fn a, a, a:hover,.counter-item .count,.homepage-twitter .mts_recent_tweets .twitter_username,#portfolio-grid .item a.expand-view .overlay span,#pricing_tables ul li.highlight .price,#navigation ul ul li > a:hover,.feature-icon span.fa, .single_post .single-title a:hover { color:{$mts_options['mts_color_scheme']}; }	
		
		footer{border-top: 1px solid {$mts_options['mts_color_scheme']};}
		.tagcloud a:hover:after{border-right-color:{$mts_options['mts_color_scheme']};}

        .main-header { border-bottom: 1px solid {$mts_options['mts_color_scheme']}; }
        #navigation ul li:hover,
        #navigation ul li.current-menu-item,
        #navigation ul li.current_page_parent { border-bottom: 3px solid {$mts_options['mts_color_scheme']}; color: {$mts_options['mts_color_scheme']}; }
		
		#homepage-features .feature-icon .arrow ,#homepage-service .service-icon .arrow { border-top-color: {$mts_options['mts_color_scheme']}; }

        #service_slides .owl-buttons div:hover,#homepage-testimonials .owl-buttons div:hover, .team-member-contact i:hover, .homepage-button:hover, .widget_wpt .tab_title.selected a, nav a#pull, #commentform input#submit, .contactform #submit, .mts-subscribe input[type='submit'], #move-to-top:hover, #searchform .icon-search, .pagination a, #load-posts a, .widget_wpt ul.wpt-tabs li.selected a, .widget_wp_review_tab ul.wp-review-tabs li.selected a, .tagcloud a:hover, #navigation ul .sfHover a, #search-image.sbutton, #searchsubmit,.social_icons a:hover,.team-member .team-member-contact i:hover,#filters li a.selected,#portfolio-grid .item a.expand-view .overlay,#pricing_tables ul li .table_title,#pricing_tables ul li.highlight .table_button > a,#mtscontact_form > #mtscontact_submit,.blog-title,.postcontent .meta span a:hover, .service-icon span.fa, .widget-content a:hover + .posts-number, .ajax-pagination .paginate-link:hover, .ajax-pagination .paginate-link.current, div.slider-overlay, .latestPost-review-wrapper { background-color:{$mts_options['mts_color_scheme']}; color: #fff!important; }
		.widget-content a:hover + .posts-number, .ajax-pagination .paginate-link:hover, .ajax-pagination .paginate-link.current { border-color: {$mts_options['mts_color_scheme']}; }
		{$mts_sclayout}
		{$mts_author}
		{$mts_header_section}
		{$mts_options['mts_custom_css']}
			";
	wp_add_inline_style( 'stylesheet', $custom_css );
}
add_action('wp_enqueue_scripts', 'mts_enqueue_css', 99);

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
add_filter('the_content_rss', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mts_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" style="position:relative;">
            <div class="comment-author-avatar">
                <?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
            </div>
            <div class="comment-data">
    			<div class="comment-author vcard">
    				<?php printf(__('By <span class="fn">%s</span>    ', 'mythemeshop'), get_comment_author_link()) ?> 
    				<?php $mts_options = get_option(MTS_THEME_NAME); if($mts_options['mts_comment_date'] == '1') { ?>
    					<span class="ago" style="margin-left:10px;"><?php _e(" Posted on ","mythemeshop"); ?><?php comment_date(get_option( 'date_format' )); ?></span>
    				<?php } ?>
    				<span class="comment-meta">
    					<?php edit_comment_link(__('(Edit)', 'mythemeshop'),'  ','') ?>
    				</span>
    			</div>
    			<?php if ($comment->comment_approved == '0') : ?>
    				<em><?php _e('Your comment is awaiting moderation.', 'mythemeshop') ?></em>
    				<br />
    			<?php endif; ?>
    			<div class="thecomment">
    				<?php comment_text() ?>
    				<div class="reply">
    					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    				</div>
    			</div>
            </div>
		</div>
	</li>
<?php }

/*-----------------------------------------------------------------------------------*/
/*	excerpt
/*-----------------------------------------------------------------------------------*/
function mts_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return '<p>'.$excerpt.'</p>';
}

/*-----------------------------------------------------------------------------------*/
/*	Remove more link from the_content and use custom read more
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_content_more_link', 'mts_remove_more_link', 10, 2 );
function mts_remove_more_link( $more_link, $more_link_text ) {
	return '';
}
// shorthand function to check for more tag in post
function mts_post_has_moretag() {
    global $post;
    return strpos($post->post_content, '<!--more-->');
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
function mts_pagination_add_nofollow($content) {
    return 'rel="nofollow"';
}
add_filter('next_posts_link_attributes', 'mts_pagination_add_nofollow' );
add_filter('previous_posts_link_attributes', 'mts_pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/
/* Nofollow to category links
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'mts_add_nofollow_cat' ); 
function mts_add_nofollow_cat( $text ) {
	$text = str_replace('rel="category tag"', 'rel="nofollow"', $text); return $text;
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow post author link
/*-----------------------------------------------------------------------------------*/
add_filter('the_author_posts_link', 'mts_nofollow_the_author_posts_link');
function mts_nofollow_the_author_posts_link ($link) {
	return str_replace('<a href=', '<a rel="nofollow" href=',$link); 
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow to reply links
/*-----------------------------------------------------------------------------------*/
function mts_add_nofollow_to_reply_link( $link ) {
	return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'mts_add_nofollow_to_reply_link' );

/*-----------------------------------------------------------------------------------*/
/* removes the WordPress version from your header for security
/*-----------------------------------------------------------------------------------*/
function wb_remove_version() {
	return '<!--Theme by MyThemeShop.com-->';
}
add_filter('the_generator', 'wb_remove_version');
	
/*-----------------------------------------------------------------------------------*/
/* Removes Trackbacks from the comment count
/*-----------------------------------------------------------------------------------*/
add_filter('get_comments_number', 'mts_comment_count', 0);
function mts_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$approved_comments = get_comments('status=approve&post_id=' . $id);
		$comments_by_type = separate_comments($approved_comments);
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

/*-----------------------------------------------------------------------------------*/
/* adds a class to the post if there is a thumbnail
/*-----------------------------------------------------------------------------------*/
function has_thumb_class($classes) {
	global $post;
	if( has_post_thumbnail($post->ID) ) { $classes[] = 'has_thumb'; }
		return $classes;
}
add_filter('post_class', 'has_thumb_class');

/*-----------------------------------------------------------------------------------*/	
/* Breadcrumb
/*-----------------------------------------------------------------------------------*/
function mts_the_breadcrumb() {
	echo '<a href="';
	echo home_url();
	echo '" rel="nofollow"><i class="icon-home"></i>&nbsp;'.__('Home','mythemeshop');
	echo "</a>";
	if (is_category() || is_single()) {
		echo "&nbsp;<i class=\"fa fa-angle-right\"></i>&nbsp;";
		the_category(' & ');
			if (is_single()) {
				echo "&nbsp;<i class=\"fa fa-angle-right\"></i>&nbsp;";
				the_title();
			}
	} elseif (is_page()) {
		echo "&nbsp;<i class=\"fa fa-angle-right\"></i>&nbsp;";
		echo the_title();
	} elseif (is_search()) {
		echo "&nbsp;<i class=\"fa fa-angle-right\"></i>&nbsp;".__('Search Results for','mythemeshop')."... ";
		echo '"<em>';
		echo the_search_query();
		echo '</em>"';
	}
}

/*-----------------------------------------------------------------------------------*/	
/* Pagination
/*-----------------------------------------------------------------------------------*/
function mts_pagination($pages = '', $range = 3) { 
	$showitems = ($range * 3)+1;
	global $paged; if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query; $pages = $wp_query->max_num_pages; 
		if(!$pages){ $pages = 1; } 
	}
	if(1 != $pages) { 
		echo "<div class='pagination'><ul>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link(1)."'>&laquo; ".__('First','mythemeshop')."</a></li>";
		if($paged > 1 && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link($paged - 1)."' class='inactive'>&lsaquo; ".__('Previous','mythemeshop')."</a></li>";
		for ($i=1; $i <= $pages; $i++){ 
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) { 
				echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a rel='nofollow' href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
			} 
		} 
		if ($paged < $pages && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link($paged + 1)."' class='inactive'>".__('Next','mythemeshop')." &rsaquo;</a></li>";
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
			echo "<li><a rel='nofollow' class='inactive' href='".get_pagenum_link($pages)."'>".__('Last','mythemeshop')." &raquo;</a></li>";
			echo "</ul></div>"; 
	}
}

/*-----------------------------------------------------------------------------------*/	
/* AJAX Search results
/*-----------------------------------------------------------------------------------*/
function ajax_mts_search() {
    $query = $_REQUEST['q'];//esc_html($_REQUEST['q']);
    // No need to esc as WP_Query escapes data before performing the database query
    $search_query = new WP_Query(array('s' => $query, 'posts_per_page' => 3));
    $search_count = new WP_Query(array('s' => $query, 'posts_per_page' => -1));
    $search_count = $search_count->post_count;
    if (!empty($query) && $search_query->have_posts()) : 
        //echo '<h5>Results for: '. $query.'</h5>';
        echo '<ul class="ajax-search-results">';
        while ($search_query->have_posts()) : $search_query->the_post();
            ?><li>
    			<a href="<?php the_permalink(); ?>">
					<?php if(has_post_thumbnail()): ?>
						<?php the_post_thumbnail('widgetthumb',array('title' => '')); ?>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" alt="<?php the_title(); ?>" class="attachment-widgetthumb wp-post-image" />
					<?php endif; ?>
                    
    				<?php the_title(); ?>	
    			</a>
    			<div class="meta">
    					<span class="thetime"><?php the_time('F j, Y'); ?></span>
    			</div> <!-- / .meta -->

    		</li>	
    		<?php
        endwhile;
        echo '</ul>';
        echo '<div class="ajax-search-meta"><span class="results-count">'.$search_count.' '.__('Results', 'mythemeshop').'</span><a href="'.get_search_link($query).'" class="results-link">Show all results</a></div>';
    else:
        echo '<div class="no-results">'.__('No results found.', 'mythemeshop').'</div>';
    endif;
        
    exit; // required for AJAX in WP
}
/*-----------------------------------------------------------------------------------*/
/* Redirect feed to feedburner
/*-----------------------------------------------------------------------------------*/

if ( $mts_options['mts_feedburner'] != '') {
function mts_rss_feed_redirect() {
    $mts_options = get_option(MTS_THEME_NAME);
    global $feed;
    $new_feed = $mts_options['mts_feedburner'];
    if (!is_feed()) {
            return;
    }
    if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])){
            return;
    }
    if ($feed != 'comments-rss2') {
            if (function_exists('status_header')) status_header( 302 );
            header("Location:" . $new_feed);
            header("HTTP/1.1 302 Temporary Redirect");
            exit();
    }
}
add_action('template_redirect', 'mts_rss_feed_redirect');
}

/*-----------------------------------------------------------------------------------*/
/* Single Post Pagination
/*-----------------------------------------------------------------------------------*/
function mts_wp_link_pages_args_prevnext_add($args)
{
    global $page, $numpages, $more, $pagenow;
    if (!$args['next_or_number'] == 'next_and_number')
        return $args; 
    $args['next_or_number'] = 'number'; 
    if (!$more)
        return $args; 
    if($page-1) 
        $args['before'] .= _wp_link_page($page-1)
        . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'
    ;
    if ($page<$numpages) 
    
        $args['after'] = _wp_link_page($page+1)
        . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
        . $args['after']
    ;
    return $args;
}
add_filter('wp_link_pages_args', 'mts_wp_link_pages_args_prevnext_add');


/*-----------------------------------------------------------------------------------*/
/* add <!-- next-page --> button to tinymce
/*-----------------------------------------------------------------------------------*/
add_filter('mce_buttons','wysiwyg_editor');
function wysiwyg_editor($mce_buttons) {
   $pos = array_search('wp_more',$mce_buttons,true);
   if ($pos !== false) {
       $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
       $tmp_buttons[] = 'wp_page';
       $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
   }
   return $mce_buttons;
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'mts_custom_gravatar' ) ) {
    function mts_custom_gravatar( $avatar_defaults ) {
        $mts_avatar = get_template_directory_uri() . '/images/gravatar.png';
        $avatar_defaults[$mts_avatar] = 'Custom Gravatar (/images/gravatar.png)';
        return $avatar_defaults;
    }
    add_filter( 'avatar_defaults', 'mts_custom_gravatar' );
}

/*-----------------------------------------------------------------------------------*/
/*	Sidebar Selection meta box
/*-----------------------------------------------------------------------------------*/
function mts_add_sidebar_metabox() {

    $screens = array('post', 'page');

    foreach ($screens as $screen) {
        add_meta_box(
            'mts_sidebar_metabox',                  // id
            __('Sidebar', 'mythemeshop'),    // title
            'mts_inner_sidebar_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                               // priority (high, core, default, low)
                                                    // callback args ($post passed by default)
        );
    }
}
add_action('add_meta_boxes', 'mts_add_sidebar_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_sidebar_metabox($post) {
    global $wp_registered_sidebars;
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_sidebar_metabox', 'mts_inner_sidebar_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $custom_sidebar = get_post_meta( $post->ID, '_mts_custom_sidebar', true );
    $sidebar_location = get_post_meta( $post->ID, '_mts_sidebar_location', true );

    // Select custom sidebar from dropdown
    echo '<select name="mts_custom_sidebar" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $custom_sidebar).'>Default</option>';
    
    // Exclude built-in sidebars
    $hidden_sidebars = array('sidebar', 'footer-top-1', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom-1', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4');    
    
    foreach ($wp_registered_sidebars as $sidebar) {
        if (!in_array($sidebar['id'], $hidden_sidebars)) {
            echo '<option value="'.esc_attr($sidebar['id']).'" '.selected($sidebar['id'], $custom_sidebar, false).'>'.$sidebar['name'].'</option>';
        }
    }
echo '<option value="mts_nosidebar" '.selected('mts_nosidebar', $custom_sidebar).'>'.__('No sidebar (full width content)', 'mythemeshop').'</option>';
    echo '</select><br />';
    
    // Select single layout (left/right sidebar)
    echo '<label for="mts_sidebar_location_default" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_default" value=""'.checked('', $sidebar_location, false).'>Default side</label>';
    echo '<label for="mts_sidebar_location_left" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_left" value="left"'.checked('left', $sidebar_location, false).'>Left</label>';
    echo '<label for="mts_sidebar_location_right" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_right" value="right"'.checked('right', $sidebar_location, false).'>Right</label>';
     
    //debug
    global $wp_meta_boxes;
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function mts_save_custom_sidebar( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_sidebar_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_sidebar_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_sidebar_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $sidebar_name = sanitize_text_field( $_POST['mts_custom_sidebar'] );
    $sidebar_location = sanitize_text_field( $_POST['mts_sidebar_location'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_custom_sidebar', $sidebar_name );
    update_post_meta( $post_id, '_mts_sidebar_location', $sidebar_location );
}
add_action( 'save_post', 'mts_save_custom_sidebar' );


/*-----------------------------------------------------------------------------------*/
/*	Create portfolio post type
/*-----------------------------------------------------------------------------------*/

function mts_portfolio_register() {  
    $args = array(  
        'label' => __('Portfolio', 'mythemeshop'),  
        'singular_label' => __('Project', 'mythemeshop'),  
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => false,
		'publicly_queryable' => true,
		'query_var' => true,
		'menu_position' => 5,
        'menu_icon' => 'dashicons-id',
		'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail')  
       );    
register_post_type( 'portfolio' , $args );
register_taxonomy("skills", array("portfolio"), array("hierarchical" => true, "label" => "Skills", "singular_label" => "Skill", "rewrite" => true));	
}  
add_action('init', 'mts_portfolio_register');  

/*-----------------------------------------------------------------------------------*/
/*	CREATE AND SHOW COLUMN FOR FEATURED IN PORTFOLIO ITEMS LIST ADMIN PAGE
/*-----------------------------------------------------------------------------------*/

//Get Featured image
function mts_get_featured_image($post_ID) {  
	$post_thumbnail_id = get_post_thumbnail_id($post_ID);  
	if ($post_thumbnail_id) {  
		$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'widgetfull');  
		return $post_thumbnail_img[0];  
	}  
} 
function mts_columns_head($defaults) {  
	$defaults['featured_image'] = 'Featured Image';
	return $defaults;  
}  
function mts_columns_content($column_name, $post_ID) {  
	if ($column_name == 'featured_image') {  
		$post_featured_image = mts_get_featured_image($post_ID);  
		if ($post_featured_image) {  
			echo '<img width="150" height="88" src="' . $post_featured_image . '" />';  
		}  
	}  
} 
add_filter('manage_posts_columns', 'mts_columns_head');  
add_action('manage_posts_custom_column', 'mts_columns_content', 10, 2);  
 
 
/*-----------------------------------------------------------------------------------*/
/*	CREATE AND SHOW COLUMN FOR SKILLS IN PORTFOLIO ITEMS LIST ADMIN PAGE
/*-----------------------------------------------------------------------------------*/

function mts_columns_head_only_portfolio($defaults) {  
	$defaults['skill'] = 'Skills';  
	return $defaults;  
}  
function mts_columns_content_only_portfolio($column_name, $post_ID) {  
	if ($column_name == 'skill') {  
		$terms = wp_get_post_terms($post_ID,'skills');
		$count = count($terms);
		if ( $count > 0 ){
			foreach ( $terms as $term ) {
				echo '<a>'. $term->name . "</a>,";
			}
		}
	}  
}
add_filter('manage_portfolio_posts_columns', 'mts_columns_head_only_portfolio', 10);  
add_action('manage_portfolio_posts_custom_column', 'mts_columns_content_only_portfolio', 10, 2);

/*-----------------------------------------------------------------------------------*/
/*	Helpful function to see if a number is a multiple of another number
/*-----------------------------------------------------------------------------------*/

function is_multiple($number, $multiple) { 
    return ($number % $multiple) == 0; 
} 

/*-----------------------------------------------------------------------------------*/
/*	Global Twitter section functions 
/*-----------------------------------------------------------------------------------*/

function mts_getConnectionWithhomepage_twitter_access_token($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
} 

//convert links to clickable format
function mts_convert_links($status,$targetBlank=true,$linkMaxLen=250){
	$target=$targetBlank ? " target=\"_blank\" " : ""; // the target
	$status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status); // convert link to url
	$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status); // convert @ to follow
	$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status); // convert # to search
	return $status; // return the status
}

//convert dates to readable format	
function relative_time($a) {			
	$b = strtotime("now");  //get current timestampt
	$c = strtotime($a); //get timestamp when tweet created
	$d = $b - $c; //get difference
	$minute = 60; //calculate different time values
	$hour = $minute * 60;
	$day = $hour * 24;
	$week = $day * 7;				
	if(is_numeric($d) && $d > 0) {				
		if($d < 3) return "right now"; //if less then 3 seconds
		if($d < $minute) return floor($d) . " seconds ago"; //if less then minute
		if($d < $minute * 2) return "about 1 minute ago"; //if less then 2 minutes
		if($d < $hour) return floor($d / $minute) . " minutes ago"; //if less then hour
		if($d < $hour * 2) return "about 1 hour ago"; //if less then 2 hours
		if($d < $day) return floor($d / $hour) . " hours ago"; //if less then day
		if($d > $day && $d < $day * 2) return "yesterday"; //if more then day, but less then 2 days
		if($d < $day * 365) return floor($d / $day) . " days ago"; //if less then year
		return "over a year ago"; //else return more than a year
	}
}			
			
/*-----------------------------------------------------------------------------------*/
/*	Add additional fields to user profile in admin panel
/*-----------------------------------------------------------------------------------*/

function mts_user_contactmethods($user_contactmethods){
  $user_contactmethods['twitter'] = __('Twitter Username', 'mythemeshop');
  $user_contactmethods['google_plus'] = __('Google plus profile', 'mythemeshop');
  $user_contactmethods['facebook'] = __('Facebook Url', 'mythemeshop');

  return $user_contactmethods;
}
add_filter('user_contactmethods', 'mts_user_contactmethods');  


/*-----------------------------------------------------------------------------------*/
/*	AJAX Contact Form - mts_contact_form()
/*-----------------------------------------------------------------------------------*/
class mtscontact {
    public $errors = array();
    public $userinput = array('name' => '', 'email' => '', 'subject' => '', 'message' => '');
    public $success = false;
    
    public function __construct() {
        add_action('wp_ajax_mtscontact', array($this, 'ajax_mtscontact'));
        add_action('wp_ajax_nopriv_mtscontact', array($this, 'ajax_mtscontact'));
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
    }
    public function ajax_mtscontact() {
        if ($this->validate()) {
            if ($this->send_mail()) {
                echo json_encode('success');
                wp_create_nonce( "mtscontact" ); // purge used nonce
            } else {
                // wp_mail() unable to send
                $this->errors['sendmail'] = __('An error occurred. Please contact site administrator.', 'mythemeshop');
                echo json_encode($this->errors);
            }
        } else {
            echo json_encode($this->errors);
        }
        die();
    }
    public function init() {
        // No-js fallback
        if ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) {
            if (!empty($_POST['action']) && $_POST['action'] == 'mtscontact') {
                if ($this->validate()) {
                    if (!$this->send_mail()) {
                        $this->errors['sendmail'] = __('An error occurred. Please contact site administrator.', 'mythemeshop');
                    } else {
                        $this->success = true;
                        wp_create_nonce( "mtscontact" ); // purge used nonce
                    }
                }
            }
        }
    }
    public function register_scripts() {
        wp_register_script('mtscontact', get_template_directory_uri() . '/js/contact.js', array(), null, true);
        wp_localize_script('mtscontact', 'mtscontact', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
    
    private function validate() {
        // check nonce
        if (!check_ajax_referer( 'mtscontact', 'mtscontact_nonce', false )) {
            $this->errors['nonce'] = __('Please try again.', 'mythemeshop');
        }
        
        // check honeypot // must be empty
        if (!empty($_POST['mtscontact_captcha'])) {
            $this->errors['captcha'] = __('Please try again.', 'mythemeshop');
        }
        
        // name field
        $name = trim(str_replace(array("\n", "\r", "<", ">"), '', strip_tags($_POST['mtscontact_name'])));
        if (empty($name)) {
            $this->errors['name'] = __('Please enter your name.', 'mythemeshop');
        }
        
        // email field
        $useremail = trim($_POST['mtscontact_email']);
        if (!is_email($useremail)) {
            $this->errors['email'] = __('Please enter a valid email address.', 'mythemeshop');
        }
 
        // Subject
        $subject = trim($_POST['mtscontact_subject']);
        if (empty($subject)) {
            $this->errors['subject'] = __('Please enter a Subject line.', 'mythemeshop');
        }

        // message field
        $message = strip_tags($_POST['mtscontact_message']);
        if (empty($message)) {
            $this->errors['message'] = __('Please enter a message.', 'mythemeshop');
        }
        
        // store fields for no-js
        $this->userinput = array('name' => $name, 'email' => $useremail, 'subject' => $subject, 'message' => $message);
        
        return empty($this->errors);
    }
    private function send_mail() {
        $email_to = get_option('admin_email');
	$email_subject = $this->userinput['subject'];
        $email_message = __('Name:', 'mythemeshop').' '.$this->userinput['name']."\n\n".
                         __('Email:', 'mythemeshop').' '.$this->userinput['email']."\n\n".
                         __('Subject:', 'mythemeshop').' '.$this->userinput['subject']."\n\n".
                         __('Message:', 'mythemeshop').' '.$this->userinput['message'];
        return wp_mail($email_to, $email_subject, $email_message);
    }
    public function display_form() {
        wp_enqueue_script('mtscontact');
        $this->display_errors();
        if (!$this->success) {
        ?>
        <form method="post" action="" id="mtscontact_form" class="contact-form">
            <input type="text" name="mtscontact_captcha" value="" style="display: none;" />
            <input type="hidden" name="mtscontact_nonce" value="<?php echo wp_create_nonce( "mtscontact" ) ?>" />
            <input type="hidden" name="action" value="mtscontact" />
            
            <input placeholder="<?php _e('Your Name*', 'mythemeshop'); ?>" type="text" name="mtscontact_name" value="<?php echo esc_attr($this->userinput['name']); ?>" id="mtscontact_name" />
            
            <input placeholder="<?php _e('Your Email Address*', 'mythemeshop'); ?>" type="text" name="mtscontact_email" value="<?php echo esc_attr($this->userinput['email']); ?>" id="mtscontact_email" />
            
            <input placeholder="<?php _e('Subject*', 'mythemeshop'); ?>" type="text" name="mtscontact_subject" value="<?php echo esc_attr($this->userinput['subject']); ?>" id="mtscontact_subject" />
            
            <textarea placeholder="<?php _e('Message*', 'mythemeshop'); ?>" name="mtscontact_message" id="mtscontact_message"><?php echo esc_textarea($this->userinput['message']); ?></textarea>
            
            <input type="submit" value="<?php _e('Send Message', 'mythemeshop'); ?>" id="mtscontact_submit" />
        </form>
        <?php 
        } 
        ?>
        
        <div id="mtscontact_success"<?php echo ($this->success ? '' : ' style="display: none;"') ?>><?php _e('Your message has been sent.', 'mythemeshop'); ?></div>
        <?php
    }
    public function display_errors() {
        $html = '';
        foreach ($this->errors as $error) {
            $html .= '<div class="mtscontact_error">'.$error.'</div>';
        }
        echo $html;
    }
}
$mts_contact = new mtscontact;
// Simple wrapper, to be used in template files
function mts_contact_form() {
    global $mts_contact;
    $mts_contact->display_form();
}

?>