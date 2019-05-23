function init ()
{
	$(function ()
    {
    	var tables_theads = $('table thead');
    	
    	tables_theads.on('click', function (e)
    	{
    		var sibling_tbody = $(this).siblings('tbody');
    		
    		$(this).toggleClass('active');
    		sibling_tbody.toggle(DEFAULT_DELAY);
    	});
    });
}
