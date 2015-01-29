<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];

	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_counter_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_counter_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_counter_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_counter_background_color'])){
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
 * Homepage counter
 */
if( array_key_exists('counter',$homepage_layout) && ! empty( $mts_options['mts_homepage_counter'] ) ) : ?>
	<section id="homepage-counter" class="homepage-section"   style="background-color:<?php echo $mts_options['mts_homepage_counter_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_counter_background_image']; ?>); ">
        <div class="inside">
			<?php
				// Title
				if( ! empty( $mts_options['mts_homepage_counter_heading'] ) ) : ?>
					<h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_counter_heading']; ?></h2>
			<?php endif; ?>

			<?php
				// Subtitle
				if( ! empty( $mts_options['mts_homepage_counter_subheading'] ) ) : ?>
					<h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_counter_subheading']; ?></h3>
			<?php endif; ?>

			<div class="counter-items">
				<?php
					$counter_items = count( $mts_options['mts_homepage_counter'] );
					$i=0;

					foreach( $mts_options['mts_homepage_counter'] as $count ) : ?>
						<div class="counter-item" style="width: <?php print 100 / $counter_items; ?>%;">
							<span class="count count-<?php echo $i ?>" style="color:<?php echo $text_color; ?>;">0</span>
							<span class="sub"><?php print $count['mts_homepage_counter_description']; ?></span>
                            <script type="text/javascript">
                            jQuery(window).load(function() {                            
								jQuery(document).scroll(function(){
									if(jQuery(this).scrollTop()>=jQuery('#homepage-counter').position().top - 200){
										jQuery('#homepage-counter .count-<?php echo $i; ?>').animateNumbers(<?php print $count['mts_homepage_counter_number']; ?>,200);
									}
								});
                            });                                
							</script>
						</div>
				<?php $i++;  endforeach; ?>
			</div>
		</div>
	</section>
<?php endif;?>