<?php get_header(); ?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<div id="page" class="single">
	<article class="<?php mts_article_class(); ?>">
		<div id="content_box" >
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
					<div class="single_post clearfix">
						<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
							<div class="breadcrumb" itemprop="breadcrumb"><?php mts_the_breadcrumb(); ?></div>
						<?php } ?>
						<?php if ($mts_options['mts_single_featured'] == '1') { ?>
							<div class="featured-thumbnail">
								<?php if( has_post_thumbnail() )
								the_post_thumbnail( 'featured' ); ?>
							</div>
						<?php } ?>
						<header>
							<h1 class="single-title"><?php the_title(); ?></h1>
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
							<?php if(!empty($mts_options['mts_single_social_button_position']) && $mts_options['mts_single_social_button_position'] == 1) mts_social_icons(); ?>
                            
							<?php if ($mts_options['mts_posttop_adcode'] != '') { ?>
								<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
									<div class="topad">
										<?php echo do_shortcode($mts_options['mts_posttop_adcode']); ?>
									</div>
								<?php } ?>
							<?php } ?>
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','mythemeshop'), 'previouspagelink' => __('Previous','mythemeshop'), 'pagelink' => '%','echo' => 1 )); ?>
							<?php if ($mts_options['mts_postend_adcode'] != '') { ?>
								<?php $endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
									<div class="bottomad">
										<?php echo do_shortcode($mts_options['mts_postend_adcode']); ?>
									</div>
								<?php } ?>
							<?php } ?> 
                            
							<?php if(!empty($mts_options['mts_single_social_button_position']) && $mts_options['mts_single_social_button_position'] == 2) mts_social_icons(); ?>
                            
							<?php if($mts_options['mts_tags'] == '1') { ?>
								<div class="tags"><?php the_tags('<span class="tagtext">'.__('Tags','mythemeshop').':</span>',', ') ?></div>
							<?php } ?>
						</div>
					</div><!--.post-content box mark-links-->		
					<?php if(!empty($mts_options['mts_related_posts'])) { ?>	
                        <!-- Start Related Posts -->
                        <?php 
                        $empty_taxonomy = false;
                        if (empty($mts_options['mts_related_posts_taxonomy']) || $mts_options['mts_related_posts_taxonomy'] == 'tags') {
                            // related posts based on tags
                            $tags = get_the_tags($post->ID); 
                            if (empty($tags)) { 
                                $empty_taxonomy = true;
                            } else {
                                $tag_ids = array(); 
                                foreach($tags as $individual_tag) {
                                    $tag_ids[] = $individual_tag->term_id; 
                                }
                                $args = array( 'tag__in' => $tag_ids, 
                                    'post__not_in' => array($post->ID), 
                                    'posts_per_page' => $mts_options['mts_related_postsnum'], 
                                    'ignore_sticky_posts' => 1, 
                                    'orderby' => 'rand' 
                                );
                            }
                         } else {
                            // related posts based on categories
                            $categories = get_the_category($post->ID); 
                            if (empty($categories)) { 
                                $empty_taxonomy = true;
                            } else {
                                $category_ids = array(); 
                                foreach($categories as $individual_category) 
                                    $category_ids[] = $individual_category->term_id; 
                                $args = array( 'category__in' => $category_ids, 
                                    'post__not_in' => array($post->ID), 
                                    'posts_per_page' => $mts_options['mts_related_postsnum'],  
                                    'ignore_sticky_posts' => 1, 
                                    'orderby' => 'rand' 
                                );
                            }
                         }
                        if (!$empty_taxonomy) {
                        $my_query = new wp_query( $args ); if( $my_query->have_posts() ) {
                        echo '<div class="related-posts"><h3>'.__('Related Posts','mythemeshop').'</h3><ul>';
                        $counter = '0'; while( $my_query->have_posts() ) { ++$counter; if($counter == 4) { $postclass = 'last'; $counter = 0; } else { $postclass = ''; } $my_query->the_post(); $li = 1; ?>
                        <li class="<?php echo $postclass; ?> relatepostli<?php echo $li+$counter; ?>">
                            <a class="relatedthumb" href="<?php the_permalink()?>" title="<?php the_title(); ?>">
                                <span class="rthumb">
                                    <?php 
                                    if( has_post_thumbnail() ) :
                                        the_post_thumbnail('related',array('title' => ''));
                                    else :
                                        printf( '<img src="%s" alt="No preview" />', get_template_directory_uri() . '/images/nothumb_related.jpg' );
                                    endif; ?>
                                </span>
                                <span class="related-title">
                                    <?php the_title(); ?>
                                </span>
                            </a>
                        </li>
                        <?php } echo '</ul></div>'; }} wp_reset_query(); ?>
                        <!-- .related-posts -->
                    <?php }?>
					<?php if($mts_options['mts_author_box'] == '1') { ?>
						<div class="postauthor">
							<h3><?php _e('About The Author', 'mythemeshop'); ?></h3>
							<div class="postcontent">
                                <div class="meta alignright">                                          
									<?php
                                    	$twitter = get_user_meta($post->post_author, 'twitter', true);
                                        $facebook = get_user_meta($post->post_author, 'facebook', true);
										$google_plus = get_user_meta($post->post_author, 'google_plus', true);
									?> 
                                    <?php if($facebook != ''): ?>
                                        <span><a class="fa fa-facebook" target="_blank" href="<?php echo esc_url($facebook); ?>"></a></span>
                                    <?php endif; ?>
                                                                                                          
									<?php if($twitter != ''): ?>
                                        <span><a class="fa fa-twitter" target="_blank" href="http://twitter.com/<?php echo strip_tags($twitter); ?>"></a></span>                                                
                                    <?php endif; ?>
                                    
                                    <?php if($google_plus != ''): ?>
                                        <span><a class="fa fa-google-plus" target="_blank" rel="me" href="<?php echo esc_url($google_plus).'?rel=author'; ?>"></a></span>
                                    <?php endif; ?>
                                    
                                </div> <!--meta-->
								
								<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '150' );  } ?>
								<h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="nofollow"><?php the_author_meta( 'nickname' ); ?></a></h5>
								<p><?php the_author_meta('description') ?></p>

                                <?php $curauth = get_the_author_meta('ID'); ?>
                                <span class="author_link">
                                	<a href="<?php echo get_author_posts_url($curauth); ?>"><?php _e("More from this author","mythemetop"); ?></a>
                                </span>
							</div>
						</div>
					<?php }?>  
				</div><!--.g post-->
				<?php comments_template( '', true ); ?>
			<?php endwhile; /* end loop */ ?>
		</div>
	</article>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>