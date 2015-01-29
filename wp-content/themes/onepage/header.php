<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id ="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="main-container-wrap">
		<header class="main-header" <?php if($mts_options['mts_sticky_nav'] == '1') { echo 'id="sticky"'; } ?>>
			<div class="container">
				<div id="header">
					<div class="logo-wrap">
						<?php if ($mts_options['mts_logo'] != '') { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="image-logo">
                                        <?php list($width, $height, $type, $attr) = getimagesize($mts_options['mts_logo']); ?>
										<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>" <?php echo $attr; ?>></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="image-logo">
										<?php list($width, $height, $type, $attr) = getimagesize($mts_options['mts_logo']); ?>
										<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>" <?php echo $attr; ?>></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } else { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="text-logo">
										<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="text-logo">
										<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } ?>
					</div>
					<?php dynamic_sidebar('Header Ad'); ?>
                    
                    <?php if($mts_options['mts_social_icons']): ?>
						<?php if($mts_options['mts_twitter_url'] != '' || $mts_options['mts_facebook_url'] || $mts_options['mts_google_url']
                                || $mts_options['mts_pinterest_url'] != '' || $mts_options['mts_linkedin_url'] || $mts_options['mts_rss_url']): ?>
	                        <div class="social_icons">
	                            <?php if($mts_options['mts_twitter_url'] != ''): ?>
	                            <a class="fa fa-twitter" href="<?php echo $mts_options['mts_twitter_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                            <?php if($mts_options['mts_facebook_url'] != ''): ?>
	                            <a class="fa fa-facebook" href="<?php echo $mts_options['mts_facebook_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                            <?php if($mts_options['mts_google_url'] != ''): ?>
	                            <a class="fa fa-google-plus" href="<?php echo $mts_options['mts_google_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                            <?php if($mts_options['mts_pinterest_url'] != ''): ?>
	                            <a class="fa fa-pinterest" href="<?php echo $mts_options['mts_pinterest_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                            <?php if($mts_options['mts_linkedin_url'] != ''): ?>
	                            <a class="fa fa-linkedin" href="<?php echo $mts_options['mts_linkedin_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                            <?php if($mts_options['mts_rss_url'] != ''): ?>
	                            <a class="fa fa-rss" href="<?php echo $mts_options['mts_rss_url']; ?>"></a>
	                            <?php endif; ?>
	                            
	                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
					<div class="secondary-navigation">
						<nav id="navigation">
	                        <a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu','mythemeshop'); ?></a>
							<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
								<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu primary-menu', 'container' => '', 'walker' => new mts_menu_walker) ); ?>
							<?php } else { ?>
								<ul class="menu primary-menu clearfix">
									<?php wp_list_categories('title_li='); ?>
								</ul>
							<?php } ?>
						</nav>
					</div>
				</div><!--#header-->
			</div><!--.container-->
		</header>
        <?php if(is_page_template( 'page-blog.php' ) && (! empty( $mts_options['mts_homepage_blog_heading']) || ! empty( $mts_options['mts_homepage_blog_subheading'] ) )): ?>
        
	        <?php
				//Checks if body background color is light or dark
				if(is_light_color($mts_options['mts_color_scheme'])){
					$border = '1px solid rgba(0, 0, 0, 0.15)';
					$text_color = '#282828';
				}else{
					$border = '1px solid rgba(255, 255, 255, 0.2)';
					$text_color = '#ffffff';
				}
			?>
			<header>
	            <section class="blog-title">
	                <div class="container">
	                    <?php
	                    // Title
	                    if( ! empty( $mts_options['mts_homepage_blog_heading'] ) ) : ?>
	                        <h1 style="color:<?php echo $text_color; ?>;border-bottom:<?php echo $border; ?>;" class="page-title"><?php print $mts_options['mts_homepage_blog_heading']; ?></h1>
	                	<?php endif; ?>

	                	<?php
	                    // Subtitle
	                    if( ! empty( $mts_options['mts_homepage_blog_subheading'] ) ) : ?>
	                        <h2 style="color:<?php echo $text_color; ?>;" class="page-subtitle"><?php print $mts_options['mts_homepage_blog_subheading']; ?></h2>
	                	<?php endif; ?>
	                </div>
	            </section>
			</header>
        <?php endif; ?>  
	<div class="main-container">