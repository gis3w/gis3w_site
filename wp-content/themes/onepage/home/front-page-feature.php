<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_features_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_features_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_features_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_features_background_color'])){
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
 * Homepage features
 */
if( array_key_exists('feature',$homepage_layout) && ! empty( $mts_options['mts_homepage_features'] ) ) : ?>
	<section id="homepage-features" class="homepage-section" style="background-color:<?php echo $mts_options['mts_homepage_features_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_features_background_image']; ?>); ">
		<div class="inside">
			<?php
				// Title
				if( ! empty( $mts_options['mts_homepage_features_heading'] ) ) : ?>
					<h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_features_heading']; ?></h2>
			<?php endif; ?>

			<?php
				// Subtitle
				if( ! empty( $mts_options['mts_homepage_features_subheading'] ) ) : ?>
					<h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_features_subheading']; ?></h3>
			<?php endif; ?>
            
            <ul class="feature_list clearfix">
				<?php $features_columns = $mts_options['mts_homepage_features_columns'];
				$features_columns = isset( $features_columns ) && $features_columns == '3' ? '3' : '4';
				// Features
				foreach( $mts_options['mts_homepage_features'] as $feature ) : ?>
				<li class="col feature_<?php print $features_columns; ?> feature">
					<?php
						if( ! empty( $feature['mts_homepage_feature_image'] ) && isset( $feature['mts_homepage_feature_image'] ) ) : ?>
						<div class="feature-icon">
                        	<span class="fa fa-<?php print $feature['mts_homepage_feature_image'] ?>" style="color:<?php print $feature['mts_feature_icon_color'] ?>"></span>
                        </div>
						<?php
						endif;

						if( ! empty( $feature['mts_homepage_feature_title'] ) && isset( $feature['mts_homepage_feature_title'] ) ) : ?>
						<h3 class="feature-title"><?php print $feature['mts_homepage_feature_title'] ?></h3>
					<?php
						endif;

						if( ! empty( $feature['mts_homepage_feature_description'] ) && isset( $feature['mts_homepage_feature_description'] ) ) : ?>
						<p class="feature-description"><?php print $feature['mts_homepage_feature_description'] ?></p>
					<?php endif; ?>
				</li>
				<?php 
					endforeach; ?>
            </ul>
		</div>
	</section>
<?php endif; ?>