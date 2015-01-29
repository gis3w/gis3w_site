<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_contact_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_contact_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_contact_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_contact_background_color'])){
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
 * contact section
 */
if( array_key_exists('contact',$homepage_layout) ) : ?>
	<section id="homepage-contact" class="homepage-section homepage-contact" style="background-color:<?php echo $mts_options['mts_homepage_contact_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_contact_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_contact_heading'] ) ) : ?>
                    <h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_contact_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_contact_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_contact_subheading']; ?></h3>
            <?php endif; ?>
            
            <div class="contact_section clearfix">
				<div class="col span_6 contact_column">
					<h6><?php _e("Contact info","mythemeshop"); ?></h6>
                    <?php if (!empty($mts_options['mts_homepage_contact_address'])) : ?>
                    <span><i class="fa fa-map-marker"></i><?php echo $mts_options['mts_homepage_contact_address']; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($mts_options['mts_homepage_contact_number'])) : ?>
                    <span><i class="fa fa-phone"></i><?php echo $mts_options['mts_homepage_contact_number']; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($mts_options['mts_homepage_contact_email'])) : ?>
                    <span><i class="fa fa-envelope"></i><?php echo $mts_options['mts_homepage_contact_email']; ?></span>
                    <?php endif; ?>
                    <br />
                    
                    <?php if(!empty($mts_options['mts_homepage_contact_social_icons'])): ?>
                    <h6><?php _e("Social Network","mythemeshop"); ?></h6>
                    
						<?php if($mts_options['mts_twitter_url'] != '' || $mts_options['mts_facebook_url'] || $mts_options['mts_google_url']): ?>
                        <div class="social_icons">
                            <?php if($mts_options['mts_twitter_url'] != ''): ?>
                            <a class="fa fa-twitter" href="<?php echo $mts_options['mts_twitter_url']; ?>"></a>
                            <?php endif; ?>
                            
                            <?php if($mts_options['mts_facebook_url'] != ''): ?>
                            <a class="fa fa-facebook" href="<?php echo $mts_options['mts_facebook_url']; ?>"></a>
                            <?php endif; ?>
                            
                            <?php if($mts_options['mts_google_url'] != ''): ?>
                            <a class="fa fa-google-plus" href="<?php echo $mts_options['mts_google_url']; ?>"></a>
                            <?php endif; ?>
                            
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="col span_6 contact_column">
					<?php mts_contact_form(); ?>
                </div>
            </div>
		</div>
	</section>
<?php endif; ?>

<?php if( array_key_exists('contact',$homepage_layout) && $mts_options['mts_map_coordinates'] != '' ) : ?>
    <div class="contact_map">
        <div id="map-canvas" style="width: 100%; height: 500px"></div>
    </div>
<?php endif; ?>