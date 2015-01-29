/*----------------------------------------------------
/* Stiky Nav
/*---------------------------------------------------*/
jQuery(document).ready(function() {
	jQuery('#sticky').exists(function() {
		function isScrolledTo(elem) {
			var docViewTop = jQuery(window).scrollTop(); //num of pixels hidden above current screen
			var docViewBottom = docViewTop + jQuery(window).height();

			var elemTop = jQuery(elem).offset().top; //num of pixels above the elem
			var elemBottom = elemTop + jQuery(elem).height();

			return ((elemTop <= docViewTop));
		}

		var sticky = jQuery('#sticky');
		
		jQuery(window).scroll(function(e) {
			if(isScrolledTo(sticky)) {
				sticky.css({'position': 'fixed', 'top': '0'});
				jQuery('body').css({'padding-top': '82px'});
			}
			if ($(window).scrollTop() == 0) {
				sticky.css({'position': 'relative', 'top': 'auto'});
				jQuery('body').css({'padding-top': '0'});
			}
		});
	});
});
