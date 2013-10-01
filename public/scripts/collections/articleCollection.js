
define(["backbone", "models/article"], function(Bacbone, Article){
	var ArticleCollection = Backbone.Collection.extend({
		
		model: Article,
		
		initialize: function(models, options) {
			this.feedId = options.feedId;
		},
		
		url: function(){
			return "/feed/" + this.feedId + "/article";
		},
		
		toArrayOfAttributes: function(){
			return this.map(function(model) { return model.getAttributes(); });
		}
	});
	
	return ArticleCollection;
});