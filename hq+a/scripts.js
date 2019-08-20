function save_data (application_title)
{	
	localStorage.setItem('hqa_data', JSON.stringify(window.hqa_data));//console.log(window.hqa_data); // just for debug
	
	var data_save = setInterval(function ()
	{
		application_title.removeClass('saving-data');
		clearInterval(data_save);
	}, DEFAULT_DELAY);
}

function init ()
{
	var default_data = {
	    status: 'preparation',
	    players: [
	        {
	        	key: 1
	        }, {
	        	key: 2
		    }, {
	        	key: 3
		    }, {
	        	key: 4
		    }, {
	        	key: 5
		    }
	    ]
	};
	
	window.hqa_data = localStorage.getItem('hqa_data')
	                ? JSON.parse(localStorage.getItem('hqa_data'))
	                : default_data;
	
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
    	var application_title = $('table th.title'),
    	    status_controller = $('#status-controller'),
    	    status_controller_import = status_controller.find('#status-import'),
    	    status_controller_export = status_controller.find('#status-export'),
    	    move_amount = $('#dice-move-amount'),
    	    move_button = $('#dice-move'),
    	    attack_amount = $('#dice-attack-amount'),
    	    attack_button = $('#dice-attack'),
    	    dice_result = $('#dice-result'),
    	    reset_button = $('#reset-data'),
    	    utility_textarea = $('#footer ~ textarea');
    	
    	if (window.hqa_data.status == 'in-game') {
    		status_controller.addClass('active');
    		$('#content').addClass('in-game');
    	}
    	
    	status_controller.on('click', function (e)
		{
    		if ($(this).hasClass('active')) {
    			clearInterval(auto_save);
    			if (confirm('Are you SURE?')) {
    				window.hqa_data.status = 'preparation';
    				dice_result.html('');
    			} else {
    				start_autosave();
    				return;
    			}
    			start_autosave();
    		} else {
    			window.hqa_data.status = 'in-game';
    		}
    		
    		$(this).toggleClass('active');
    		$('#content').toggleClass('in-game');
		});

    	status_controller_import.on('click', function (e)
		{
    		e.stopPropagation();
    		utility_textarea.val(null).show(DEFAULT_DELAY).focus();
		});
    	
    	status_controller_export.on('click', function (e)
		{
    		e.stopPropagation();
    		utility_textarea.val(JSON.stringify(window.hqa_data)).show(DEFAULT_DELAY).select();
		});
    	
    	move_button.on('click', function (e)
    	{
    		var dices = [];
    		
    		dice_result.html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
    		
    		for (i = 0; i < move_amount.val(); i++) {
    			dices.push(Math.floor((Math.random() * 6) + 1));
    		}
    		
    		setTimeout(function () {
    			dice_result.html(dices.join(" + ") + ' = <font color="white">' + dices.reduce((pv, cv) => pv + cv, 0)) + '</font>';
    		}, DEFAULT_DELAY * 3);
    	});
    	
    	attack_button.on('click', function (e)
    	{
    		var faces = [
    		        'skull',
    		        'skull',
    		        'skull',
    		        'white',
    		        'white',
    		        'black'
    		    ],
    		    output = '';
    		
    		dice_result.html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
    		
    		
    		for (i = 0; i < attack_amount.val(); i++) {
    			output += '&nbsp;<img src="img/dice_' + faces[Math.floor(Math.random() * 6)] + '.png" />';
    		}
    		
    		setTimeout(function () {
    			dice_result.html(output);
    		}, DEFAULT_DELAY * 3);
    	});
    	
    	reset_button.on('click', function () // only as debug
		{
    		if (confirm('Are you SURE?!')) {
    			clearInterval(auto_save);
    			localStorage.removeItem('hqa_data');
    			location.reload();
    		}
		});
    	
    	utility_textarea.on('dblclick submit', function (e)
		{
    		$(this).hide(DEFAULT_DELAY);
		});
    	
    	/* audio */
    	
    	var audio_player = document.getElementById('audio-player'),
    	    audio_tracks = $('#playlist a'),
    	    audio_loop = true,
    	    audio_loop_control = $('#playlist #player-loop'),
    	    audio_stop_control = $('#playlist #player-stop'),
    	    play_all_control = $('#playlist .play-all'),
    	    shuffle_control = $('#playlist .shuffle'),
		    tracker = null;
    	
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
    		play_all_control.removeClass('active');
    		clearInterval(tracker);
		});
    	
    	play_all_control.on('click', function ()
    	{
    		if ($(this).hasClass('active')) {
    			return audio_stop_control.trigger('click');
    		}
    		
    		var playlist = $(this).addClass('active').attr('rel'),
    		    tracks = $('tr[rel="' + playlist + '"]').find('a'),
    		    tracks_number = tracks.length,
    		    shuffle = $(this).hasClass('shuffle')
    		    current_track = shuffle ? Math.floor(Math.random() * tracks_number) : 0,
    		    audio_loop = false;
    		
    		audio_loop_control.removeClass('active');

    		audio_tracks.removeClass('active');
    		
    		function set_track (track)
    		{
    			var track = tracks.eq(track),
    			    slug = track.prop('rel');
    			audio_player.src = 'ost/' + slug + '.mp3';
        		audio_player.play();
        		track.addClass('active');
    		}
    		
    		set_track(current_track);
    		
    		tracker = setInterval(function ()
    		{
    			if (audio_player.paused) {
    				if (shuffle) {
    					current_track = Math.floor(Math.random() * tracks_number);
    				}
    				current_track++;
    				if (current_track == tracks_number) {
    					current_track = 0;
    				}
    				set_track(current_track);
    			}
    		}, DEFAULT_DELAY * 4);
    	});
    	
    	shuffle_control.on('click', function ()
    	{
    		
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
    
    var auto_save = null;
    
    function start_autosave ()
    {
    	auto_save = setInterval(function ()
	    {
	    	var application_title = $('table th.title');
	    	application_title.addClass('saving-data');
	        save_data(application_title);
	    }, DEFAULT_DELAY * 8); // milliseconds, each 2 seconds circa..
    }
    
    start_autosave();
}
