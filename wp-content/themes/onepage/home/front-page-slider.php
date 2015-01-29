<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
?>

<?php
/**
 * Homepage heading
 * Homepage subheading
 * Homepage slider
 */
/*Check if slider section is enabled in layout manager*/
if(array_key_exists('slider',$homepage_layout) && !empty($mts_options['mts_custom_slider'])): ?>
    
	<section id="homepage-title-slider" class="homepage-section" style="background-color:<?php echo $mts_options['mts_homepage_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_background_image']; ?>); ">
		<div class="inside">

            <div class="slides_container clearfix loading">
                <div id="homepage_slider" class="slides">
                    <?php foreach($mts_options['mts_custom_slider'] as $slide) : ?>
                          
                        <div <?php if($slide['mts_custom_slider_title'] != '' || $slide['mts_custom_slider_text'] != '') echo 'class="has_caption"'; ?>>
                            <a href="<?php echo $slide['mts_custom_slider_link']; ?>">
                            <?php list($width, $height, $type, $attr) = getimagesize($slide['mts_custom_slider_image']); ?>
                            <img src="<?php echo $slide['mts_custom_slider_image']; ?>" alt="<?php echo $slide['mts_custom_slider_title']; ?>" <?php echo $attr; ?> />
                            <div class="slider-overlay" style="background-color:<?php echo $slide['mts_slider_overlay_color']; ?>"></div>
                            <?php if($slide['mts_custom_slider_title'] != '' || $slide['mts_custom_slider_text'] != ''): ?>
                            <div class="flex-caption">
                                <?php if($slide['mts_custom_slider_title'] != ''): ?>
                                    <h2 class="slidertitle"><?php echo $slide['mts_custom_slider_title']; ?></h2>
                                <?php endif; ?>
                                
                                <?php if($slide['mts_custom_slider_text'] != ''): ?>
                                    <p class="slidertext"><?php echo $slide['mts_custom_slider_text']; ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </a> 
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!--.slides_container-->
		</div>
	</section>
<?php endif;  ?>
	
<?php
/**
 * Homepage buttons
 */
if( ! empty( $mts_options['mts_homepage_buttons'] ) && $mts_options['mts_homepage_buttons_enable'] ) : ?>
	<section id="homepage-buttons" class="homepage-section" style="<?php if(!array_key_exists('slider',$homepage_layout)) echo 'margin-top:0;'; ?>background-color:<?php echo $mts_options['mts_homepage_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_background_image']; ?>">
		<div class="inside" style="background-color:<?php echo $mts_options['mts_homepage_buttons_background_color']; ?>;">
			<?php
				foreach( $mts_options['mts_homepage_buttons'] as $button ) : ?>
				<a href="<?php print $button['mts_homepage_button_url']; ?>" class="button homepage-button" style="background-color:<?php echo $button['mts_slider_button_color']; ?>";"><?php if($button['mts_homepage_button_icon'] != ''): ?><i class="fa fa-<?php echo $button['mts_homepage_button_icon']; ?>"></i><?php endif; ?><?php print $button['mts_homepage_button_label']; ?></a>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif;  ?>