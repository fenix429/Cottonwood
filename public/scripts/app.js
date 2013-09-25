
define([
	"jquery",
	"backbone",
	"dispatcher",
	"views/feedCollectionView",
	"views/mixedArticleView",
	"views/articleCollectionView"
], function($, Backbone, Dispatch, FeedCollectionView, MixedArticleView, ArticleCollectionView){
	
	var App = function(){
		var _this = this;
		
		this.$content = $("#content");
		this.views = [];
		
		this.views["feeds"] = new FeedCollectionView();
	};
	
	App.prototype.show = function(id) {
		Dispatch.trigger("show:feed", id);
		this.updateContent(new ArticleCollectionView({
			feedId: id
		}));
	};
	
	App.prototype.index = function() {
		Dispatch.trigger("show:index");
		this.updateContent(new MixedArticleView());
	};
	
	App.prototype.updateContent = function(contentView) {
		var _this = this;
		
		this.views["content"] = contentView;
		
		this.$content.fadeOut(function(){
			_this.$content.html(contentView.el).fadeIn();
		});
	};
	
	return App;
});