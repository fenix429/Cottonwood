
define(["jquery", "handlebars"], function($, Handlebars){
	
    Handlebars.registerHelper('unless_blank', function(item, block) {
        return (item && item.replace(/\s/g,"").length) ? block.fn(this) : block.inverse(this);
    });
	
	// adjust oversized images in feeds
	// TODO: rework for responsive layout - enquire.js?
    Handlebars.registerHelper('prepImages', function(html) {
        // wrap in div because .html() returns the innerHTML value
        var $html = $('<div>' + html + '</div>');
        
        $html.find('img').each(function(idx, img){
            var $img = $(img);
            var width = $img.attr('width');
            
            if(width > 780) {
                $img.removeAttr('width').removeAttr('height');
                $img.css({'width' : '100%'});
            }
        });
        
        // this *should* be sanitized on the server already
        // need to run tests for XSS
        return new Handlebars.SafeString($html.html());
    });
	
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
	
	rawTemplates.each(function(){
		var name = $(this).attr('id'),
			content = $(this).html();
		
		if(!compiledTemplates.hasOwnProperty(name)) {
			compiledTemplates[name] = Handlebars.compile(content);
		}
	});

	return compiledTemplates;
});