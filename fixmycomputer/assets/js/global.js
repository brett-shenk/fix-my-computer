/**
 * @author		Brett Shenk (https://www.linkedin.com/in/brett-shenk-59480794/)
 * @copyright	Fix My Computer  2021
 * 
 * @package  	Generic functions used across the site
 * @version		1.0
 * @see			Included in vendor.js
**/
if(typeof($) === 'undefined') {
   var $ = jQuery;
}


/**
 * Functions on Doc Ready
**/
$(document).ready(function(){

	// Passive jQuery listener
	jQuery.event.special.touchstart = {
		setup: function( _, ns, handle ) {
			this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
		}
	};
	jQuery.event.special.touchmove = {
		setup: function( _, ns, handle ) {
			this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
		}
	};
	jQuery.event.special.wheel = {
		setup: function( _, ns, handle ){
			this.addEventListener("wheel", handle, { passive: true });
		}
	};
	jQuery.event.special.mousewheel = {
		setup: function( _, ns, handle ){
			this.addEventListener("mousewheel", handle, { passive: true });
		}
	};

});


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
