<?php

function singlepage_setup(){
	global $content_width;
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('singlepage', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		'default-repeat' => 'no-repeat',
        'default-text-color'     => 'eeeeee',
		'url'                    => '',
        'width'                  => 1920,
        'height'                 => 89,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	register_nav_menus( array('primary' => __( 'Primary Menu', 'singlepage' )));
	add_editor_style("editor-style.css");
	add_image_size( 'blog', 609, 214 , true);
	if ( !isset( $content_width ) ) $content_width = 1170;
}

add_action( 'after_setup_theme', 'singlepage_setup' );


 function singlepage_custom_scripts(){
	 global $is_IE;
	
	wp_enqueue_style('singlepage-font-awesome',  get_template_directory_uri() .'/css/font-awesome.min.css', false, '4.2.0', false);
	wp_enqueue_style('singlepage-bootstrap',  get_template_directory_uri() .'/css/bootstrap.css', false, '4.0.3', false);
	wp_enqueue_style( 'singlepage-main', get_stylesheet_uri(), array(), '1.1.0' );
	
	wp_enqueue_script( 'singlepage-bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', false );
	wp_enqueue_script( 'singlepage-respond', get_template_directory_uri().'/js/respond.min.js', array( 'jquery' ), '1.4.2', false );
	wp_enqueue_script( 'singlepage-modernizr', get_template_directory_uri().'/js/modernizr.custom.js', array( 'jquery' ), '2.8.2', false );
	wp_enqueue_script( 'singlepage-easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3 ', false );
	wp_enqueue_script( 'singlepage-main', get_template_directory_uri().'/js/common.js', array( 'jquery' ), '1.1.0 ', true );
	
	if( $is_IE ) {
	wp_enqueue_script( 'singlepage-html5', get_template_directory_uri().'/js/html5.js', array( 'jquery' ), '', false );
	}
	wp_localize_script( 'singlepage-main', 'singlepage_params',  array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
		)  );
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
		
		
	
	$background_array  = of_get_option("blog_background");
    $blog_background   = singlepage_get_background($background_array);
	
	$singlepage_custom_css   =  esc_html(of_get_option("custom_css"));
	$singlepage_custom_css  .=  'body#template-site{'.esc_html($blog_background).'}';
	
	 if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
     $header_color           =  ' color:#' . get_header_textcolor() . ';';
	 $singlepage_custom_css .=  '.site-name,.site-tagline{'.$header_color.'}';
		}
	$home_nav_menu_color        = of_get_option("home_nav_menu_color",'#c2d5eb');
	$home_nav_menu_hover_color  = of_get_option("home_nav_menu_hover_color",'#ffffff');
	$singlepage_custom_css     .=  '#featured-template .nav li a{color:'.$home_nav_menu_color.'}';
	$singlepage_custom_css     .=  '#featured-template .nav .cur a{color:'.$home_nav_menu_hover_color.'}';
	
	$home_side_nav_menu_color         = of_get_option("home_side_nav_menu_color",'#dcecff');
	$home_side_nav_menu_active_color  = of_get_option("home_side_nav_menu_active_color",'#23dd91');
	$singlepage_custom_css           .=  '.sub_nav li{color:'.$home_side_nav_menu_color.'}';
	$singlepage_custom_css           .=  '.sub_nav .cur{color:'.$home_side_nav_menu_active_color.'}';
	
	
	wp_add_inline_style( 'singlepage-main', $singlepage_custom_css );
	
	}

 function singlepage_admin_scripts(){
	 if(isset($_GET['page']) && $_GET['page'] == 'singlepage-options'){
	wp_enqueue_script( 'singlepage-admin', get_template_directory_uri().'/js/admin.js', array( 'jquery' ), '1.0.2', true );
	wp_enqueue_style('singlepage-admin',  get_template_directory_uri() .'/css/admin.css', false, '1.0.2', false);
	 }
  }

  add_action( 'wp_enqueue_scripts', 'singlepage_custom_scripts' );
  add_action( 'admin_enqueue_scripts', 'singlepage_admin_scripts' );


