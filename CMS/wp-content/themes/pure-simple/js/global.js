( function( $ ) {
	var body    = $( 'body' ),
		_window = $( window );
	
	// Cool header image scroll and thanks to the Hemingway theme for this
	$(window).scroll(function(e){
		if ($(window).width() > 800) {
			$('.header-bg').css({
				'bottom' : -($(this).scrollTop()/3)+"px",
			}); 
			var thisdist = $(this).scrollTop();
			var headerheight = $(".header-bg").outerHeight();
			$('.fade-logo').css({
				'opacity' : (1 - thisdist/headerheight)
			}); 
		} else {
			$('.header-bg').css({'bottom' : 'auto'}); 	
			$('.fade-logo').css({'opacity' : "1" });
		}
	});
	
		
	// resize videos after container
	var vidSelector = ".post iframe, .post object, .post video, .widget-content iframe, .widget-content object, .widget-content iframe";	
	var resizeVideo = function(sSel) {
		$( sSel ).each(function() {
			var $video = $(this),
				$container = $video.parent(),
				iTargetWidth = $container.width();

			if ( !$video.attr("data-origwidth") ) {
				$video.attr("data-origwidth", $video.attr("width"));
				$video.attr("data-origheight", $video.attr("height"));
			}

			var ratio = iTargetWidth / $video.attr("data-origwidth");

			$video.css("width", iTargetWidth + "px");
			$video.css("height", ( $video.attr("data-origheight") * ratio ) + "px");
		});
	};

	resizeVideo(vidSelector);

	$(window).resize(function() {
		resizeVideo(vidSelector);
	});
	
	// Smooth scroll to header
    $('.tothetop').click(function(){
		$('html,body').animate({scrollTop: 0}, 500);
		$(this).unbind("mouseenter mouseleave");
        return false;
    });

/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */	
	// Enable menu toggle for small screens.
	( function() {
		var nav = $( '#primary-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.puresimple', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();

/*
 * Skiplink Focus Fix - jQuery Plugin
 *
 * Snippet from the _s theme by Automattic
 */
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();




// lets add some bootstrap styling to WordPress elements

jQuery(function($){
	$( '#submit' ).addClass( 'btn' );	
	$( 'input[type=submit]').addClass('btn');
});


} )( jQuery );

