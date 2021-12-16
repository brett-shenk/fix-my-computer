/**
 * @author		Brett Shenk (https://www.linkedin.com/in/brett-shenk-59480794/)
 * @copyright	Fix My Computer  2021
 * 
 * @package  	Alert Bar Functions
 * @version		1.0
 * 
 * @property {string}    global_cookie_status
 * @property {number}    global_cookie_time
**/
if(typeof($) === 'undefined') {
    var $ = jQuery;
}

document.addEventListener("DOMContentLoaded", function(event){
    var placeholder_height = document.querySelector('.site-header').offsetHeight+"px";

    // If the alert bar is enabled along with cookies
    if(global_cookie_status == 'enabled'){
        var alert_bar_cookie = getCookie('alert-bar');

        if(alert_bar_cookie != 'closed'){
            setTimeout( () => {
                
                document.querySelector('.site-header').classList.add('enabled');
                document.querySelector('#nav-placeholder').style.height = placeholder_height;
            }, 500 );
        }
        document.querySelector('.alert-bar-container button[type="button"]').addEventListener('click', function() {
            setCookie('alert-bar', 'closed', global_cookie_time);
            
            document.querySelector('.site-header').classList.remove('enabled');
            document.querySelector('#nav-placeholder').style.height = '129px';

            var alert_bar_height = document.querySelector('.alert-bar-container').offsetHeight+"px";
            document.querySelector('.site-header').style.transform = 'translateY(-'+ alert_bar_height +')';
        });
        
    // The alert bar is enabled but cookies are not
    } else {
        setTimeout( () => {
            
            document.querySelector('.site-header').classList.add('enabled');
            document.querySelector('#nav-placeholder').style.height = placeholder_height;
        }, 500 );
        document.querySelector('.alert-bar-container button[type="button"]').addEventListener('click', function() {
            document.querySelector('.site-header').classList.remove('enabled');
            document.querySelector('#nav-placeholder').style.height = '129px';
            
            var alert_bar_height = document.querySelector('.alert-bar-container').offsetHeight+"px";
            document.querySelector('.site-header').style.transform = 'translateY(-'+ alert_bar_height +')';
        });
    }

});


/**
 * Cookie functions
 * 
 * setCookie - To create a cookie through javascript.
 * getCookie - Get the cookie you just made.
 * 
 * @param {string} 	name 
 * @param {*} 		value 
 * @param {number} 	days 
**/
function setCookie(name, value, days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/; Secure";
}
/**
 * @param {string} 	name 
 * @returns The value of the cookie
**/
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
