
define(["jquery", "handlebars"], function($, Handlebars){
	
	// precompiled templates
	if(Handlebars.templates) {
		return Handlebars.templates
	}
	
	// fetch external templates
	var src = $.ajax({
		type: "GET",
		url: "templates.html",
		async: false
	}).responseText;
	
	var rawTemplates = $(src).find('script[type="text/html"]'),
		compiledTemplates = {};
	
	rawTemplates.each(function(i, t){
		var name = $(this).attr('id'),
			content = $(this).html();
		
		if(!compiledTemplates.hasOwnProperty(name)) {
			compiledTemplates[name] = Handlebars.compile(content);
		}
	});

	return compiledTemplates;
});