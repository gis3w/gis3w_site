<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_testimonials_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_testimonials_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_testimonials_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_testimonials_background_color'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}		
	}else{
		//Checks if body background color is light or dark
		if(is_light_color($mts_options['mts_bg_color'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	}
?>
<?php 
/**
 * Testimonials section
 */
if(array_key_exists('testimonial',$homepage_layout) && ! empty( $mts_options['mts_homepage_testimonials'] ) ) : ?>
	<section id="homepage-testimonials" class="homepage-section homepage-testimonials" style="color:<?php echo $text_color; ?>;background-color:<?php echo $mts_options['mts_homepage_testimonials_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_testimonials_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_testimonials_heading'] ) ) : ?>
                    <h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_testimonials_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_testimonials_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_testimonials_subheading']; ?></h3>
            <?php endif; ?>
            

            <div class="slides_container clearfix loading">
                <div id="testimonials" class="slides">
                    <?php foreach( $mts_options['mts_homepage_testimonials'] as $testimonial){ ?>
                        <div class="testimonial-item">
                            <?php
                            if( ! empty( $testimonial['mts_homepage_testifier_image'] ) && isset( $testimonial['mts_homepage_testifier_image'] ) ) : ?>
                            <div class="testifier-image">
                                <img class="lazyOwl" data-src="<?php $testi_image = wp_get_attachment_image_src($testimonial['mts_homepage_testifier_image'], 'testifier', false, array('title' => '')); echo $testi_image[0]; ?>" width="164" height="164"><br />
                                <span class="arrow"></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="content">
                                <div class="testimonial">
                                    "<?php echo $testimonial['mts_homepage_testifier_description']; ?>"
                                </div>
                                <div class="testifier">
                                    - <?php echo $testimonial['mts_homepage_testifier_title']; ?>
                                </div>
                            </div>                            
                        </div>                        
                    <?php } ?>
                </div>
            </div><!--.slides_container-->

		</div>
	</section>
<?php endif; ?>