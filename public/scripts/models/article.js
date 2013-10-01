
define(["backbone", "moment"], function(Backbone, moment){
	var Article = Backbone.Model.extend({
		defaults: {
			title: "",
			link: "",
			summary: "",
			content: "",
			timestamp: "",
			feed_id: null
		},
		urlRoot: function() {
			return "/feed/" + this.get("feed_id") + "/article"
		},
		getPublishedDate: function() {
    		var pubDate = moment.unix(this.get("timestamp"));
    		
    		if(pubDate.isValid()){
        		return pubDate.format("dddd, MMMM Do YYYY, h:mm:ss a");
    		} else {
        		return "";
    		}
		},
		getAttributes: function() {
		    var m = this.attributes;
		    m["published"] = this.getPublishedDate();
		    return m;
		}
	});
	
	return Article;
});