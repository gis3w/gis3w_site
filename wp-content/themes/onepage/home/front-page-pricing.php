<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_pricing_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_pricing_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_pricing_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_pricing_background_color'])){
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
 * Pricing tables section
 */
if(array_key_exists('pricing',$homepage_layout) && ! empty( $mts_options['mts_homepage_pricing_tables'] ) ) : ?>
	<section id="homepage-pricing" class="homepage-section homepage-pricing" style="background-color:<?php echo $mts_options['mts_homepage_pricing_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_pricing_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_pricing_heading'] ) ) : ?>
                    <h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_pricing_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_pricing_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_pricing_subheading']; ?></h3>
            <?php endif; ?>
            
			<?php 
				$i = 0;
				foreach( $mts_options['mts_homepage_pricing_tables'] as $table){ 
					$i++; 
				} 
			?>
            
            <div id="pricing_tables" class="clearfix">
            	<ul>
                	<?php foreach( $mts_options['mts_homepage_pricing_tables'] as $table){ ?>
                    	<li class="table_<?php echo $i; ?> pricing_table <?php if(isset($table['mts_homepage_table_highlight'])) echo ' highlight'; ?>">
                        	<?php if($table['mts_homepage_table_title'] != ''): ?>
                            <div class="table_title"><?php echo $table['mts_homepage_table_title']; ?></div>
                            <?php endif; ?>
                            
                            <?php if($table['mts_homepage_table_price'] != ''): ?>
                            <div class="price_container">
								<span class="price">
									<?php echo $table['mts_homepage_table_price']; ?>
                                </span>
                                <span class="description">
									<?php echo $table['mts_homepage_table_price_description']; ?>
                                </span>
                            </div>         
                            <?php endif; ?>
                            
                            <?php if($table['mts_homepage_table_features'] != ''): ?>
                            <div class="features">
                            	<?php echo nl2br($table['mts_homepage_table_features']); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($table['mts_homepage_table_button'] != ''): ?>
                            <div class="table_button">
                            	
                                <?php if($table['mts_homepage_table_button_url'] != ''): ?>
                                <a href="<?php echo $table['mts_homepage_table_button_url']; ?>"><?php echo $table['mts_homepage_table_button']; ?></a>
                                <?php else: ?>
                                	<span class="button_disabled"><?php echo $table['mts_homepage_table_button']; ?></span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                        </li>                        
                    <?php } ?>
                </ul>
            </div>

		</div>
	</section>

<?php endif; ?>