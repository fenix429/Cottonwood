
define(["backbone"], function(Backbone){
	var Feed = Backbone.Model.extend({
		defaults: {
			title: "",
			url: ""
		},
		urlRoot: "/feed"
	});
	
	return Feed;
});