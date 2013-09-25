
define(["backbone", "models/feed"], function(Bacbone, Feed){
	var FeedCollection = Backbone.Collection.extend({
		
		model: Feed,
		
		url: "/feed",
		
		toArrayOfAttributes: function(){
			return this.map(function(model) { return model.attributes });
		}
	});
	
	return FeedCollection;
});