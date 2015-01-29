<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}
	if(empty($homepage_layout)) {
		$homepage_layout = array('enabled'  => array('blog' => 'Blog'));
		$homepage_layout = $homepage_layout['enabled'];
	}
	
	//Checks if the background image is dark or light
	if($mts_options['mts_homepage_blog_background_image'] != ''){
		if(is_light_image($mts_options['mts_homepage_blog_background_image'])){
			$border = '1px solid rgba(0, 0, 0, 0.15)';
			$text_color = '#282828';
		}else{
			$border = '1px solid rgba(255, 255, 255, 0.2)';
			$text_color = '#ffffff';
		}
	//Checks if the background color is dark or light
	} elseif($mts_options['mts_homepage_blog_background_color'] != ''){
		if(is_light_color($mts_options['mts_homepage_blog_background_color'])){
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
 * Blog section
 */
if(array_key_exists('blog',$homepage_layout)) : ?>
	<section id="homepage-blog" class="homepage-section homepage-blog" style="background-color:<?php echo $mts_options['mts_homepage_blog_background_color']; ?>;background-image: url(<?php print $mts_options['mts_homepage_blog_background_image']; ?>); ">
		<div class="inside">

			<?php
                // Title
                if( ! empty( $mts_options['mts_homepage_blog_heading'] ) ) : ?>
                    <h2 style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;" class="page-title"><?php print $mts_options['mts_homepage_blog_heading']; ?></h2>
            <?php endif; ?>

            <?php
                // Subtitle
                if( ! empty( $mts_options['mts_homepage_blog_subheading'] ) ) : ?>
                    <h3 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_blog_subheading']; ?></h3>
            <?php endif; ?>
            
            <?php 
				$post_count = 0;
				$start = 2;
				$multiple = 2;
				$finish = 1;
				$layout = 'column_layout';
				
				$blog_query = new WP_Query();
                $blog_query->query('posts_per_page='.$mts_options['mts_homepage_blog_post_number']);
				
				while ($blog_query->have_posts()) : $blog_query->the_post();
					$post_count++;
				endwhile;
				
				if($mts_options['mts_homepage_blog_post_number'] <= $post_count){
					$post_count = $mts_options['mts_homepage_blog_post_number'];
				}
				
				if($mts_options['mts_homepage_blog_layout'] == 2){
					$layout = 'article sidebar_layout';
				}
				
			?>

            <div class="<?php echo $layout; ?>" id="homepage-posts">
				<?php if ( $blog_query->have_posts() ) while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
                        <div class="single_post clearfix">
                            
                            <?php if( has_post_thumbnail() ): 
								if($mts_options['mts_homepage_blog_layout'] == 1){ 
									$thumb_size = 'featured-small';
								}else{
									$thumb_size = 'featured';
								} 
							?>
		                    <div class="featured-thumbnail">
		                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		                            <?php the_post_thumbnail( $thumb_size ); ?>
		                            <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
		                        </a>
		                    </div>
		                    <?php endif; ?>
		                    <header>
		                        <h2 class="single-title">
		                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		                                <?php the_title(); ?>
		                            </a>
		                        </h2>
		                        <?php if($mts_options['mts_single_headline_meta'] == '1') { ?>
		                            <div class="post-info">
		                                <?php if(isset($mts_options['mts_single_headline_meta_info']['author']) == '1') { ?>
		                                    <span class="theauthor"><?php _e( 'By ', 'mythemeshop' ); the_author_posts_link(); ?></span>
		                                <?php } ?>
		                                <?php if(isset($mts_options['mts_single_headline_meta_info']['date']) == '1') { ?>
		                                    <span class="thetime updated"><?php _e( 'Posted On ', 'mythemeshop' ); the_time( get_option( 'date_format' ) ); ?></span>
		                                <?php } ?>
		                                <?php if(isset($mts_options['mts_single_headline_meta_info']['category']) == '1') { ?>
		                                    <span class="thecategory"><?php the_category(', ') ?></span>
		                                <?php } ?>
		                                <?php if(isset($mts_options['mts_single_headline_meta_info']['comment']) == '1') { ?>
		                                    <span class="thecomment"><a rel="nofollow" href="<?php comments_link(); ?>"><?php echo comments_number();?></a></span>
		                                <?php } ?>
		                            </div>
		                        <?php } ?>
		                    </header><!--.headline_area-->
		                    <div class="post-single-content box mark-links">
		                        <?php if ($mts_options['mts_homepage_blog_layout'] == '1'){ ?>
		                            <?php echo mts_excerpt(27); ?>
		                            <a class="reply" href="<?php the_permalink(); ?>"><?php _e("Continue Reading","mythemetop"); ?></a>
		                        <?php } else { ?>
		                               <?php if($mts_options['mts_full_posts'] == '0'){ ?>
		                                   <?php echo mts_excerpt(55); ?>
		                                   <a class="reply" href="<?php the_permalink(); ?>"><?php _e("Continue Reading","mythemetop"); ?></a>
		                               <?php } else { ?>
		                                   <?php the_content(); ?>
		                                   <?php if (mts_post_has_moretag()){ ?>
		                            	       <a class="reply" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow"><?php _e('Continue Reading','mythemeshop'); ?></a>
		                        <?php }}} ?>
		                    </div><!--.post-single-content box mark-links-->
		                </div><!--.post-content box mark-links-->
		            </article><!--.g post-->
        			<?php $start++; $finish++; ?>
        		<?php endwhile; /* end loop */ ?>
            </div>
			<?php 
                if($mts_options['mts_homepage_blog_layout'] == '2'){
                    get_sidebar(); 
                }
            ?>
            <div class="<?php echo $layout; ?>">
            	<?php ajaxed_pagination($blog_query); ?>
            </div>
		</div>
	</section>
<?php endif; ?>