<?php 
	$mts_options = get_option(MTS_THEME_NAME);
	
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}
	if(empty($homepage_layout)) {
		$homepage_layout = array('enabled'  => array('blog' => 'Blog'));
		$homepage_layout = $homepage_layout['enabled'];
	}
	
	//Checks if body background color is light or dark
	if(is_light_color($mts_options['mts_bg_color'])){
		$border = '1px solid rgba(0, 0, 0, 0.15)';
		$text_color = '#282828';
	}else{
		$border = '1px solid rgba(255, 255, 255, 0.2)';
		$text_color = '#ffffff';
	}
	
	get_header();
?>
<?php
/**
 * Blog section
 */
if(array_key_exists('blog',$homepage_layout)) : ?>
	<section id="homepage-blog" class="homepage-section homepage-blog blog">
		<div class="inside">
            <?php 
				$post_count = 0;
				$start = 2;
				$multiple = 2;
				$finish = 1;
				$layout = 'column_layout';
				
				if($mts_options['mts_homepage_blog_post_number'] <= $post_count){
					$post_count = $mts_options['mts_homepage_blog_post_number'];
				}
				
				if($mts_options['mts_homepage_blog_layout'] == 2){
					$layout = 'article sidebar_layout';
				}
				
			?>

            <div id="content_box" class="<?php echo $layout; ?>">
    			<h1 class="postsby">
					<?php if (is_category()) { ?>
						<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
					<?php } elseif (is_tag()) { ?> 
						<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
					<?php } elseif (is_author()) { ?>
						<span><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->nickname; _e(" Archive", "mythemeshop"); ?></span> 
					<?php } elseif (is_day()) { ?>
						<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
					<?php } elseif (is_month()) { ?>
						<span><?php _e("Monthly Archive:", "mythemeshop"); ?>:</span> <?php the_time('F Y'); ?>
					<?php } elseif (is_year()) { ?>
						<span><?php _e("Yearly Archive:", "mythemeshop"); ?>:</span> <?php the_time('Y'); ?>
					<?php } ?>
				</h1>
				<?php if (have_posts() ) while (have_posts() ) :the_post(); ?>
                
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
                                <h1 class="single-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                        <?php the_title(); ?>
                                    </a>
                                </h1>
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
                        </div><!--.single_post clearfix-->

                    </article><!--.g post-->
                
                <?php $start++; $finish++; ?>

                <?php endwhile; /* end loop */ ?>
				<!--Start Pagination-->
					<?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
						<?php $additional_loop = 0; mts_pagination($additional_loop['max_num_pages']); ?>
					<?php } else { ?>
						<div class="pagination pagination-previous-next">
							<ul>
								<li class="nav-previous"><?php next_posts_link( '<i class="fa fa-chevron-left"></i> '. __( 'Previous', 'mythemeshop' ) ); ?></li>
								<li class="nav-next"><?php previous_posts_link( __( 'Next', 'mythemeshop' ).' <i class="fa fa-chevron-right"></i>' ); ?></li>
							</ul>
						</div>
					<?php } ?>
				<!--End Pagination-->
            </div>

			<?php if($mts_options['mts_homepage_blog_layout'] == '2'){ get_sidebar(); } ?>
		</div>

	</section>
<?php endif; ?>
<?php get_footer(); ?>