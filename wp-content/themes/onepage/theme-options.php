<?php
/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );
/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'mythemeshop'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'mythemeshop'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'mythemeshop');

//Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
										'link' => 'http://twitter.com/mythemeshopteam',
										'title' => 'Follow Us on Twitter', 
										'img' => 'fa fa-facebook-square'
										);
$args['share_icons']['linked_in'] = array(
										'link' => 'http://www.facebook.com/mythemeshop',
										'title' => 'Like us on Facebook', 
										'img' => 'fa fa-twitter-square'
										);

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = MTS_THEME_NAME;

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __('Theme Options', 'mythemeshop');

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Theme Options', 'mythemeshop');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = 'theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'fa-themes';
		
//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-1',
							'title' => __('Support', 'mythemeshop'),
							'content' => __('<p>If you are facing any problem with our theme or theme option panel, head over to our <a href="http://mythemeshop.com/support">Knowledge Base</a></p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-3',
							'title' => __('Credit', 'mythemeshop'),
							'content' => __('<p>Options Panel created using the <a href="http://leemason.github.com/NHP-Theme-Options-Framework/" target="_blank">NHP Theme Options Framework</a> Version 1.0.5</p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-2',
							'title' => __('Earn Money', 'mythemeshop'),
							'content' => __('<p>Earn 60% commision on every sale by refering your friends and readers. Join our <a href="http://mythemeshop.com/affiliate-program/">Affiliate Program</a>.</p>', 'mythemeshop')
							);

//Set the Help Sidebar for the options page - no sidebar by default										
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'mythemeshop');



$sections = array();

