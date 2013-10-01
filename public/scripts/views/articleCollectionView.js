
define([
	"underscore",
	"backbone",
	"dispatcher",
	"templates",
	"models/article",
	"collections/articleCollection",
	"views/articleView"
], function(_, Backbone, Dispatch, Templates, Article, ArticleCollection, ArticleView){
	var ArticleCollectionView = Backbone.View.extend({
		
		className: "article-collection",
		
		initialize: function(options){
			var _this = this;
			
			this.views = [];
			
			this.collection = new ArticleCollection([], {
				feedId: options.feedId
			});
			
			this.collection.fetch().done(function(){
				_this.render();
				_this.listenTo(_this.collection, 'add', _this.addArticle);
			});
			
			Dispatch.trigger("subscribe:feed", options.feedId);
			
			Dispatch.on("article:add", function(data){
			    _this.collection.add(new Article(data));
			});
		},
		
		render: function(){
			var _this = this;
			
			this.views = [];
			
			this.collection.map(function(model){
			    var view = new ArticleView({ model: model });
			    
    			_this.views.unshift(view);
    			
    			_this.$el.append(view.render().$el);
			});
			
			return this;
		},
		
		addArticle: function(model){
		    var view = new ArticleView({ model: model }),
		        $viewElement = view.render().$el;
		    
		    this.views.unshift(view);
		    
		    $viewElement.hide();
		    
    		this.$el.prepend($viewElement);
    		
    		$viewElement.slideDown();
		}
		
	});
	
	return ArticleCollectionView;
});