/**
 * @author		Brett Shenk (https://www.linkedin.com/in/brett-shenk-59480794/)
 * @copyright	Fix My Computer  2021
 * 
 * @package  	Primary site functions
 * @version		1.0
**/
if(typeof($) === 'undefined') {
   var $ = jQuery;
}

/**
 * Scroll Position of the header
**/
var prevScroll = window.scrollY || document.documentElement.scrollTop;
var curScroll;
var direction = 0;
var prevDirection = 0;
var the_header = document.querySelector('.site-header');

var checkScroll = function () {
	// Find the direction of scroll
	// 0 - initial,  1 - up,  2 - down

	curScroll = window.scrollY || document.documentElement.scrollTop;
	if (curScroll > prevScroll) {
		direction = 2;
	} else if (curScroll < prevScroll) {
		direction = 1;
	}

	if (direction !== prevDirection) {
		toggleHeader(direction, curScroll);
	}

	prevScroll = curScroll;
};
var toggleHeader = function (direction, curScroll) {
	if (direction === 2 && curScroll > 100) {
		the_header.classList.add("hide");
		prevDirection = direction;
	} else if (direction === 1) {
		the_header.classList.remove("hide");
		prevDirection = direction;
	}
};
window.addEventListener("scroll", checkScroll);


/**
 * Functions on Doc Ready
**/
document.addEventListener("DOMContentLoaded", function(event){ 

	if( $('.home-slider').length ){
		$('.home-slider').slick({
			accessibility: false,
			adaptiveHeight: false,
			lazyLoad: 'ondemand',
			cssEase: 'linear',
			autoplay: true,
			autoplaySpeed: 6000,
		});
	}
	if( $('.content-image-slider').length ){
		$('.content-image-slider').slick({
			accessibility: false,
			adaptiveHeight: true,
			cssEase: 'linear',
			autoplay: true,
			autoplaySpeed: 6000,
		});
	}

	/**
	 * Mobile Menu
	**/
	const menu = new MmenuLight(
		document.querySelector( "nav.main-nav" ),
		"(max-width: 1300px)"
	);
	const navigator = menu.navigation({
		title: 'Fix My Computer',
	});

	const drawer = menu.offcanvas({
		position: 'right',
	});

	document.querySelector( ".hamburger" ).addEventListener( "click", function( event ){
		event.preventDefault();
        drawer.open();

		if(global_phone && global_email) {
			$( ".mm-ocd__content" ).append( '\
			<div class="mm-ocd-bottom-nav">\
				<a href="mailto:'+ global_email +'">\
					<i class="icon-email"></i>\
				</a>\
				<a href="tel:+1'+ global_phone +'">\
					<i class="icon-phone"></i>\
				</a>\
			</div>\
			' );
		} else if(global_phone) {
			$( ".mm-ocd__content" ).append( '\
			<div class="mm-ocd-bottom-nav">\
				<a href="tel:+1'+ global_phone +'">\
					<i class="icon-phone"></i>\
				</a>\
			</div>\
			' );
		} else if(global_email) {
			$( ".mm-ocd__content" ).append( '\
			<div class="mm-ocd-bottom-nav">\
				<a href="mailto:'+ global_email +'">\
					<i class="icon-email"></i>\
				</a>\
			</div>\
			' );
		}
    });

});


/**
 * Functions on Window Loaded
**/
window.addEventListener("load", function(){

	hidePreloader();

});


/**
 * The Preloader
 * 
 * Hidden after page is done loading
**/
function hidePreloader() {
	var preloader = $("#preload-container");
	preloader.fadeOut(200);
}


/**
 * Functions on Window Resize
**/
window.addEventListener('resize', function(event){
});



/**
 * Contact Form 7
**/
// CF7 On Submit
document.addEventListener( "wpcf7mailsent", function( event ) {
	// var siteURL = window.location.protocol + "//" + window.location.hostname;
	
	if ( "817" == event.detail.contactFormId ) {
        // Form redirect for the CF7 form with the 817 ID
		// location = siteURL + "/thank-you-quote/";
	} else {
        // All other forms
	}
}, false );
