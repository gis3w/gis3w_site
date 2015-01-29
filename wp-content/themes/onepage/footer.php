<?php 
	$mts_options = get_option(MTS_THEME_NAME); 
	if(is_array($mts_options['mts_homepage_layout'])){
		$homepage_layout = $mts_options['mts_homepage_layout']['enabled'];
	}else if(empty($homepage_layout)) {
		$homepage_layout = array();
	}
?>
<?php 
      $top_footer_num = (!empty($mts_options['mts_top_footer_num']) && $mts_options['mts_top_footer_num'] == 4) ? 4 : 3;
      $bottom_footer_num = (!empty($mts_options['mts_bottom_footer_num']) && $mts_options['mts_bottom_footer_num'] == 4) ? 4 : 3;
?>
	</div><!--#page-->

</div><!--.main-container-->

<?php if(!is_front_page() && is_singular() && !empty($mts_options['mts_twitter_single'])): ?>
<section id="homepage-twitter" class="homepage-section homepage-twitter" style="background-image:url(<?php echo $mts_options['homepage_twitter_background_image']; ?>); background-color: <?php echo $mts_options['homepage_twitter_background_color']; ?>">
    <div class="inside">
        <?php
            if(empty($mts_options['homepage_twitter_api_key']) || empty($mts_options['homepage_twitter_api_secret']) || empty($mts_options['homepage_twitter_access_token']) || empty($mts_options['homepage_twitter_access_token_secret']) || empty($mts_options['homepage_twitter_username'])){
                echo '<strong>'.__('The section is not configured correctly', 'mythemeshop').'</strong>'; } else {
            //check if cache needs update
            $mts_twitter_plugin_last_cache_time = get_option('mts_twitter_plugin_last_cache_time');
            $diff = time() - $mts_twitter_plugin_last_cache_time;
            $crt =0* 3600;						
            //	yes, it needs update			
            //require_once('functions/twitteroauth.php');
            if($diff >= $crt || empty($mts_twitter_plugin_last_cache_time)){							
            if(!require_once('functions/twitteroauth.php')){ echo '<strong>Couldn\'t find twitteroauth.php!</strong>'; }														
            
            $connection = mts_getConnectionWithhomepage_twitter_access_token($mts_options['homepage_twitter_api_key'], $mts_options['homepage_twitter_api_secret'], $mts_options['homepage_twitter_access_token'], $mts_options['homepage_twitter_access_token_secret']);
            $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$mts_options['homepage_twitter_username']."&count=".$mts_options['homepage_twitter_tweet_count']) or die('Couldn\'t retrieve tweets! Wrong username?');
            if(!empty($tweets->errors)){
                if($tweets->errors[0]->message == 'Invalid or expired token'){
                    echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!';
                }else{ echo '<strong>'.$tweets->errors[0]->message.'</strong>'; }
                return;
            }
            for($i = 0;$i <= count($tweets); $i++){
                if(!empty($tweets[$i])){
                    $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
                    $tweets_array[$i]['text'] = $tweets[$i]->text;			
                    $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;			
                }
            }			
            //save tweets to wp option 		
            update_option('mts_twitter_plugin_tweets',serialize($tweets_array));							
            update_option('mts_twitter_plugin_last_cache_time',time());		
            echo '<!-- twitter cache has been updated! -->';
            }

            $mts_twitter_plugin_tweets = maybe_unserialize(get_option('mts_twitter_plugin_tweets'));
            if(!empty($mts_twitter_plugin_tweets)){
                print '<ul class="mts_recent_tweets tweets">';
                    $fctr = '1';
                    foreach($mts_twitter_plugin_tweets as $tweet){	
                        if ($mts_options['homepage_twitter_slider'] == '0' && $fctr > 1) continue;
                        print '<li><span>'.mts_convert_links($tweet['text']).'</span></li>';
                        $fctr++;
                    }
                print '</ul>
                
                <a class="twitter_username" href="http://twitter.com/'.$mts_options['homepage_twitter_username'].'"><span class="fa fa-twitter"></span>'.__('Follow us on Twitter', 'mythemeshop').'</a>';
            }
        }
        ?>

    </div>
</section>

<?php endif; ?>

<footer id="footer">
    <div class="container">

        <div id="footer-nav">
            <?php if ( has_nav_menu( 'footer-menu' ) ) {  ?>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu','menu_class' => 'footer-menu') ); ?>
            <?php } ?>
        </div>

        <div class="copyrights">
            <span>&copy; <?php _e("Copyright","mythemeshop"); ?> <?php echo date("Y") ?>, <?php echo $mts_options['mts_copyrights']; ?></span>
			<div class="top">&nbsp;<a href="#top" class="toplink" rel="nofollow"><i class="fa fa-angle-up"></i></a></div>
        </div> 
    </div><!--.container-->
