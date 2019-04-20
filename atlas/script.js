var session = {
        countries: []
	},
    macro_countries = {
        eur: [/*'gbr', */'ita']
    },
    small_countries_threshold = 244444, // in Km²
    relations_colors = {
		market: 'red'
	};

function canvasDrawLine(data)
{
    var canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');

    canvas.width = $(window).outerWidth();
    canvas.height = $(window).outerHeight();
    
    var start_x = Math.round(canvas.width / 100 * data.start_x),
        start_y = Math.round(canvas.height / 100 * data.start_y),
        to_x = Math.round(canvas.width / 100 * data.to_x),
        to_y = Math.round(canvas.height / 100 * data.to_y);
    
    context.beginPath();

    context.moveTo(start_x, start_y);
    context.lineTo(to_x, to_y);
    context.lineWidth = 1;
    context.lineCap = 'round';
    
    if (typeof data.color != undefined) {
    	context.strokeStyle = data.color;
    }
    
    context.stroke();
}

function drawCountryRelations (data) {

	if (typeof data.relations != 'undefined') {
		for (key in data.relations) {
			for (subkey in data.relations[key]) {
			    var country = data.relations[key][subkey];
				canvasDrawLine({
		            start_x: data.style.abs_x,
		            start_y: data.style.abs_y,
		            to_x: session.countries[country].abs_x,
		            to_y: session.countries[country].abs_y,
		            color: relations_colors[key]
		        });
			}
		}
	}
}

function getCountryInformation (data)
{
    var flag_style = 'background-position: -' + (data.style.background_x * 1.5) + 'px -' + (data.style.background_y * 1.5) + 'px;',
        output = '<table>'
               + '    <tr>'
               + '        <td class="flag" title="ISO code: ' + data.iso + '" style="' + flag_style + '" rowspan="4"></td>'
               + '        <td><strong>' + data.label + '</strong></td>'
               + '    </tr>'
               + '    <tr>'
               + '        <td>Area: <strong>' + getFormattedThousands(data.area) + ' Km²</strong></td>'
               + '    </tr>'
               + '    <tr>'
               + '        <td>Population: <strong>' + getFormattedThousands(data.population) + '</strong></td>'
               + '    </tr>'
               + '    <tr>'
               + '        <td>GDP: <strong>' + getFormattedThousands(data.population) + ' $</strong></td>'
               + '    </tr>'
               + '</table>';
    
    return output;
}

function getFooterHtml(data)
{
    var macro_countries_count = 0;
    
    for (var key in macro_countries) {
        if (macro_countries.hasOwnProperty(key)) {
           ++macro_countries_count;
        }
    }
    
    var total_countries = data.countries.length - macro_countries_count,
        output = '<p>Showing a total of ' + total_countries + ' countries and ' + macro_countries_count + ' macro</p>';

    return '<span id="todos">'
         + '    <ul>'
         + '        <li>Marker\'s background size(s) should be recalculated on pixels (not %) basis</li>'
         + '    </ul>'
         + '</span>'
         + output;
}

function getFormattedThousands (data)
{
    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

function getMarkerHtml (data)
{
    var additional_classes = (data.area < small_countries_threshold
                             ? ' small'
                             : ''),
        marker_width = 3 + (data.area / 2025000), // to be standardized
        marker_height = marker_width * 1.0625,
        width_correction = marker_width / 2.125,
        height_correction = marker_height / 1.875,
        
        background_width = Math.ceil(18 * marker_width * (15 + 1)),
        background_height = Math.ceil(7.8 * marker_height * (13 + 3.5)),
        
        background_pos_x = (background_width / 1800) * data.style.background_x,
        background_pos_y = (background_height / 780) * data.style.background_y,
        marker_left = data.style.abs_x - width_correction,
        marker_top = data.style.abs_y - height_correction,
        marker_style = 'background-position: -' + background_pos_x  + 'px -' + background_pos_y + 'px;'
                     + 'background-size: ' + background_width + 'px ' + background_height + 'px;'
                     + 'height:' + marker_height + '%;'
                     + 'left:' + marker_left + '%;'
                     + 'top:' + marker_top + '%;'
                     + 'width:' + marker_width + '%;';
    
    var output = '<span id="' + data.iso.toLowerCase() + '" class="marker' + additional_classes
               + '" title="' + data.label + '" style="' + marker_style + '">'
               + '</span>';
    
    return output
}

function initApplication()
{
    var macro_countries_toggler = toggleMacroCountries(),
        small_countries_toggler = toggleSmallCountries();
     
    macro_countries_toggler.on('click', function (e)
    {
        toggleMacroCountries();
    });
    
    small_countries_toggler.on('click', function (e)
    {
        toggleSmallCountries();
    });
}

function toggleMacroCountries()
{
    var toggler = $('#header #navigation input#show-macro-countries'),
        macro_countries_ids = Object.keys(macro_countries),
        target = $('#content #section .marker#' + macro_countries_ids.join(', #content #section .marker#')),
        subtargets = [];
    
    for (var key in macro_countries_ids) {
        var macro_country_id = macro_countries_ids[key],
            sub_countries = macro_countries[macro_country_id];
    
        subtargets = subtargets.concat(sub_countries);
    }

    var subtarget = $('#content #section .marker#' + subtargets.join(', #content #section .marker#'));
    
    if (toggler.is(':checked')) {
        target.removeClass('hidden');
        subtarget.addClass('hidden');
    } else {
        target.addClass('hidden');
        subtarget.removeClass('hidden');
    }
    
    return toggler;
}

function toggleSmallCountries()
{
    var toggler = $('#header #navigation input#hide-small-countries'),
        target = $('#content #section .marker.small');
    
    if (toggler.is(':checked')) {
        target.addClass('hidden');
    } else {
        target.removeClass('hidden');
    }
    
    return toggler;
}

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
        var wrapper = $('body #content #section'),
            sidebar_monitor = $('body #content #sidebar > nav#monitor'),
            footer = $('body #footer #toolbar');
        
        $.ajax('data.json', {
            type: 'GET',
            dataType: 'json',
            success: function (data, textStatus, jqXHR)
            {
                $(data.countries).each(function (index)
                {
                    var country = data.countries[index],
                        obj = $(getMarkerHtml(country)).appendTo(wrapper);
                    
                    obj.on('click', function ()
                    {
                        sidebar_monitor.children().animate({opacity: 0}, 125, function ()
                        {
                            sidebar_monitor.html(getCountryInformation(country)).children().animate({opacity: 1}, 125);
                        });
                        
                        drawCountryRelations(country);
                    });
                    
                    session.countries[country.iso] = {
                    	abs_x: country.style.abs_x,
                        abs_y: country.style.abs_y
                    };
                });
                
                initApplication();
    
                footer.html(getFooterHtml(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {}
        });
    });
}
