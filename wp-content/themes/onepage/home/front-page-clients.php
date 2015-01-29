<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_client_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_client_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_client_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_client_background_color'])){
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
 * Client section
 */
if(array_key_exists('clients',$homepage_layout) && ! empty( $mts_options['mts_homepage_clients'] ) ) : ?>
	<section id="homepage-clients" class="homepage-section homepage-clients" style="background-color:<?php echo $mts_options['mts_homepage_client_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_client_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_client_heading'] ) ) : ?>
                    <h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_client_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_client_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_client_subheading']; ?></h3>
            <?php endif; ?>
            
            <ul class="clients">
                <?php foreach( $mts_options['mts_homepage_clients'] as $client){ ?>
                    <li>
                        <?php if( ! empty( $client['mts_homepage_client_image'] ) && isset( $client['mts_homepage_client_image'] ) ) : ?>
                        <div class="client_logo">
                        	<?php if( ! empty( $client['mts_homepage_client_url'] ) && isset( $client['mts_homepage_client_url'] ) ) : ?>
	                            <a href="<?php print $client['mts_homepage_client_url'] ?>">
	                                <?php list($width, $height, $type, $attr) = getimagesize($client['mts_homepage_client_image']); ?>
                                    <img src="<?php echo $client['mts_homepage_client_image']; ?>" <?php echo $attr; ?> />
	                            </a>
                            <?php else: ?>
                                <?php list($width, $height, $type, $attr) = getimagesize($client['mts_homepage_client_image']); ?>
                            	<img src="<?php echo $client['mts_homepage_client_image']; ?>" <?php echo $attr; ?>/>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>                         
                    </li>                        
                <?php } ?>
            </ul>
		</div>
	</section>
<?php endif; ?>