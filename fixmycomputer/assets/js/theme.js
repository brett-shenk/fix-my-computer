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
 * Wait for final event
 * 
 * $(document.body).on('updated_cart_totals', function(){
 * 		waitForFinalEvent(function(){
 * 			console.log('do stuff');
 * 		}, 500);
 * });
**/
var waitForFinalEvent = (function(){
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) {
		uniqueId = "Don't call this twice without a uniqueId";
	}
	if (timers[uniqueId]) {
		clearTimeout (timers[uniqueId]);
	}
	timers[uniqueId] = setTimeout(callback, ms);
	};
})();


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
		the_header.classList.add('hide');
		prevDirection = direction;
	} else if (direction === 1) {
		the_header.classList.remove('hide');
		prevDirection = direction;
	}
};
window.addEventListener('scroll', checkScroll);


/**
 * Functions on Doc Ready
**/
document.addEventListener('DOMContentLoaded', function(event){ 

	// Remove the default class if JS is enabled
	document.querySelector('html').classList.remove('no-js');

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
		document.querySelector( 'nav.main-nav' ),
		'(max-width: 1300px)'
	);
	const navigator = menu.navigation({
		title: 'Fix My Computer',
	});

	const drawer = menu.offcanvas({
		position: 'right',
	});

	document.querySelector( '.hamburger' ).addEventListener( 'click', function( event ){
		event.preventDefault();
        drawer.open();

		if(global_phone && global_email) {
			$( '.mm-ocd__content' ).append( '\
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
			$( '.mm-ocd__content' ).append( '\
			<div class="mm-ocd-bottom-nav">\
				<a href="tel:+1'+ global_phone +'">\
					<i class="icon-phone"></i>\
				</a>\
			</div>\
			' );
		} else if(global_email) {
			$( '.mm-ocd__content' ).append( '\
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
window.addEventListener('load', function(){

	hidePreloader();

	if( $('.site-main .wpcf7').length ){
		waitForFinalEvent(function(){
			cf7_form_loaded();
		}, 500);
	}

});


/**
 * The Preloader
 * 
 * Hidden after page is done loading
**/
function hidePreloader() {
	var preloader = $('#preload-container');
	preloader.fadeOut(200);
}


/**
 * Functions on Window Resize
**/
window.addEventListener('resize', function(event){
});



/**
 * Contact Form 7 Functions
**/
// Validation
if( $('.site-main .wpcf7').length ){
	$('.wpcf7-form').on('click', function(){
		var pattern = /[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
		// Demo: https://regex101.com/r/CNcn11/1
		var your_message = document.querySelector('#your-message').value;
	
		if( pattern.test(your_message) == true ){
			document.querySelector('#your-message-error').innerHTML = "Your message contains a URL. It must be removed, sorry.";
			document.querySelector('#your-message-error').style.display = 'block';
			document.querySelector('#your-message').classList.remove('valid');
			document.querySelector('#your-message').classList.add('error');
			return false;
		} else {
			return true;
		}
	});
}


// global form variables
var formExclude = ['wpcf7-file', 'wpcf7-submit', 'wpcf7-reset'];
var animationStop = false;

// Triggers on page load to prevent filled fields being covered
function cf7_form_loaded(){
	var inputs = document.querySelectorAll('.site-main .wpcf7 .wpcf7-form-control');
	inputs.forEach(function(input){
		var input_classes = input.classList;
		var label = input.parentElement.parentElement.querySelector('label');
		if( !input_classes.contains('wpcf7-submit') || !input_classes.contains('wpcf7-file') ){
			if( input.value != '' ){
				label.style.top = '-0.5em';
				label.style.left = '0.4em';
				label.style.fontSize = '0.9em';
			}
		}
	});
}

// Form label animation
if( $('.site-main .wpcf7').length ){
	$( '.wpcf7' ).delegate( 'input, textarea', 'focus', function(element) {
		// setup 
		var input = element.target;
		var label = element.target.parentElement.parentElement.querySelector('label');
		
		var input_search = input.classList.value;
		input_search = input_search.replace('wpcf7-form-control ', '');
		input_search = input_search.replace(' wpcf7-validates-as-required', '');

		// check if we should animate the selected field
		var i = 0;
		while(i < formExclude.length){
			if( input_search.includes( formExclude[i] ) == true ){
				animationStop = true;
				break;
			}
			i++;
		}

		// On focus if it's an element we want to animate
		if( animationStop != true ){
			label.style.top = '-0.5em';
			label.style.left = '0.4em';
			label.style.fontSize = '0.9em';
		}
		animationStop = false;	// reset back to global after being triggered
	});
	$( '.wpcf7' ).delegate( 'input, textarea', 'focusout', function(element) {
		// setup 
		var input = element.target;
		var label = element.target.parentElement.parentElement.querySelector('label');

		var input_search = input.classList.value;
		input_search = input_search.replace('wpcf7-form-control ', '');
		input_search = input_search.replace(' wpcf7-validates-as-required', '');

		// check if we should animate the selected field
		var i = 0;
		while(i < formExclude.length){
			if( input_search.includes( formExclude[i] ) == true ){
				animationStop = true;
				break;
			}
			i++;
		}

		// On focus out if it's an element we want to animate
		if( animationStop != true && input.value == '' ){
			label.style.top = '0.7em';
			label.style.left = '0.6em';
			label.style.fontSize = '1.1em';
		}
		animationStop = false;	// reset back to global after being triggered
	});
}
