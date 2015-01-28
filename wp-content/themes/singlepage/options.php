<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	if( is_child_theme() ){	
		$themename = str_replace("_child","",$themename ) ;
		}
	return $themename;
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {


    $imagepath =  get_template_directory_uri() . '/images/';
	 
	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);
   $blog_background = array(
		'color' => '',
		'image' => $imagepath.'blog-background.jpg',
		'repeat' => 'repeat-y',
		'position' => 'top left',
		'attachment'=>'fixed');
   

	

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'singlepage'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Upload Logo', 'singlepage'),
		'id' => 'logo',
		'std' => '',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Favicon', 'singlepage'),
		'desc' => sprintf(__('An icon associated with a URL that is variously displayed, as in a browser\'s address bar or next to the site name in a bookmark list. Learn more about <a href="%s" target="_blank">Favicon</a>', 'singlepage'),esc_url("http://en.wikipedia.org/wiki/Favicon")),
		'id' => 'favicon',
		'type' => 'upload');
	
	$options[] = array('name' =>  __('Blog Page Background', 'singlepage'),'id' => 'blog_background','std' => $blog_background,'type' => 'background' );
	
	$options[] = array(
		'name' => __('404 Page Content', 'singlepage'),
		'id' => 'page_404_content',
		'std' => '<div class="text-center">
                                    <img class="img-404" src="'.$imagepath .'404.png" alt="404 not found" />
                                    <br/> <br/>
                                    <a href="'.esc_url(home_url("/")).'"><i class="fa fa-home"></i> Please, return to homepage!</a>
                                    </div>',
		'type' => 'editor');
	
	$options[] = array(
		'name' => __('Custom CSS', 'singlepage'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'singlepage'),
		'id' => 'custom_css',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');
	
		
     $options[] = array(
		'name' => __('Home Page', 'singlepage'),
		'type' => 'heading');
	 
	 $options[] = array(
		'name' => __('Enable Featured Homepage', 'singlepage'),
		'desc' => __('Active featured homepage Layout.  The standardized way of creating Static Front Pages: <a href="'.esc_url('http://codex.wordpress.org/Creating_a_Static_Front_Page').'" target="_blank">Creating a Static Front Page</a>', 'singlepage'),
		'id' => 'enable_home_page',
		'std' => '1',
		'type' => 'checkbox');
	 
	 $options[] = array('name' => __('Top Nav Menu Color', 'singlepage'),'id' => 'home_nav_menu_color','std' => '#c2d5eb' ,'type'=> 'color');
	 $options[] = array('name' => __('Top Nav Menu Mouseover Color', 'singlepage'),'id' => 'home_nav_menu_hover_color' ,'std' => '#ffffff','type'=> 'color');
	 
	 $options[] = array('name' => __('Side Nav Menu Color', 'singlepage'),'id' => 'home_side_nav_menu_color','std' => '#dcecff' ,'type'=> 'color');
	 $options[] = array('name' => __('Side Nav Menu Active Color', 'singlepage'),'id' => 'home_side_nav_menu_active_color' ,'std' => '#23dd91','type'=> 'color');
	 
	 $options[] = array(
		'name' => __('Number of Sections', 'singlepage'),
		'desc' => __('Select number of sections', 'singlepage'),
		'id' => 'section_num',
		'type' => 'select',
		'class' => 'mini',
		'std' => '4',
		'options' => array_combine(range(1,4), range(1,4)) );
		
	 $section_num = of_get_option( 'section_num', 4 );
	 $section_menu_title              = array("SECTION ONE","SECTION TWO","SECTION THREE","SECTION FOUR");
	 $section_content_color      = array("#ffffff","#595959","#ffffff","#595959","#ffffff");
	 $section_css_class          = array("","","","");
	 $section_background_size    = array("yes","no","no","yes");
	 
	 $section_background = array(
	     array(
		'color' => '',
		'image' => $imagepath.'bg_01.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_02.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_03.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_04.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' )
		 );
	 $section_image     = array(
								$imagepath.'1.png',
								$imagepath.'2.png',
							    $imagepath.'3.png',
								$imagepath.'4.png'
								);
	 
	 $section_content   = array('<p><h1 class="section-title">Impressive Design</h1><br>
<ul>
	<li>Elegans Lorem Ratio amoena</li>
	<li>fons et oculorum captans iconibus</li>
	<li> haec omnia faciant ad melioris propositi vestri website</li>
</ul>
</p>',
		'<p><h1 class="section-title">Responsive Layout</h1><br>
</p>',
			'<p><h1 class="section-title">Flexibility</h1><br>
<ul>
	<li>Lorem ipsum dolor sit amet</li>
	<li>consectetur adipiscingelit</li>
	<li>Integer sed magna vel </li>
	<li>Dapibus ege-stas turpis.</li>
</ul>
</p>',
		'<p><h1 class="section-title">Continuous  Support</h1><br>
<ul>
	<li>Lorem ipsum dolor sit amet</li>
	<li>consectetur adipiscingelit</li>
	<li>Integer sed magna vel velit</li>
	<li>Dapibus ege-stas turpis.</li>
</ul>
</p>' );
	     
	 
	 		for($i=0; $i < $section_num; $i++){
		
		if(!isset($section_title[$i])){$section_title[$i] = "";}
		if(!isset($section_menu[$i])){$section_menu[$i] = "";}
		if(!isset($section_background[$i])){$section_background[$i] = array('color' => '',
		'image' => '',
		'repeat' => '',
		'position' => '',
		'attachment'=>'');}
		if(!isset($section_css_class[$i])){$section_css_class[$i] = "";}
		if(!isset($section_content[$i])){$section_content[$i] = "";}
		if(!isset($section_title_color[$i])){$section_title_color[$i] = "";}
		if(!isset($section_title_border_color[$i])){$section_title_border_color[$i] = "";}
		
		$options[] = array(	'desc' => '<div class="options-section"><h3 class="groupTitle">Section '.($i+1).'</h3>', 'class' => 'toggle_option_group group_close','type' => 'info');
		$options[] = array('name' => __('Section Menu Title', 'singlepage'),'id' => 'section_menu_title_'.$i.'','type' => 'text','std'=>$section_menu_title[$i]);
		$options[] = array('name' => __('Content Color', 'singlepage'),'id' => 'section_content_color_'.$i.'','type' => 'color','std'=>$section_content_color[$i]);
		$options[] = array('name' =>  __('Section Background', 'singlepage'),'id' => 'section_background_'.$i.'','std' => $section_background[$i],'type' => 'background' );
		$options[] = array('name' => __('100% Width Background Image', 'singlepage'),'std' => $section_background_size[$i],'id' => 'background_size_'.$i.'','type' => 'select','class'=>'mini','options'=>array("no"=>"no","yes"=>"yes"));
	   $options[] = array('name' => __('Section Css Class', 'singlepage'),'id' => 'section_css_class_'.$i.'','type' => 'text','std'=>$section_css_class[$i]);
	   $options[] = array('name' => __('Content Image', 'singlepage'),'id' => 'section_image_'.$i,	'std' =>  $section_image[$i],'type' => 'upload');
	   $options[] = array('name' => __('Content Image Link', 'singlepage'),'id' => 'section_image_link_'.$i.'','type' => 'text','std'=>'');
	   
	   $options[] = array('name' => __('Content Image Link Target', 'singlepage'),'std' => '','id' => 'section_image_link_target_'.$i.'','type' => 'select','class'=>'mini','options'=>array("_blank"=>"blank","_self"=>"self"));
	   
	   
	   $options[] = array('name' => __('Section Content', 'singlepage'),'id' => 'section_content_'.$i,'std' => $section_content[$i],'type' => 'editor');
	   $options[] = array('desc' => '</div>','class' => 'toggle_title','type' => 'info');
	
		}
		
		
		$options[] = array(
		'name' => __('Featured Homepage Sidebar', 'singlepage'),
		'id' => 'featured_homepage_sidebar',
		'std' => '<div class="social-networks"><ul class="unstyled inline">
  <li class="facebook  display-icons"> <a rel="external" title="facebook" href="#"> <i class="fa fa-facebook fa-2x">&nbsp;</i> </a> </li>
  <li class="twitter  display-icons"> <a rel="external" title="twitter" href="#"> <i class="fa fa-twitter fa-2x">&nbsp;</i> </a> </li>
  <li class="flickr  display-icons"> <a rel="external" title="flickr" href="#"> <i class="fa fa-flickr fa-2x">&nbsp;</i> </a> </li>
  <li class="rss  display-icons"> <a rel="external" title="rss" href="#"> <i class="fa fa-rss fa-2x">&nbsp;</i> </a> </li>
  <li class="google-plus  display-icons"> <a rel="external" title="google-plus" href="#"> <i class="fa fa-google-plus fa-2x">&nbsp;</i> </a> </li>
  <li class="youtube  display-icons"> <a rel="external" title="youtube" href="#"> <i class="fa fa-youtube fa-2x">&nbsp;</i> </a> </li>
</ul></div>',
		'type' => 'editor');

// FOOTER
	    $options[] = array('name' => __('Footer', 'singlepage'),'type' => 'heading');
	
	    $social_icons = array('fa fa-facebook'=>'facebook',
						  'fa fa-flickr'=>'flickr',
						  'fa fa-google-plus'=>'google plus',
						  'fa fa-linkedin'=>'linkedin',
						  'fa fa-pinterest'=>'pinterest',
						  'fa fa-twitter'=>'twitter',
						  'fa fa-tumblr'=>'tumblr',
						  'fa fa-digg'=>'digg',
						  'fa fa-rss'=>'rss',
						 
						  );
        for($i=0;$i<9;$i++){
			
	    $options[] = array("name" => sprintf(__('Social Icon #%s', 'singlepage'),($i+1)),	"id" => "social_icon_".$i,"std" => "","class" => 'mini',"type" => "select",	"options" => $social_icons );
		$options[] = array('name' => sprintf(__('Social Title #%s', 'singlepage'),($i+1)),'id' => 'social_title_'.$i,"class" => 'mini','type' => 'text');	
		$options[] = array('name' => sprintf(__('Social Link #%s', 'singlepage'),($i+1)),'id' => 'social_link_'.$i,'type' => 'text');	
		}

	return $options;
}