$sections[] = array(
				'icon' => 'fa-cogs',
				'title' => __('General Settings', 'mythemeshop'),
				'desc' => __('<p class="description">This tab contains common setting options which will be applied to the whole theme.</p>', 'mythemeshop'),
				'fields' => array(
				
					array(
						'id' => 'mts_logo',
						'type' => 'upload',
						'title' => __('Logo Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your logo using the Upload Button or insert image URL.', 'mythemeshop')
						),
					array(
						'id' => 'mts_favicon',
						'type' => 'upload',
						'title' => __('Favicon', 'mythemeshop'), 
						'sub_desc' => __('Upload a <strong>16 x 16 px</strong> image that will represent your website\'s favicon. You can refer to this link for more information on how to make it: <a href="http://www.favicon.cc/" target="blank" rel="nofollow">http://www.favicon.cc/</a>', 'mythemeshop')
						),
					array(
                        'id'      => 'mts_homepage_layout',
                        'type'    => 'layout',
                        'title'   => 'Homepage Layout Manager',
                        'sub_desc'    => 'Organize how you want the layout to appear on the homepage.',
                        'options' => array(
                            'enabled'  => array(
                                'blog' => 'Blog',
                                ),
                            'disabled' => array(
                                'slider'     => 'Homepage Slider',
                                'feature'   => 'Features',
                                'counter'   => 'Counters',
                                'team'   => 'Team',
                                'service'   => 'Services',
                                'twitter'   => 'Twitter Tweets',
                                'portfolio'   => 'Portfolio',
                                'pricing'   => 'Pricing Tables',
                                'testimonial'   => 'Testimonials',
                                'clients'   => 'Clients',
								'contact'   => 'Contact',
                                )
                            )
                        ),
					array(
						'id' => 'mts_header_code',
						'type' => 'textarea',
						'title' => __('Header Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the code which you need to place <strong>before closing </head> tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'mythemeshop')
						),
					array(
						'id' => 'mts_analytics_code',
						'type' => 'textarea',
						'title' => __('Footer Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'mythemeshop')
						),
					array(
						'id' => 'mts_copyrights',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'mythemeshop'), 
						'sub_desc' => __('You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)', 'mythemeshop'),
						'std' => 'Theme by <a href="http://mythemeshop.com/">MyThemeShop</a>'
						),
					array(
                        'id' => 'mts_pagenavigation_type',
                        'type' => 'radio',
                        'title' => __('Blog Pagination Type', 'mythemeshop'),
                        'sub_desc' => __('Select pagination type.(Note - This pagination type will apply on seperate blog page only)', 'mythemeshop'),
                        'options' => array(
                            '0'=> __('Default (Next / Previous)','mythemeshop'), 
                            '1' => __('Numbered (1 2 3 4...)','mythemeshop'), 
                            '2' => 'AJAX (Load More Button)', 
                            '3' => 'AJAX (Auto Infinite Scroll)'
                        ),
                        'std' => '0'
                        ),
                    array(
                        'id' => 'mts_ajax_search',
                        'type' => 'button_set',
                        'title' => __('AJAX Quick search', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable search results appearing instantly below the search form', 'mythemeshop'),
						'std' => '0'
                        ),
					array(
						'id' => 'mts_prefetching',
						'type' => 'button_set',
						'title' => __('Prefetching', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in modern browsers.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_lightbox',
						'type' => 'button_set',
						'title' => __('Lightbox', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_twitter_single',
						'type' => 'button_set',
						'title' => __('Tweets on pages', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'), 
						'sub_desc' => __('This will enable twitter feed in the footer of single pages other than homepage, like single posts.', 'mythemeshop'),
						'std' => '0'
                        ),
					array(
						'id' => 'mts_feedburner',
						'type' => 'text',
						'title' => __('FeedBurner URL', 'mythemeshop'),
						'sub_desc' => __('Enter your FeedBurner\'s URL here, ex: <strong>http://feeds.feedburner.com/mythemeshop</strong> and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'mythemeshop'),
						'validate' => 'url'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa-adjust',
				'title' => __('Styling Options', 'mythemeshop'),
				'desc' => __('<p class="description">Control the visual appearance of your theme, such as colors, layout and patterns, from here.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme', 'mythemeshop'), 
						'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'mythemeshop'),
						'std' => '#e16e7b'
						),
					array(
						'id' => 'mts_bg_color',
						'type' => 'color',
						'title' => __('Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the background.', 'mythemeshop'),
						'std' => '#eeeeee'
						),
					array(
						'id' => 'mts_bg_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
							'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
							'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
							'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
							'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
							'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
							'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
							'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
							'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
							'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
							'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
							'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
							'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
							'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
							'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
							'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
							'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
							'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
							'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
							'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
							'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
							'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
							'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
							'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
							'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
							'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
							'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
							'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
							'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
							'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
							'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
							'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
							'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
							'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
							'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
							'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
							'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
							'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
							'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
							'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
							'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
							'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
							'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
							'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
							'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
							'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
							'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
							'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
							'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
							'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
							'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
							'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
							'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
							'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
							'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
							'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
							'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
							'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
							'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
							'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
							'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
							'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
							'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
							'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
							'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
								),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_bg_pattern_upload',
						'type' => 'upload',
						'title' => __('Custom Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom background image or pattern.', 'mythemeshop')
						),
					array(
						'id' => 'mts_custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'mythemeshop'), 
						'sub_desc' => __('You can enter custom CSS code here to further customize your theme. This will override the default CSS used on your site.', 'mythemeshop')
						),																		
                    array(
						'id' => 'mts_footer_background_color',
						'type' => 'color',
						'title' => __('Footer Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the background of the footer area.', 'mythemeshop'),
						'std' => '#282828'
						),
					array(
						'id' => 'mts_footer_background_pattern',
						'type' => 'radio_img',
						'title' => __('Footer Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
							'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
							'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
							'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
							'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
							'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
							'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
							'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
							'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
							'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
							'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
							'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
							'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
							'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
							'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
							'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
							'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
							'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
							'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
							'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
							'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
							'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
							'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
							'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
							'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
							'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
							'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
							'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
							'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
							'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
							'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
							'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
							'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
							'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
							'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
							'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
							'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
							'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
							'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
							'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
							'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
							'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
							'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
							'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
							'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
							'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
							'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
							'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
							'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
							'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
							'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
							'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
							'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
							'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
							'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
							'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
							'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
							'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
							'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
							'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
							'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
							'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
							'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
							'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
							'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
								),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_footer_background_pattern_upload',
						'type' => 'upload',
						'title' => __('Footer Custom Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom background image or pattern.', 'mythemeshop')
						),
                    ),
				);
$sections[] = array(
				'icon' => 'fa-credit-card',
				'title' => __('Header', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the elements of header section.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_sticky_nav',
						'type' => 'button_set',
						'title' => __('Floating Navigation Menu', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to enable <strong>Floating Navigation Menu</strong>.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_header_section2',
						'type' => 'button_set',
						'title' => __('Show Logo', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide <strong>Logo</strong> completely.', 'mythemeshop'),
						'std' => '1'
						),
                    array(
						'id' => 'mts_header_background_color',
						'type' => 'color',
						'title' => __('Header Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the background.', 'mythemeshop'),
						'std' => '#282828'
						),
					array(
						'id' => 'mts_header_background_pattern',
						'type' => 'radio_img',
						'title' => __('Header Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
							'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
							'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
							'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
							'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
							'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
							'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
							'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
							'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
							'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
							'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
							'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
							'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
							'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
							'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
							'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
							'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
							'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
							'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
							'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
							'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
							'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
							'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
							'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
							'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
							'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
							'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
							'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
							'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
							'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
							'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
							'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
							'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
							'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
							'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
							'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
							'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
							'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
							'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
							'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
							'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
							'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
							'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
							'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
							'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
							'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
							'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
							'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
							'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
							'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
							'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
							'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
							'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
							'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
							'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
							'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
							'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
							'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
							'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
							'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
							'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
							'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
							'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
							'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
							'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
							),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_header_background_pattern_upload',
						'type' => 'upload',
						'title' => __('Header Custom Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom background image or pattern.', 'mythemeshop')
						),
					array(
						'id' => 'mts_social_icons',
						'type' => 'button_set_hide_below',
						'title' => __('Show Social Icons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> social icons that display in the header.', 'mythemeshop'),
						'std' => '0',
	                    'args' => array('hide' => 6)
						),
						array(
							'id' => 'mts_twitter_url',
							'type' => 'text',
							'title' => __( 'Twitter URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your Twitter page.', 'mythemeshop' )
						),
						array(
							'id' => 'mts_facebook_url',
							'type' => 'text',
							'title' => __( 'Facebook URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your Facebook page.', 'mythemeshop' )
						),						
						array(
							'id' => 'mts_google_url',
							'type' => 'text',
							'title' => __( 'Google Plus URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your Google Plus page.', 'mythemeshop' )
						),
						array(
							'id' => 'mts_pinterest_url',
							'type' => 'text',
							'title' => __( 'Pinterest URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your Pinterest page.', 'mythemeshop' )
						),						
						array(
							'id' => 'mts_linkedin_url',
							'type' => 'text',
							'title' => __( 'Linkedin URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your Linkedin page.', 'mythemeshop' )
						),						
						array(
							'id' => 'mts_rss_url',
							'type' => 'text',
							'title' => __( 'RSS URL', 'mythemeshop' ),
							'sub_desc' => __( 'Enter the full URL to your RSS feed.', 'mythemeshop' )
						),
					)
				);	
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Slider', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the elements of the homepage.</p>', 'mythemeshop'),
				'fields' => array(
				  	array(
						'id'        => 'mts_custom_slider',
						'type'      => 'group',
						'title'     => __('Custom Slider', 'mythemeshop'), 
						'sub_desc'  => __('You can set up a slider with custom image and text instead of the default slider automatically generated from your posts.', 'mythemeshop'),
						'groupname' => __('Slider', 'mythemeshop'), // Group name
						'subfields' => array(
							array(
								'id' => 'mts_custom_slider_title',
								'type' => 'text',
								'title' => __('Title', 'mythemeshop'), 
								'sub_desc' => __('Title of the slide', 'mythemeshop'),
								),
							array(
								'id' => 'mts_custom_slider_image',
								'type' => 'upload',
								'title' => __('Image', 'mythemeshop'), 
								'sub_desc' => __('Upload or select an image for this slide.(Recommended size - 1900x800', 'mythemeshop'),
								),
							array(
								'id' => 'mts_slider_overlay_color',
								'type' => 'color',
								'title' => __( 'Slider Overlay Color', 'mythemeshop' ),
								'sub_desc' => __( 'Choose overlay color for this Slide', 'mythemeshop' ),
	                            'std' => '#e16e7b'
							),
							array('id' => 'mts_custom_slider_text',
								'type' => 'textarea',
								'title' => __('Description', 'mythemeshop'), 
								'sub_desc' => __('Description of the slide', 'mythemeshop'),
								), 
							array('id' => 'mts_custom_slider_link',
								'type' => 'text',
								'title' => __('Link', 'mythemeshop'), 
								'sub_desc' => __('Insert a link URL for the slide', 'mythemeshop'),
								'std' => '#'
								),
							),
						),
					array(
						'id' => 'mts_homepage_background_color',
						'type' => 'color',
						'title' => __( 'Background Color', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                        'std' => '#EFEDEE'
					),
                    array(
						'id' => 'mts_homepage_background_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
						'options' => array(
							'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
							'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
							'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
							'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
							'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
							'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
							'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
							'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
							'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
							'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
							'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
							'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
							'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
							'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
							'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
							'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
							'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
							'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
							'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
							'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
							'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
							'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
							'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
							'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
							'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
							'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
							'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
							'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
							'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
							'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
							'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
							'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
							'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
							'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
							'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
							'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
							'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
							'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
							'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
							'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
							'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
							'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
							'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
							'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
							'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
							'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
							'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
							'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
							'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
							'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
							'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
							'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
							'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
							'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
							'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
							'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
							'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
							'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
							'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
							'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
							'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
							'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
							'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
							'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
								),
						'std' => 'nobg'
					),
					array(
						'id' => 'mts_homepage_background_image',
						'type' => 'upload',
						'title' => __( 'Homepage Background Image', 'mythemeshop' ),
						'sub_desc' => __( 'Non-repeating background image that will only appear on the homepage.', 'mythemeshop' )
					),
					array(
						'id' => 'mts_homepage_background_parallax',
						'type' => 'button_set',
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0',
						'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
						'sub_desc' => __('Controls whether the background image has parallax scrolling enabled.','mythemeshop' ),
					),

					array(
						'id' => 'mts_homepage_buttons_enable',
						'type' => 'button_set_hide_below',
						'title' => __('Call to action buttons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> call to action buttons that display below header slider.', 'mythemeshop'),
						'std' => '0',
						'args' => array('hide' => 2)
					),
					 array(
						'id' => 'mts_homepage_buttons',
						'title' => 'Homepage Buttons',
						'sub_desc' => __( 'Buttons to display underneath the homepage slider.', 'mythemeshop' ),
						'type' => 'group',
						'groupname' => __('Button', 'mythemeshop'), // Group name
						'subfields' => 
							array(
								array(
									'id' => 'mts_homepage_button_label',
									'type' => 'text',
									'title' => __('Button Label', 'mythemeshop')
									),	
								array(
									'id' => 'mts_homepage_button_url',
									'type' => 'text',
									'title' => __('Button URL', 'mythemeshop'), 
									'sub_desc' => __('Make sure to include http://', 'mythemeshop'),
									'std' => '#'
									),
								array(
									'id' => 'mts_homepage_button_icon',
									'type' => 'icon_select',
									'title' => __('Icon', 'mythemeshop')
								),
								array(
									'id' => 'mts_slider_button_color',
									'type' => 'color',
									'title' => __( 'Button Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Choose button background color.', 'mythemeshop' ),
		                            'std' => '#282828'
								),
							),
						),
						array(
							'id' => 'mts_homepage_buttons_background_color',
							'type' => 'color',
							'title' => __( 'Background Color', 'mythemeshop' ),
							'sub_desc' => __( 'Edit the background color for the buttons section', 'mythemeshop' ),
                        'std' => '#FFFFFF'
						),
					)
				);


/* ==========================================================================
   Features
   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Features', 'mythemeshop'),
				'desc' => __('<p class="description">Choose what you would like to feature.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_homepage_features_heading',
						'type' => 'text',
						'title' => __( 'Heading', 'mythemeshop' ),
						'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_features_subheading',
						'type' => 'text',
						'title' => __( 'Subheading', 'mythemeshop' ),
						'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_features_background_color',
						'type' => 'color',
						'title' => __( 'Background Color', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                        'std' => '#efedee'
					),
                    array(
						'id' => 'mts_homepage_features_background_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
											),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_homepage_features_background_image',
						'type' => 'upload',
						'title' => __( 'Background Image', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_features_parallax',
						'type' => 'button_set',
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0',
						'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
						'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
					),
					array(
                        'id' => 'mts_homepage_features_columns',
                        'type' => 'button_set',
                        'title' => __('Features Columns', 'mythemeshop'), 
						'options' => array('3' => 'Three Columns','4' => 'Four Columns'),
						'sub_desc' => __('Choose how many columns are displayed on homepage under the Features section.', 'mythemeshop'),
						'std' => '3',
						'class' => 'green'
                        ),
					array(
                     	'id' => 'mts_homepage_features',
                     	'title' => 'Features',
                     	'sub_desc' => __( 'Add "features" to your homepage to promote specifics of your company, service, brand, etc.', 'mythemeshop' ),
                     	'type' => 'group',
                     	'groupname' => __('Feature', 'mythemeshop'), // Group name
                     	'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_homepage_feature_title',
            						'type' => 'text',
            						'title' => __('Title', 'mythemeshop'), 
            						),
								array(
                                    'id' => 'mts_homepage_feature_image',
            						'type' => 'icon_select',
            						'title' => __('Icon', 'mythemeshop')
            						),
						array(
							'id' => 'mts_feature_icon_color',
							'type' => 'color',
							'title' => __( 'Icon Color', 'mythemeshop' ),
							'sub_desc' => __( 'Choose Icon color.', 'mythemeshop' ),
                            'std' => '#e16e7b'
						),
                                array(
                                    'id' => 'mts_homepage_feature_description',
            						'type' => 'textarea',
            						'title' => __('Description', 'mythemeshop'), 
            						),
                            ),
                        )
				)
			);

/* ==========================================================================
   Counter
   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Counter', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the counter section on the homepage.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_homepage_counter_heading',
						'type' => 'text',
						'title' => __( 'Heading', 'mythemeshop' ),
						'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_counter_subheading',
						'type' => 'text',
						'title' => __( 'Subheading', 'mythemeshop' ),
						'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_counter_background_color',
						'type' => 'color',
						'title' => __( 'Background Color', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                        'std' => '#2d2d2d'
					),
                    array(
						'id' => 'mts_homepage_counter_background_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
											),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_homepage_counter_background_image',
						'type' => 'upload',
						'title' => __( 'Background Image', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_homepage_counter_parallax',
						'type' => 'button_set',
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0',
						'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
						'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
					),
					array(
                     	'id' => 'mts_homepage_counter',
                     	'title' => 'Counter',
                     	'sub_desc' => __( 'Counter section to display statistics.', 'mythemeshop' ),
                     	'type' => 'group',
                     	'groupname' => __('Statistic', 'mythemeshop'), // Group name
                     	'subfields' => 
                            array(
                            	array(
                                    'id' => 'mts_homepage_counter_number',
            						'type' => 'text',
            						'title' => __('Number', 'mythemeshop'), 
            						'args' => array('type' => 'number')
            						),
                                array(
                                    'id' => 'mts_homepage_counter_description',
            						'type' => 'textarea',
            						'title' => __('Description', 'mythemeshop')
            						),	

                            ),
                        )
				)
			);

	/* ==========================================================================
	   Team
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Team', 'mythemeshop'),
				'desc' => __('<p class="description">Manage your team members and their contact information.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_team_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_team_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_team_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#efedee'
								),
                                array(
            						'id' => 'mts_homepage_team_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_team_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_team_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
								    'id' => 'mts_homepage_team_columns',
								    'type' => 'button_set',
								    'title' => __('Team Columns', 'mythemeshop'), 
									'options' => array('3' => 'Three Columns','4' => 'Four Columns'),
									'sub_desc' => __('Choose how many columns are displayed on homepage under the Team section.', 'mythemeshop'),
									'std' => '4',
									'class' => 'green'
								    ),
								array(
								 	'id' => 'mts_homepage_team',
								 	'title' => 'Team',
								 	'sub_desc' => __( 'Add employees or team members for display on the homepage.', 'mythemeshop' ),
								 	'type' => 'group',
								 	'groupname' => __('Team Member', 'mythemeshop'), // Group name
								 	'subfields' => 
								        array(
								            array(
								                'id' => 'mts_homepage_team_name',
												'type' => 'text',
												'title' => __('Name', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_team_image',
												'type' => 'upload',
												'title' => __('Photo', 'mythemeshop'),
												'return' => 'id'
												),	
								            array(
								                'id' => 'mts_homepage_team_position',
												'type' => 'text',
												'title' => __('Position', 'mythemeshop'), 
												),
								            array(
								                'id' => 'mts_homepage_team_info',
												'type' => 'textarea',
												'title' => __('Info', 'mythemeshop'), 
												),
								            array(
								                'id' => 'mts_homepage_team_google',
												'type' => 'text',
												'title' => __('Google Plus', 'mythemeshop'), 
												),
								            array(
								                'id' => 'mts_homepage_team_twitter',
												'type' => 'text',
												'title' => __('Twitter', 'mythemeshop'), 
												),
								            array(
								                'id' => 'mts_homepage_team_facebook',
												'type' => 'text',
												'title' => __('Facebook', 'mythemeshop'), 
												),
								        ),
								    ),
								)
							);

	/* ==========================================================================
	   Services
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Services', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the carousel.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_service_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_service_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_service_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#ffffff'
								),
                                array(
            						'id' => 'mts_homepage_service_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_service_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_service_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
								    'id' => 'mts_homepage_service_columns',
								    'type' => 'button_set',
								    'title' => __('Service Blocks Per Slide', 'mythemeshop'), 
									'options' => array('2' => 'Two Blocks', '3' => 'Three Blocks','4' => 'Four Blocks'),
									'sub_desc' => __('Choose how many columns are displayed on homepage under the service section.', 'mythemeshop'),
									'std' => '4',
									'class' => 'green'
								    ),
								array(
								 	'id' => 'mts_homepage_service',
								 	'title' => 'Service Items',
								 	'sub_desc' => __( 'Manage service items.', 'mythemeshop' ),
								 	'type' => 'group',
								 	'groupname' => __('Service Item', 'mythemeshop'), // Group name
								 	'subfields' => 
								        array(
								            array(
								                'id' => 'mts_homepage_service_title',
												'type' => 'text',
												'title' => __('Title', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_service_image',
												'type' => 'icon_select',
												'title' => __('Icon', 'mythemeshop')
												),
						array(
							'id' => 'mts_service_icon_color',
							'type' => 'color',
							'title' => __( 'Icon Background Color', 'mythemeshop' ),
							'sub_desc' => __( 'Choose Icon background color.', 'mythemeshop' ),
                            'std' => '#e16e7b'
						),
								            array(
								                'id' => 'mts_homepage_service_description',
												'type' => 'textarea',
												'title' => __('Description', 'mythemeshop'), 
												)
								        ),
								    ),
								)
							);

/* ==========================================================================
   Twitter feed
   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Twitter', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control Latest Tweets section on Homepage. (Same settings will be used if you have enabled Tweets section on Single Posts.)', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'homepage_twitter_username',
						'type' => 'text',
						'title' => __( 'Twitter Username', 'mythemeshop' )
					),
					array(
						'id' => 'homepage_twitter_tweet_count',
						'type' => 'text',
						'title' => __( 'Tweet Count', 'mythemeshop' ),
						'sub_desc' => __( 'How many tweets should be displayed.', 'mythemeshop'),
						'args' => array('type' => 'number'),
						'std' => '3',
						'class' => 'small-text'
					),
					array(
						'id' => 'homepage_twitter_background_color',
						'type' => 'color',
						'title' => __( 'Background Color', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                        'std' => '#f87a85'
					),
                    array(
						'id' => 'mts_homepage_twitter_background_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
											),
						'std' => 'nobg'
						),
					array(
						'id' => 'homepage_twitter_background_image',
						'type' => 'upload',
						'title' => __( 'Background Image', 'mythemeshop' ),
						'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
					),
					array(
						'id' => 'homepage_twitter_parallax',
						'type' => 'button_set',
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0',
						'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
						'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
					),
					array(
						'id' => 'homepage_twitter_slider',
						'type' => 'button_set',
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0',
						'title' => __( 'Auto rotation', 'mythemeshop' ),
						'sub_desc' => __( 'Checking this option will enable auto rotation of multiple tweets', 'mythemeshop' ),
					),
					array(
						'id' => 'mts_twotter_info',
						'type' => 'info',
						'desc' => __('<p><strong>Note:</strong> Visit <a href="https://dev.twitter.com/apps/" target="_blank">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you don\'t have already</p>', 'mythemeshop')
						),
					array(
						'id' => 'homepage_twitter_api_key',
						'type' => 'text',
						'title' => __( 'API key', 'mythemeshop' ),
						'sub_desc' => __( 'This can be found in your Twitter Developer Application Management page.', 'mythemeshop')
					),
					array(
						'id' => 'homepage_twitter_api_secret',
						'type' => 'text',
						'title' => __( 'API secret', 'mythemeshop' ),
						'sub_desc' => __( 'This can be found in your Twitter Developer Application Management page.', 'mythemeshop')
					),
					array(
						'id' => 'homepage_twitter_access_token',
						'type' => 'text',
						'title' => __( 'Access token', 'mythemeshop' ),
						'sub_desc' => __( 'This can be found in your Twitter Developer Application Management page.', 'mythemeshop')
					),
					array(
						'id' => 'homepage_twitter_access_token_secret',
						'type' => 'text',
						'title' => __( 'Access token secret', 'mythemeshop' ),
						'sub_desc' => __( 'This can be found in your Twitter Developer Application Management page.', 'mythemeshop')
					),
				)
			);


	/* ==========================================================================
	   Portfolio
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Portfolio', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the portfolio section. You can manage portfolio items in the <a target="_blank" href="'.admin_url("edit.php?post_type=portfolio").'">Portfolio</a> section of your WordPress dashboard.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_portfolio_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_portfolio_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_portfolio_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#ffffff'
								),
                                array(
            						'id' => 'mts_homepage_portfolio_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_portfolio_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_portfolio_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								)
							);


	/* ==========================================================================
	   Pricing
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Pricing', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the pricing section.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_pricing_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_pricing_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_pricing_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#282828'
								),
                                array(
            						'id' => 'mts_homepage_pricing_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_pricing_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_pricing_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
								 	'id' => 'mts_homepage_pricing_tables',
								 	'title' => 'Pricing tables',
								 	'sub_desc' => __( 'Manage pricing tables.', 'mythemeshop' ),
								 	'type' => 'group',
								 	'groupname' => __('Table', 'mythemeshop'), // Group name
								 	'subfields' => 
								        array(
								            array(
								                'id' => 'mts_homepage_table_title',
												'type' => 'text',
												'title' => __('Table title', 'mythemeshop')
												),	
								            array(
								                'id' => 'mts_homepage_table_price',
												'type' => 'text',
												'title' => __('Price', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_table_price_description',
												'type' => 'text',
												'title' => __('Price description', 'mythemeshop'), 
												),
								            array(
								                'id' => 'mts_homepage_table_features',
												'type' => 'textarea',
												'title' => __('Table Features (Separate by entering one per line)', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_table_button',
												'type' => 'text',
												'title' => __('Button Label', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_table_button_url',
												'type' => 'text',
												'title' => __('Button URL', 'mythemeshop'), 
												),
											array(
								                'id' => 'mts_homepage_table_highlight',
												'type' => 'checkbox',
												'title' => __('Enable highlighted style', 'mythemeshop'), 
												),
								        ),
								    ),
								)
							);

	/* ==========================================================================
	   Testimonials
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Testimonials', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the testimonial section.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_testimonials_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_testimonials_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_testimonials_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#efedee'
								),
                                array(
            						'id' => 'mts_homepage_testimonials_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_testimonials_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_testimonials_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
								 	'id' => 'mts_homepage_testimonials',
								 	'title' => 'Testimonial Items',
								 	'sub_desc' => __( 'Manage testimonial items.', 'mythemeshop' ),
								 	'type' => 'group',
								 	'groupname' => __('Testimonial Item', 'mythemeshop'), // Group name
								 	'subfields' => 
								        array(
								            array(
								                'id' => 'mts_homepage_testifier_title',
												'title' => __('Name', 'mythemeshop'), 
												'type' => 'text',
												),
											array(
								                'id' => 'mts_homepage_testifier_image',
												'title' => __('Image', 'mythemeshop'),
												'type' => 'upload',												
												'return' => 'id'
												),	
								            array(
								                'id' => 'mts_homepage_testifier_description',
												'title' => __('Description', 'mythemeshop'), 
												'type' => 'textarea',
												)
								        ),
								    ),
								)
							);


	/* ==========================================================================
	   Clients
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Clients', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the client section.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_client_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_client_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_client_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#ffffff'
								),
                                array(
            						'id' => 'mts_homepage_client_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_client_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_client_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
								 	'id' => 'mts_homepage_clients',
								 	'title' => 'Clients',
								 	'sub_desc' => __( 'Manage clients.', 'mythemeshop' ),
								 	'type' => 'group',
								 	'groupname' => __('Client', 'mythemeshop'), // Group name
								 	'subfields' => 
								        array(
								            array(
								                'id' => 'mts_homepage_client_image',
												'title' => __('Logo', 'mythemeshop'),
												'type' => 'upload',
												),	
								            array(
								                'id' => 'mts_homepage_client_url',
												'title' => __('Client url', 'mythemeshop'), 
												'type' => 'text',
												),
								        ),
								    ),
								)
							);


	/* ==========================================================================
	   Homepage Blog
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Blog', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the homepage blog section. <strong>Note:</strong> Same settings will be used on Seperate Blog page.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_blog_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_blog_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_blog_post_number',
									'type' => 'text',
									'title' => __( 'Number of posts', 'mythemeshop' ),
									'sub_desc' => __( 'Enter the number of posts to show in blog section on homepage', 'mythemeshop' ),
									'std' => '4',
								),
								array(
									'id' => 'mts_homepage_blog_layout',
									'type' => 'button_set_hide_below',
									'title' => __('Blog Layout', 'mythemeshop'), 
									'options' => array('1' => __('Grid','mythemeshop'),'2' => __('Traditional','mythemeshop')),
									'sub_desc' => __('Select the layout for blog section.', 'mythemeshop'),
									'std' => '1',
									'class' => 'green',
						'args' => array(
							'hide' => 2
						)
									),
                    array(
                        'id' => 'mts_full_posts',
                        'type' => 'button_set',
                        'title' => __('Posts on blog pages', 'mythemeshop'), 
						'options' => array('0' => 'Excerpts','1' => 'Full posts'),
						'sub_desc' => __('Show post excerpts or full posts on the homepage and other archive pages.', 'mythemeshop'),
						'std' => '0',
                        'class' => 'green'
                        ),
					array(
						'id' => 'mts_layout',
						'type' => 'radio_img',
						'title' => __('Blog Layout Style', 'mythemeshop'), 
						'sub_desc' => __('Choose from <strong>2 default layouts</strong> for your Blog. You can also set different layout for individual pages and posts.', 'mythemeshop'),
						'options' => array(
										'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
										'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
											),
						'std' => 'cslayout'
						),
                                array(
									'id' => 'mts_homepage_blog_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#efedee'
								),
                                array(
            						'id' => 'mts_homepage_blog_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_blog_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_blog_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								)
							);

	/* ==========================================================================
	   Contact
	   ========================================================================== */
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Contact', 'mythemeshop'),
				'desc' => __('<p class="description">Manage the content displayed on the contact section.</p>', 'mythemeshop'),
				'fields' => array(
								array(
									'id' => 'mts_homepage_contact_heading',
									'type' => 'text',
									'title' => __( 'Heading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the heading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_subheading',
									'type' => 'text',
									'title' => __( 'Subheading', 'mythemeshop' ),
									'sub_desc' => __( 'Controls the subheading for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_background_color',
									'type' => 'color',
									'title' => __( 'Background Color', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background color for the section', 'mythemeshop' ),
                                    'std' => '#ffffff'
								),
                                array(
            						'id' => 'mts_homepage_contact_background_pattern',
            						'type' => 'radio_img',
            						'title' => __('Background Pattern', 'mythemeshop'), 
            						'sub_desc' => __('Choose one from the <strong>37</strong> awesome background patterns.', 'mythemeshop'),
            						'options' => array(
            										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
            										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
            										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
            										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
            										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
            										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
            										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
            										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
            										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
            										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
            										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
            										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
            										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
            										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
            										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
            										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
            										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
            										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
            										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
            										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
            										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
            										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
            										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
            										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
            										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
            										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
            										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
            										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
            										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
            										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
            										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
            										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
            										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
            										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
            										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
            										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
            										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
            										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
            										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
            										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
            										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
            										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
            										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
            										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
            										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
            										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
            										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
            										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
            										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
            										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
            										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
            										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
            										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
            										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
            										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
            										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
            										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
            										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
            										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
            										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
            										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
            										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
            										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
            										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
            											),
            						'std' => 'nobg'
            						),
								array(
									'id' => 'mts_homepage_contact_background_image',
									'type' => 'upload',
									'title' => __( 'Background Image', 'mythemeshop' ),
									'sub_desc' => __( 'Edit the background image for the section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_parallax',
									'type' => 'button_set',
									'options' => array('0' => 'Off','1' => 'On'),
									'std' => '0',
									'title' => __( 'Enable Parallax Background', 'mythemeshop' ),
									'sub_desc' => __( 'Controls whether the background image has parallax scrolling enabled.', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_address',
									'type' => 'text',
									'title' => __( 'Contact Address', 'mythemeshop' ),
									'sub_desc' => __( 'Add a contact address to your contact section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_number',
									'type' => 'text',
									'title' => __( 'Contact Number', 'mythemeshop' ),
									'sub_desc' => __( 'Add a contact number to your contact section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_email',
									'type' => 'text',
									'title' => __( 'Contact Email', 'mythemeshop' ),
									'sub_desc' => __( 'Add a contact email to your contact section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_homepage_contact_social_icons',
									'type' => 'checkbox',
									'title' => __( 'Social icons', 'mythemeshop' ),
									'sub_desc' => __( 'Enable social icons present in header also in contact section. Settings to lenk these icons can be found in header section', 'mythemeshop' ),
								),
								array(
									'id' => 'mts_map_coordinates',
									'type' => 'text',
									'title' => __('Map Coordinates', 'mythemeshop'),
									'sub_desc' => __('Enter the longitude and latitude or full address e.g. 47.6203394,-122.3491925', 'mythemeshop')
								),
								)
							);


$sections[] = array(
				'icon' => 'fa-file-text',
				'title' => __('Single Posts', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the appearance and functionality of your single posts page.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_single_featured',
						'type' => 'button_set',
						'title' => __('Single Featured Image', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide <strong>Featured Image </strong> on single posts.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_single_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('Post Meta Info.', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info <strong>Author name and Categories</strong>.', 'mythemeshop'),
						'std' => '1'
						),
						array(
 						'id' => 'mts_single_headline_meta_info',
 						'type' => 'multi_checkbox',
 						'title' => __('Meta Info to Show', 'mythemeshop'),
 						'sub_desc' => __('Choose What Meta Info to Show.', 'mythemeshop'),
 						'options' => array('author' => __('Author Name','mythemeshop'),'date' => __('Date','mythemeshop'),'category' => __('Categories','mythemeshop'),'comment' => __('Comment Count','mythemeshop')),
 						'std' => array('author' => '1', 'date' => '1', 'category' => '1', 'comment' => '1')
 						),
					array(
						'id' => 'mts_breadcrumb',
						'type' => 'button_set',
						'title' => __('Breadcrumbs', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_author_comment',
						'type' => 'button_set',
						'title' => __('Highlight Author Comment', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to highlight author comments.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_tags',
						'type' => 'button_set',
						'title' => __('Tag Links', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to show a tag cloud below the related posts.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_author_box',
						'type' => 'button_set',
						'title' => __('Author Box', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to display author information below the article.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_related_posts',
						'type' => 'button_set_hide_below',
						'title' => __('Related Posts', 'mythemeshop') ,
						'options' => array(
							'0' => 'Off',
							'1' => 'On'
						) ,
						'sub_desc' => __('Use this button to show related posts with thumbnails below the content area in a post.', 'mythemeshop') ,
						'std' => '1',
						'args' => array(
							'hide' => 2
						)
					) ,
					array(
						'id' => 'mts_related_posts_taxonomy',
						'type' => 'button_set',
						'title' => __('Related Posts Taxonomy', 'mythemeshop') ,
						'options' => array(
							'tags' => 'Tags',
							'categories' => 'Categories'
						) ,
						'class' => 'green',
						'sub_desc' => __('Related Posts based on tags or categories.', 'mythemeshop') ,
						'std' => 'categories'
					) ,
					array(
						'id' => 'mts_related_postsnum',
						'type' => 'text',
						'class' => 'small-text',
						'title' => __('Number of related posts', 'mythemeshop') ,
						'sub_desc' => __('Enter the number of posts to show in the related posts section.', 'mythemeshop') ,
						'std' => '4',
						'args' => array(
							'type' => 'number'
						)
					) ,
					array(
						'id' => 'mts_comment_date',
						'type' => 'button_set',
						'title' => __('Date in Comments', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to show the date for comments.', 'mythemeshop'),
						'std' => '1'
						),
					
					)
				);
$sections[] = array(
				'icon' => 'fa-home',
				'title' => __('Share Buttons', 'mythemeshop'),
				'desc' => __('<p class="description">From here you can control Social Media Sharing buttons on single blog posts.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_single_social_buttons',
						'type' => 'button_set_hide_below',
						'title' => __('Social Media Buttons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Check this box to show social sharing buttons after an article\'s content text.', 'mythemeshop'),
						'std' => '1',
                        'args' => array('hide' => 7)
						),
					array(
						'id' => 'mts_single_social_button_position',
						'type' => 'button_set',
						'title' => __('Social Sharing Buttons Position', 'mythemeshop'), 
						'options' => array('1' => __('Above Content','mythemeshop'),'2' => __('Below Content','mythemeshop')),
						'sub_desc' => __('Choose position for Social Sharing Buttons.', 'mythemeshop'),
						'std' => '2',
						'class' => 'green'
						),
					array(
						'id' => 'mts_single_twitter',
						'type' => 'button_set',
						'title' => __('Twitter', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_single_gplus',
						'type' => 'button_set',
						'title' => __('Google Plus', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_single_facebook',
						'type' => 'button_set',
						'title' => __('Facebook Like', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_single_linkedin',
						'type' => 'button_set',
						'title' => __('LinkedIn', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_single_stumble',
						'type' => 'button_set',
						'title' => __('StumbleUpon', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_single_pinterest',
						'type' => 'button_set',
						'title' => __('Pinterest', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa-bar-chart-o',
				'title' => __('Ad Management', 'mythemeshop'),
				'desc' => __('<p class="description">Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_posttop_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Title', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_posttop_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad before it expires. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					array(
						'id' => 'mts_postend_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Content', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_postend_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad before it expires. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					)
				);
$sections[] = array(
				'icon' => 'fa-columns',
				'title' => __('Sidebars', 'mythemeshop'),
				'desc' => __('<p class="description">Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.<br></p>', 'mythemeshop'),
                'fields' => array(
                    array(
                        'id'        => 'mts_custom_sidebars',
                        'type'      => 'group', //doesn't need to be called for callback fields
                        'title'     => __('Custom Sidebars', 'mythemeshop'), 
                        'sub_desc'  => __('Add custom sidebars. <strong style="font-weight: 800;">You need to save the changes to use the sidebars in the dropdowns below.</strong><br />You can add content to the sidebars in Appearance &gt; Widgets.', 'mythemeshop'),
                        'groupname' => __('Sidebar', 'mythemeshop'), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_custom_sidebar_name',
            						'type' => 'text',
            						'title' => __('Name', 'mythemeshop'), 
            						'sub_desc' => __('Example: Homepage Sidebar', 'mythemeshop')
            						),	
                                array(
                                    'id' => 'mts_custom_sidebar_id',
            						'type' => 'text',
            						'title' => __('ID', 'mythemeshop'), 
            						'sub_desc' => __('Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"', 'mythemeshop'),
            						'std' => 'sidebar-'
            						),
                            ),
                        ),
                    array(
						'id' => 'mts_sidebar_for_post',
						'type' => 'sidebars_select',
						'title' => __('Single post', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_page',
						'type' => 'sidebars_select',
						'title' => __('Single page', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_archive',
						'type' => 'sidebars_select',
						'title' => __('Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_category',
						'type' => 'sidebars_select',
						'title' => __('Category Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the category archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_tag',
						'type' => 'sidebars_select',
						'title' => __('Tag Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the tag archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_date',
						'type' => 'sidebars_select',
						'title' => __('Date Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the date archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_author',
						'type' => 'sidebars_select',
						'title' => __('Author Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the author archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_search',
						'type' => 'sidebars_select',
						'title' => __('Search', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the search results.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_notfound',
						'type' => 'sidebars_select',
						'title' => __('404 Error', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the 404 Not found pages.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar')),
                        'std' => ''
						),
                    ),
				);
//$sections[] = array(
//				'icon' => NHP_OPTIONS_URL.'img/glyphicons/fontsetting.png',
//				'title' => __('Fonts', 'mythemeshop'),
//				'desc' => __('<p class="description"><div class="controls">You can find theme font options under the Appearance Section named <a href="themes.php?page=typography"><b>Theme Typography</b></a>, which will allow you to configure the typography used on your site.<br></div></p>', 'mythemeshop'),
//				);
$sections[] = array(
				'icon' => 'fa-list-alt',
				'title' => __('Navigation', 'mythemeshop'),
				'desc' => __('<p class="description"><div class="controls">Navigation settings can now be modified from the <a href="nav-menus.php"><b>Menus Section</b></a>.<br></div></p>', 'mythemeshop')
				);
				
				
	$tabs = array();

	$args['presets'] = array();
	include('theme-presets.php');

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function

/*--------------------------------------------------------------------
 * 
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('register_typography')) { 
  register_typography(array(
  	'logo_font' => array(
      'preview_text' => 'Logo Font',
      'preview_color' => 'dark',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '38px',
      'font_color' => '#E16E7B',
      'css_selectors' => '#logo a',
      'additional_css' => 'text-transform: uppercase;',
    ),
    'navigation_font' => array(
      'preview_text' => 'Navigation Font',
      'preview_color' => 'dark',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '14px',
      'font_color' => '#c5c5c5',
      'css_selectors' => '.menu li, .menu li a'
    ),
    'content_font' => array(
      'preview_text' => 'Content Font',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '16px',
	  'font_variant' => 'normal',
      'font_color' => '#4e4e4e',
      'css_selectors' => 'body,#search-image.sbutton, #searchsubmit, .popular-posts a, .category-posts a, .advanced-recent-posts a, .related-posts-widget a ,.author-posts-widget li a,.widget_recent_entries a,.tagcloud a,.mts-subscribe input[type="submit"],.sidebar .menu li a,.ajax-search-results li  a,.wp_review_tab_widget_content .entry-title a,.wpt_widget_content .entry-title a'
    ),
    'slider_title_font' => array(
      'preview_text' => 'Slider title',
      'preview_color' => 'dark',
      'font_family' => 'Roboto',
      'font_size' => '68px',
	  'font_variant' => '700',
      'font_color' => '#FFFFFF',
      'css_selectors' => '#homepage_slider .flex-caption h2'
    ),
    'homepage_primary_font' => array(
      'preview_text' => 'Homepage Titles',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '38px',
	  'font_variant' => '700',
      'font_color' => '#282828',
      'css_selectors' => '.page-title, .post-title, .counter-item .count,#pricing_tables ul li .price, #pricing_tables ul li .table_title'
    ),
    'single_post_title_font' => array(
      'preview_text' => 'Single Post Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '28px',
	  'font_variant' => '700',
      'font_color' => '#282828',
      'css_selectors' => '.single-title'
    ),
    'h1_headline' => array(
      'preview_text' => 'H1 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '28px',
      'font_color' => '#282828',
      'css_selectors' => 'h1'
    ),
	'h2_headline' => array(
      'preview_text' => 'H2 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '24px',
      'font_color' => '#282828',
      'css_selectors' => 'h2'
    ),
	'h3_headline' => array(
      'preview_text' => 'H3 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '22px',
      'font_color' => '#282828',
      'css_selectors' => 'h3'
    ),
	'h4_headline' => array(
      'preview_text' => 'H4 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '20px',
      'font_color' => '#222222',
      'css_selectors' => 'h4'
    ),
	'h5_headline' => array(
      'preview_text' => 'H5 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '18px',
      'font_color' => '#222222',
      'css_selectors' => 'h5'
    ),
	'h6_headline' => array(
      'preview_text' => 'H6 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '700',
      'font_size' => '16px',
      'font_color' => '#222222',
      'css_selectors' => 'h6'
    )
  ));
}

?>