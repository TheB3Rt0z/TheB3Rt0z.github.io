var dictionary = {
	"Date of birth": {
		DE: "Geburtsdatum",
		IT: "Data di nascita"
	},
	"Personal data": {
		DE: "Persönliche Daten",
		IT: "Dati personali"
	}
};

$(function ()
{
	var translations = $('translation');

	translations.each(function (e)
	{
		var text_string = $(this).text();
	
		if (dictionary.hasOwnProperty(text_string)) {
			if (dictionary[text_string].hasOwnProperty(DEFAULT_LANGUAGE)) {
				$(this).text(dictionary[text_string][DEFAULT_LANGUAGE]);
			}
		}
	});
});
