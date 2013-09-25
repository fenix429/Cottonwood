
define(["backbone"], function(Backbone){
	var Article = Backbone.Model.extend({
		defaults: {
			title: "",
			url: "",
			text: "",
			feed_id: null
		},
		urlRoot: function(){
			return "/feed/" + this.get("feed_id") + "/article"
		}
	});
	
	return Article;
});