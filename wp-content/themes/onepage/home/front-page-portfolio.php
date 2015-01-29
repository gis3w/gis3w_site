<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];

	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_portfolio_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_portfolio_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_portfolio_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_portfolio_background_color'])){
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
 * Portfolio section
 */
if(array_key_exists('portfolio',$homepage_layout)) : ?>
	<section id="homepage-portfolio" class="homepage-section homepage-portfolio" style="background-color:<?php echo $mts_options['mts_homepage_portfolio_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_portfolio_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_portfolio_heading'] ) ) : ?>
                    <h2 class="page-title" style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;"><?php print $mts_options['mts_homepage_portfolio_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_portfolio_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_portfolio_subheading']; ?></h3>
            <?php endif; ?>

            
			<div id="filters">
                <ul class="option-set" data-option-key="filter">
                <?php  ?>    
                    <li>
                        <a href="#filter" class="selected" data-category="all"><?php _e("All","mythemeshop"); ?></a>
                    </li>

					<?php wp_list_categories(array('title_li' => '','taxonomy' => 'skills')); ?>
                </ul>
				<div class="clear"></div>
			</div>
			
            <div class="expander clearfix"></div>
            
            <div id="portfolio-grid">

				<?php $post_count = 0;
					
	                $query = new WP_Query();
	                $query->query('post_type=portfolio&ignore_sticky_posts=1&posts_per_page=-1');
					
					while ($query->have_posts()) : $query->the_post();
	                $terms = get_the_terms( get_the_ID(), 'skills');
	                
	                if (has_post_thumbnail()) {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'portfolio');
	                } else {
	                    $thumb = array(get_template_directory_uri().'/images/nothumb-portfolio.png');
	                }
	            ?>
				<div class="item <?php if(isset($terms)){foreach ($terms as $term) { echo 'cat-'.$term->term_id. ' '; }}; ?>">
					<a class="expand-view" href="<?php the_permalink(); ?>" data-id="<?php echo $post->ID ?>">
						<img src="<?php echo $thumb[0]; ?>" width="380" height="380" alt="<?php the_title(); ?>"/>
                        
                        <div class="overlay">
                        	<div class="overlay_container">
                                <h4><?php the_title(); ?></h4>
                                <?php echo mts_excerpt(15); ?>
                                <span class="button"><i class="fa fa-search-plus"></i><?php _e("View More","mythemeshop"); ?></span>
                            </div>                             
                        </div>
                        
                        <div class="loader" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
					</a>
				</div>
                
            <?php endwhile; ?>
            
            </div>
		</div>
        <?php wp_reset_query(); ?>
	</section>
<?php endif; ?>