<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_team_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_team_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_team_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_team_background_color'])){
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
		 * Team members
		 */
		if( array_key_exists('team',$homepage_layout) && ! empty( $mts_options['mts_homepage_team'] ) ) : ?>
		<section id="homepage-team" class="homepage-section" style="background-color:<?php echo $mts_options['mts_homepage_team_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_team_background_image']; ?>); ">
			<div class="inside">
				<?php
					// Title
					if( ! empty( $mts_options['mts_homepage_team_heading'] ) ) : ?>
						<h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_team_heading']; ?></h2>
				<?php endif; ?>

				<?php
					// Subtitle
					if( ! empty( $mts_options['mts_homepage_team_subheading'] ) ) : ?>
						<h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_team_subheading']; ?></h3>
				<?php endif; ?>
                
                <div class="clearfix">
				<?php
					$team_columns = $mts_options['mts_homepage_team_columns'];
					$team_columns = isset( $team_columns ) && $team_columns == '3' ? '3' : '4';
					
					$start = $team_columns*1;
					$multiple = $team_columns*1;
					$finish = 1;
					$team_count = 0;
					
					foreach( $mts_options['mts_homepage_team'] as $team ) :
						$team_count++;
					endforeach;

					// Features
					foreach( $mts_options['mts_homepage_team'] as $team ) : ?>
                    
                    <?php if(is_multiple($start,$multiple) ): ?>
                        <div class="team_row clearfix">
                    <?php endif; ?>
                    
                    <?php
                    	if($team_columns == 4){
							$thumb = wp_get_attachment_image($team['mts_homepage_team_image'], 'team', false, array('title' => ''));
						}else{
							$thumb = wp_get_attachment_image($team['mts_homepage_team_image'], 'portfolio', false, array('title' => ''));
						}
					
					?>
                    
					<div class="col table_<?php print $team_columns; ?> team-member">
						<div class="mask">
							<div class="slide-up">
								<?php
									if( ! empty( $team['mts_homepage_team_image'] ) && isset( $team['mts_homepage_team_image'] ) ) : ?>
									<div class="team-image"><?php echo $thumb; ?></div>
									<?php
									endif; ?>
								<div class="team-member-info">
									<?php
										if( ! empty( $team['mts_homepage_team_name'] ) && isset( $team['mts_homepage_team_name'] ) ) : ?>
										<h3 class="team-title"><?php print $team['mts_homepage_team_name'] ?></h3>
									<?php
										endif;

										if( ! empty( $team['mts_homepage_team_position'] ) && isset( $team['mts_homepage_team_position'] ) ) : ?>
										<div class="team-position"><?php print $team['mts_homepage_team_position'] ?></div>
									<?php
										endif;

										if( ! empty( $team['mts_homepage_team_info'] ) && isset( $team['mts_homepage_team_info'] ) ) : ?>
										<p class="team-description"><?php print $team['mts_homepage_team_info'] ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="team-member-contact">
							<?php if( isset( $team['mts_homepage_team_twitter'] ) && ! empty( $team['mts_homepage_team_twitter'] ) ) : ?>
								<a href="<?php print $team['mts_homepage_team_twitter']; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
							<?php endif; ?>
							<?php if( isset( $team['mts_homepage_team_facebook'] ) && ! empty( $team['mts_homepage_team_facebook'] ) ) : ?>
								<a href="<?php print $team['mts_homepage_team_facebook']; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
							<?php endif; ?>
							<?php if( isset( $team['mts_homepage_team_google'] ) && ! empty( $team['mts_homepage_team_google'] ) ) : ?>
								<a href="<?php print $team['mts_homepage_team_google']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
							<?php endif; ?>
                            
						</div>
					</div>
                    
					<?php if(is_multiple($finish,$multiple) || $finish == $team_count): ?>
                    	</div>
                    <?php endif; ?>
                    
					<?php 
						$start++; 
						$finish++;
						endforeach; ?>
                    </div>
			</div>
		</section>
	<?php endif; ?>