<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_service_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_service_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_service_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_service_background_color'])){
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
 * Services
 */
if(array_key_exists('service',$homepage_layout) && ! empty( $mts_options['mts_homepage_service'] ) ) : ?>
	<section id="homepage-service" class="homepage-section homepage-service" style="color:<?php echo $text_color; ?>;background-color:<?php echo $mts_options['mts_homepage_service_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_service_background_image']; ?>); ">
		<div class="inside">
				<?php
					// Title
					if( ! empty( $mts_options['mts_homepage_service_heading'] ) ) : ?>
						<h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_service_heading']; ?></h2>
				<?php endif; ?>

				<?php
					// Subtitle
					if( ! empty( $mts_options['mts_homepage_service_subheading'] ) ) : ?>
						<h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_service_subheading']; ?></h3>
				<?php endif; ?>
                
                <?php $service_columns = $mts_options['mts_homepage_service_columns']*1; ?>
                
                <div class="slides_container clearfix loading">
                    <div id="service_slides" class="scroll slides" data-columns="<?php echo $service_columns; ?>">
                        <?php
                            // Features
                            foreach( $mts_options['mts_homepage_service'] as $service ) : ?>
                            <div class="col carousel-item">
                                <?php
                                    if( ! empty( $service['mts_homepage_service_image'] ) && isset( $service['mts_homepage_service_image'] ) ) : ?>
                                    <div class="service-icon">
                                        <span class="fa fa-<?php print $service['mts_homepage_service_image'] ?>" style="background-color:<?php print $service['mts_service_icon_color'] ?>;"></span>
                                        <span class="arrow" style="border-top-color:<?php print $service['mts_service_icon_color'] ?>;"></span>
                                    </div>
                                    <?php
                                    endif; ?>
                                    <h3 style="color:<?php echo $text_color; ?>;"><?php print $service['mts_homepage_service_title']; ?></h3>
                                    <p style="color:<?php echo $text_color; ?>;"><?php print $service['mts_homepage_service_description']; ?></p>
                            </div>
                        <?php 
                            endforeach; ?>
    
                    </div><!--#service_slides-->
                </div>

		</div>
	</section>
<?php endif; ?>