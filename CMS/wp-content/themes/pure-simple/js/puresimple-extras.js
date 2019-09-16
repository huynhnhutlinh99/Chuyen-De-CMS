jQuery(document).ready(function($) {	
	//for navmenu screen resolution 
	$('.menu-toggle').click(function(e){
		e.preventDefault()      
		var window_height = $(window).height();
		var navmenu_height = $('.navigation').height();
		//check whether the menu is larger than the screen or not
		if (navmenu_height > window_height){
			$('.nav-menu').css({'height': (window_height - 50), 'overflow-y': 'scroll'});
		}

	});
	
});

// jQuery script for toggle menu
jQuery(function($) {
    
	 var window_width = $(window).width();
	 // console.log(window_width);
	if (window_width < 768) {
		$('ul.nav-menu').addClass('navmenu');
		var children_link = $('ul.navmenu').find('li.menu-item-has-children > a');
		var children_link_main = $('ul.navmenu').find('li.menu-item-has-children');
		$(children_link).prepend('<i class="fa fa-plus"></i> &nbsp');

		$(children_link_main).find('a').toggle(function(){
				$(this).find('i').removeClass('fa-plus');
				$(this).find('i').addClass('fa-minus');
				$("ul.sub-menu li").show();
		},
		function() {
				$(this).find('i').removeClass('fa-minus');
				$(this).find('i').addClass('fa-plus');
				$("ul.sub-menu li").hide();
		});

		$('ul.sub-menu > li a').click(function(){
			var href = $(this).attr('href'); 
			window.location.replace(href);

		});
		$('.menu-toggle').click(function(){
		 	$('.nav-menu').css({"overflow":"scroll"});
	 	});
	}
});


//adding move to top featured
jQuery(document).ready(function($) {	
    //Scroll To Top
    var window_height = $(window).height();
    var window_height = (window_height) + (50); 
    $(window).scroll(function() {
        var scroll_top = $(window).scrollTop();
        if (scroll_top > window_height) {
            $('.puresimple_move_to_top').show();
        }
        else {
            $('.puresimple_move_to_top').hide();   
        }
    });
    $('.puresimple_move_to_top').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
        
    });
});    
