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
    $(function ()
    {
    	var html = document.documentElement;

    	if (html.requestFullscreen) {
    		html.requestFullscreen();
    	} else if (html.mozRequestFullScreen) { /* Firefox */
    		html.mozRequestFullScreen();
    	} else if (html.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    		html.webkitRequestFullscreen();
    	} else if (html.msRequestFullscreen) { /* IE/Edge */
    		html.msRequestFullscreen();
    	}
    });
}
