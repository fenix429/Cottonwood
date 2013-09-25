
define([
	"underscore",
	"backbone",
	"templates",
	"collections/articleCollection"
], function(_, Backbone, Templates, ArticleCollection){
	var ArticleCollectionView = Backbone.View.extend({
		
		className: "article-collection",
		
		initialize: function(options){
			var _this = this;
			this.collection = new ArticleCollection([], {
				feedId: options.feedId
			});
			
			this.collection.fetch().done(function(){
				_this.render();
			});
		},
		
		render: function(){
			var _this = this;
			
			this.$el.html(Templates.articleCollectionView({
				articles: this.collection.toArrayOfAttributes()
			}));
			
			return this;
		}
	});
	
	return ArticleCollectionView;
});