</footer><!--footer-->

<?php mts_footer(); ?>
<?php wp_footer(); ?>

<?php if(array_key_exists('counter',$homepage_layout) || array_key_exists('slider',$homepage_layout) || array_key_exists('service',$homepage_layout) || array_key_exists('team',$homepage_layout) || array_key_exists('pricing',$homepage_layout) || array_key_exists('testimonial',$homepage_layout) || array_key_exists('clients',$homepage_layout) || array_key_exists('contact',$homepage_layout) || array_key_exists('twitter',$homepage_layout) || array_key_exists('feature',$homepage_layout) ): ?>
<script type="text/javascript">
	
	// Enable parralax images for different sections on homepage
	if(jQuery().parallax){
		<?php if($mts_options['mts_homepage_counter_parallax'] && $mts_options['mts_homepage_counter_background_image'] != '' && array_key_exists('counter',$homepage_layout)): ?>
		jQuery('#homepage-counter').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>

		<?php if($mts_options['mts_homepage_background_parallax'] && $mts_options['mts_homepage_background_image'] != '' && array_key_exists('slider',$homepage_layout)): ?>
		jQuery('#homepage-title-slider').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>

		<?php if($mts_options['mts_homepage_service_parallax'] && $mts_options['mts_homepage_service_background_image'] != '' && array_key_exists('service',$homepage_layout)): ?>
		jQuery('#homepage-service').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>

		<?php if($mts_options['mts_homepage_team_parallax'] && $mts_options['mts_homepage_team_background_image'] != '' && array_key_exists('team',$homepage_layout)): ?>
		jQuery('#homepage-team').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_pricing_parallax'] && $mts_options['mts_homepage_pricing_background_image'] != '' && array_key_exists('pricing',$homepage_layout)): ?>
		jQuery('#homepage-pricing').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_testimonials_parallax'] && $mts_options['mts_homepage_testimonials_background_image'] != '' && array_key_exists('testimonial',$homepage_layout)): ?>
		jQuery('#homepage-testimonials').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_client_parallax'] && $mts_options['mts_homepage_client_background_image'] != '' && array_key_exists('clients',$homepage_layout)): ?>
		jQuery('#homepage-clients').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_contact_parallax'] && $mts_options['mts_homepage_contact_background_image'] != '' && array_key_exists('contact',$homepage_layout)): ?>
		jQuery('#homepage-contact').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
	
		<?php if($mts_options['homepage_twitter_parallax'] && $mts_options['homepage_twitter_background_image'] != '' && array_key_exists('twitter',$homepage_layout)): ?>
		jQuery('#homepage-twitter').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_features_parallax'] && $mts_options['mts_homepage_features_background_image'] != '' && array_key_exists('feature',$homepage_layout)): ?>
		jQuery('#homepage-features').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
		
		<?php if($mts_options['mts_homepage_portfolio_parallax'] && $mts_options['mts_homepage_portfolio_background_image'] != '' && array_key_exists('portfolio',$homepage_layout)): ?>
		jQuery('#homepage-portfolio').parallax("5%", 2750, -0.7, true);
		<?php endif; ?>
	}
</script>
<?php endif; ?>


<?php if($mts_options['mts_map_coordinates'] != '' && array_key_exists('contact',$homepage_layout) && is_front_page()): ?>
<script type="text/javascript">
      var mapLoaded = false;
      function initialize() {
        mapLoaded = true;
        
		var geocoder = new google.maps.Geocoder();
		var lat='';
		var lng=''
		geocoder.geocode( { 'address': '<?php echo addslashes($mts_options['mts_map_coordinates']); ?>'}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		   lat = results[0].geometry.location.lat(); //getting the lat
		   lng = results[0].geometry.location.lng(); //getting the lng
		   map.setCenter(results[0].geometry.location);
		   var marker = new google.maps.Marker({
			   map: map,
			   position: results[0].geometry.location
		   });
		 }
		 });
		 var latlng = new google.maps.LatLng(lat, lng);
		
		var mapOptions = {
			zoom: 18,
			center: latlng,
			scrollwheel: false,
			navigationControl: false,
			scaleControl: false,
			streetViewControl: false,
			draggable: true,
			panControl: false,
			mapTypeControl: false,
			zoomControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			// How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
                    styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]}]
        };

        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
      }
      //google.maps.event.addDomListener(window, 'load', initialize);
      jQuery(window).load(function() {
        jQuery(window).scroll(function() {
          if (jQuery('.contact_map').isOnScreen() && !mapLoaded) {
            mapLoaded = true;
            jQuery('body').append('<script src="https://maps.googleapis.com/maps/api/js?sensor=false&v=3&callback=initialize"></'+'script>');
          }
        });
      });
</script>

<?php endif ?>

</div><!--.main-container-wrap-->
</body>
</html>