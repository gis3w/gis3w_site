/* ------------------------------------------------------------------------ */
/* one page home														*/
/* ------------------------------------------------------------------------ */

(function($) {
		if( $("body#featured-template").length){
    var e = function() {
	
        var e = 0,
        t = null,
        n = null,
        r = 0,
        i = 0,
        s = 0,
        o = 0,
        u = $(".sub_nav li"),
		l = u.length,
        a = $("html,body"),
        f = $(window);
        f.resize(function(e) {
            s = $(window).height()
        }).resize(),
        f.scroll(function(t) {
            r = $(this).scrollTop(),
            r < .3 * s ? e = 0 : r >= s && r < 1.3 * s ? e = 1 : r >= 2 * s && r < 2.3 * s ? e = 2 : r >= 3 * s && r < 3.3 * s ? e = 3 : r >= 4 * s && r < 4.3 * s ? e = 4 : r >= 5 * s && r < 5.3 * s && (e = 5),
            u.removeClass("cur").eq(e).addClass("cur")
        }),
        a.on("mousewheel",
        function(n) {
            o = window.event.detail ? -(window.event.detail || 0) / 3 : window.event.wheelDelta / 120,
            clearTimeout(t),
            t = setTimeout(function() {
                o > 0 && e > 0 ? e--:o < 0 && e < (l-1) && e++,
                a.animate({
                    scrollTop: s * e
                },
                700, "easeInOutQuart")
            },
            300),
            n.preventDefault()
        }),
        u.on("click",
        function(t) {
            i = $(this).index(),
            a.animate({
                scrollTop: s * i
            },
            700, "easeInOutQuart",
            function() {
                e = i
            });
			
        });
		
		
    },
    t = function() {
        var e = $("nav > ul");
      if( e.length ){
		e.find(" > li.current-menu-item, > li.current-menu-parent").addClass("cur");
        var n = $("nav > ul > li.cur").not(".nav_default");
		if( !n.length){
			var n = $("nav > ul > li.nav_default");
			$("nav > ul > li.nav_focus").hide();
			}
		var t = $("nav > ul > li").not(".nav_focus"),
        r = e.find(".nav_focus"),
        i = n.outerWidth(),
        s = n.position().left + 6,
        o = n.index();
        r.stop(!0, !1).animate({
            left: s,
            width: i
        },
        300),
        t.eq(o).addClass("cur").end().on("mouseenter",
        function(e) {
			jQuery("nav > ul > li.nav_focus").show();
            var t = $(this),
            n = t.position().left + 6,
            i = t.outerWidth();
            t.addClass("cur").siblings().removeClass("cur"),
            r.stop(!0, !1).animate({
                left: n,
                width: i
            },
            300)
        }).siblings().removeClass("cur"),
        e.on("mouseleave",
        function(e) {
			if(i===0){
				$("nav > ul > li.nav_focus").hide();
				}
            r.stop(!0, !1).animate({
                left: s,
                width: i
            },
            300),
            t.eq(o).addClass("cur").siblings().removeClass("cur");
			
        });
		}
    };
    t(),
    e()
	}
})(jQuery)

jQuery(document).ready(function($) {
								
if( $('#wrapper #main').length && $('#wrapper #side').length  ){
	if( $('#wrapper #main').outerHeight() >  $('#wrapper #side').height()  ){
		$('#wrapper #side').height($('#wrapper #main').outerHeight());
	}
	
	}								
/* ------------------------------------------------------------------------ */
/* fixed header															*/
/* ------------------------------------------------------------------------ */
$('header').affix({offset: {top: jQuery('header').height()}}); 
$('.navbar').click(function(){	
								 
	$(".main-menu").toggle();		 
   });
/* ------------------------------------------------------------------------ */
/* Preserving aspect ratio for embedded iframes														*/
/* ------------------------------------------------------------------------ */
$('.entry-content embed,.entry-content iframe').each(function(){
										
		var width  = $(this).attr('width');	
		var height = $(this).attr('height');
		if($.isNumeric(width) && $.isNumeric(height)){
			if(width > $(this).width()){
				var new_height = (height/width)*$(this).width();
				$(this).css({'height':new_height});
				}
			
			}				
    });


 });
