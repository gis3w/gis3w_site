<?php
     global $allowedposttags;
	 
	  $allowedposttags['iframe'] = array(
	  'align' => true,
	  'width' => true,
	  'height' => true,
	  'frameborder' => true,
	  'name' => true,
	  'src' => true,
	  'id' => true,
	  'class' => true,
	  'style' => true,
	  'scrolling' => true,
	  'marginwidth' => true,
	  'marginheight' => true,
	  
	  );
	  
     $sectionNum                 = of_get_option('section_num', 4);
     $section_menu_title         = array("SECTION ONE","SECTION TWO","SECTION THREE","SECTION FOUR");
	 $section_content_color      = array("#ffffff","#ffffff","#ffffff","#ffffff","#ffffff");
	 $section_css_class          = array("","","","");
	 $section_background_size    = array("yes","no","no","yes");
	 $imagepath =  get_template_directory_uri() . '/images/';
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
  $output                   = "";
  $sub_nav                  = "";
  
		if(  $sectionNum > 0 ) { 
		    for( $i=0; $i<$sectionNum; $i++ ){ 
			
		
	$menu_title     =  of_get_option('section_menu_title_'.$i, $section_menu_title[$i] );
	$class          =  of_get_option('section_css_class_'.$i, $section_css_class[$i]) ;
	$image  	    =  of_get_option('section_image_'.$i, $section_image[$i]) ;
	$image_link     =  of_get_option('section_image_link_'.$i, '') ;
	$image_link_target =  of_get_option('section_image_link_target_'.$i,'') ;
	
	$content	    =  of_get_option('section_content_'.$i, $section_content[$i]);
	$content_color  =  of_get_option('section_content_color_'.$i, $section_content_color[$i]) ;
	$section_background_       = of_get_option( 'section_background_'.$i,$section_background[$i]);
    $background                = singlepage_get_background( $section_background_ );
    $section_background_size_  = of_get_option( 'background_size_'.$i, $section_background_size[$i] );
	$cur            = "";
	if( $i==0 )
	$cur  = "cur";
	$sub_nav       .= '<li class="'.$cur.'">'.esc_attr($menu_title).'</li>';

			if( $section_background_size_ == 'yes'){
				 $background .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-size:100% 100%;';
				}
			if( $content_color  != "" ) $content_color = 'color:'.esc_attr($content_color).';';

	
       $output .= '<section class="section '.esc_attr($class).'" style="'.$background.'">
	   <div class="container">
		<div class="section-inner">
			<div class="section-content" style="'.$content_color.'">'.do_shortcode( wp_kses( $content , $allowedposttags ) ).'</div>';
		
		if( $image!='' ){
			if( $image_link !='' ){
				$output .= '<a href="'.esc_url($image_link).'" target="'.esc_attr($image_link_target).'"><div class="section-image" style="background-image:url('.esc_url($image).')"></div></a>';
				}else{
	 	        $output .= '<div class="section-image" style="background-image:url('.esc_url($image).')"></div>';
			}
		}
		
		
		$output .= '</div>
		  <div class="clear"></div>
		</div>
        </section>';
	
			
		  }
		}
		?>
        <?php if( $sectionNum > 1 ){ ?>
	<div class="sub_nav">
		<ul><?php echo $sub_nav;?></ul>
	</div>
     <?php }?>
    <?php
	$featured_homepage_sidebar = of_get_option( 'featured_homepage_sidebar' ,'' );
	if( $featured_homepage_sidebar != '' ){
		echo '<div class="widget"><div class="widget_area">'.do_shortcode( wp_kses( $featured_homepage_sidebar , $allowedposttags ) ).'</div></div>';
		}
      
	 ?>
	<div class="content">
  <?php echo $output;?>
  <div class="clear"></div>
	</div>