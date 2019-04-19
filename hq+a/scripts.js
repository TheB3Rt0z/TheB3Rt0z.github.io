if (typeof jQuery == 'undefined') {

    var jquery_script = document.createElement('script'),
        head_tag = document.head;
                
    jquery_script.type = 'text/javascript';
    jquery_script.src = 'jquery.min.js';
            
    head_tag.appendChild(jquery_script);
    
    jquery_script.onload = jquery_script.onreadystatechange = function ()
    {
        $ = jQuery.noConflict();
        
        init();
    }
} else {
    
    init();
}

function init ()
{
	/*var html = document.documentElement;
	if (html.hasOwnProperty('requestFullscreen')) {
		html.requestFullscreen();
	} else if (html.hasOwnProperty('mozRequestFullScreen')) { // Firefox
		html.mozRequestFullScreen();
	} else if (html.hasOwnProperty('webkitRequestFullscreen')) { // Chrome, Safari and Opera
		html.webkitRequestFullscreen();
	} else if (html.hasOwnProperty('msRequestFullscreen')) { // IE/Edge
		html.msRequestFullscreen();
	}*/
	
    $(function ()
    {
    	
    });
}
