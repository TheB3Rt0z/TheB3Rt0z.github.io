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
    	var audio_player = document.getElementById('audio-player'),
    	    audio_tracks = $('#playlist a'),
    	    audio_loop = true,
    	    audio_loop_control = $('#playlist #player-loop'),
    	    audio_stop_control = $('#playlist #player-stop');
    	
    	/*audio_player.load()
    	audio_player.play();*/ // not working because of policies..
    	
    	audio_loop_control.on('click', function ()
		{
    		audio_loop = !audio_loop;
    		$(this).toggleClass('active');
		});
    	
    	audio_stop_control.on('click', function ()
		{
    		audio_player.pause();
    		audio_player.currentTime = 0;
    		audio_tracks.removeClass('active');
		});
    	
    	audio_tracks.on('click', function (e)
        {
    		audio_tracks.removeClass('active');
    		e.preventDefault();
    		audio_player.src = 'ost/' + $(this).prop('rel') + '.mp3';
    		audio_player.play();
    		$(this).addClass('active');
    	});
    	
    	audio_player.onended = function ()
    	{
    		if (audio_loop) {
    			audio_player.currentTime = 0;
    			audio_player.play();
    		} else {
    			audio_tracks.removeClass('active');
    		}
    	};
    });
}
