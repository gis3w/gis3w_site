<?php
$mts_options = get_option(MTS_THEME_NAME);
/*------------[ Meta ]-------------*/
if ( ! function_exists( 'mts_meta' ) ) {
	function mts_meta(){
	global $mts_options
?>
<?php if ($mts_options['mts_favicon'] != ''){ ?>
	<link rel="icon" href="<?php echo $mts_options['mts_favicon']; ?>" type="image/x-icon" />
<?php } ?>
<!--iOS/android/handheld specific -->
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php if($mts_options['mts_prefetching'] == '1') { ?>
<?php if (is_front_page()) { ?>
	<?php $my_query = new WP_Query('posts_per_page=1'); while ($my_query->have_posts()) : $my_query->the_post(); ?>
	<link rel="prefetch" href="<?php the_permalink(); ?>">
	<link rel="prerender" href="<?php the_permalink(); ?>">
	<?php endwhile; wp_reset_query(); ?>
<?php } elseif (is_singular()) { ?>
	<link rel="prefetch" href="<?php echo home_url(); ?>">
	<link rel="prerender" href="<?php echo home_url(); ?>">
<?php } ?>
<?php } ?>
<?php }
}

/*------------[ Head ]-------------*/
if ( ! function_exists( 'mts_head' ) ){
	function mts_head() {
	global $mts_options
?>
<?php echo $mts_options['mts_header_code']; ?>
<?php }
}
add_action('wp_head', 'mts_head');



/*------------[ footer ]-------------*/
if ( ! function_exists( 'mts_footer' ) ) {
	function mts_footer() { 
	global $mts_options
?>
<?php if ($mts_options['mts_analytics_code'] != '') { ?>
<!--start footer code-->
<?php echo $mts_options['mts_analytics_code']; ?>
<!--end footer code-->
<?php } ?>
<?php }
}


if ( ! function_exists( 'mts_social_icons' ) ) {
	function mts_social_icons() { 
	global $mts_options;
	if($mts_options['mts_single_social_buttons'] == '1') { ?>
    <!-- Start Share Buttons -->
    <div class="shareit">
        <?php if($mts_options['mts_single_twitter'] == '1') { ?>
            <!-- Twitter -->
            <span class="share-item twitterbtn">
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo $mts_options['mts_twitter_username']; ?>">Tweet</a>
            </span>
        <?php } ?>
        <?php if($mts_options['mts_single_gplus'] == '1') { ?>
            <!-- GPlus -->
            <span class="share-item gplusbtn">
                <g:plusone size="medium"></g:plusone>
            </span>
        <?php } ?>
        <?php if($mts_options['mts_single_facebook'] == '1') { ?>
            <!-- Facebook -->
            <span class="share-item facebookbtn">
                <div id="fb-root"></div>
                <div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
            </span>
        <?php } ?>
        <?php if($mts_options['mts_single_linkedin'] == '1') { ?>
            <!--Linkedin -->
            <span class="share-item linkedinbtn">
                <script type="IN/Share" data-url="<?php get_permalink(); ?>"></script>
            </span>
        <?php } ?>
        <?php if($mts_options['mts_single_stumble'] == '1') { ?>
            <!-- Stumble -->
            <span class="share-item stumblebtn">
                <su:badge layout="1"></su:badge>
            </span>
        <?php } ?>
        <?php if($mts_options['mts_single_pinterest'] == '1') { ?>
            <!-- Pinterest -->
            <span class="share-item pinbtn">
                <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); echo $thumb['0']; ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
            </span>
        <?php } ?>
    </div>
    <!-- end Share Buttons -->
<?php 
		} 
	
	}//end function
} //end function if


// Define ajaxurl for the frontend. 
//The variable contains the url to whom the action with be requested to performs
function add_ajaxurl_cdata_to_front(){ ?>
    <script type="text/javascript"> //<![CDATA[
        ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    //]]> </script>
<?php }
add_action( 'wp_head', 'add_ajaxurl_cdata_to_front', 1);


// Function Call by the AJAX request from portfolio posts on homepage
function ajax_get_portfolio_item() {
    $postId = (int) $_POST['id'];
	$query = new WP_Query('post_type=portfolio&p='.$postId);
	while ($query->have_posts()) : $query->the_post();
        ?>
        <div class="featured_image span_6 col">
			<?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('featured-small', array('title' => '')); ?>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri().'/images/nothumb-portfolio-full.png'; ?>" alt="<?php the_title(); ?>"/>
            <?php endif; ?>
		</div>
		
		<div class="content span_6 col">
			<h2 class="single-title"><?php the_title(); ?></h2>
			<div class="portfolio-content">
	            <?php the_content(); ?>
			</div>
			<div class="close-view">
				<a href="#"><i class="fa fa-times"></i></a>
			</div>
		</div>
    <?php
    endwhile;
    exit;
}
add_action( 'wp_ajax_get_portfolio_item', 'ajax_get_portfolio_item' );
add_action( 'wp_ajax_nopriv_get_portfolio_item', 'ajax_get_portfolio_item' );


function ajax_mts_get_posts() {
    $mts_options = get_option(MTS_THEME_NAME);
    $post_count = 0;
	$start = 2;
	$multiple = 2;
	$finish = 1;
    $page = (int) $_POST['p'];
	$layout = 'column_layout';
	
	$blog_query = new WP_Query();
    $blog_query->query('posts_per_page='.$mts_options['mts_homepage_blog_post_number'].'&paged='.$page);
	
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
	<?php if ( $blog_query->have_posts() ) while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
    
		<?php if(is_multiple($start,$multiple) ): ?>
            <div class="blog_row">
        <?php endif; ?>
    
        <div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
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
                    <?php echo mts_excerpt(27); ?>
                    
                    <a class="reply" href="<?php the_permalink(); ?>"><?php _e("Continue Reading","mythemetop"); ?></a>
                </div>
            </div><!--.post-content box mark-links-->

        </div><!--.g post-->
        
        <?php if(is_multiple($finish,$multiple) || $finish == $post_count): ?>
    	</div>
		<?php endif; ?>
    
    <?php $start++; $finish++; ?>

    <?php endwhile; /* end loop */ ?>

<?php
exit;
}

add_action( 'wp_ajax_mts_get_posts', 'ajax_mts_get_posts' );
add_action( 'wp_ajax_nopriv_mts_get_posts', 'ajax_mts_get_posts' );

function ajaxed_pagination($query, $current = 1, $pages = '') {   

     if($pages == '') {
         $pages = $query->max_num_pages;
         if(!$pages) {
             $pages = 1;
         }
     }   

     if(1 != $pages) {
         echo "<div class=\"ajax-pagination\">";
         
         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages) {
                 echo ($current == $i)? "<a href=\"#\" class=\"paginate-link current\">".$i."</span>":"<a href=\"#\" class=\"paginate-link\">".$i."</a>";
             }
         }
         echo "</div>\n";
     }
}

/*------------[ Class attribute for <article> element ]-------------*/
if ( ! function_exists( 'mts_article_class' ) ) {
    function mts_article_class() {
        $mts_options = get_option( schema );
        $class = '';
        
        // sidebar or full width
        if ( mts_custom_sidebar() == 'mts_nosidebar' ) {
            $class = 'ss-full-width';
        } else {
            $class = 'article';
        }
        
        echo $class;
    }
}
?>