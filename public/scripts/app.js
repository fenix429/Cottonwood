
define([
	"jquery",
	"backbone",
	"socket.io",
	"dispatcher",
	"views/feedCollectionView",
	"views/mixedArticleView",
	"views/articleCollectionView"
], function($, Backbone, io, Dispatch, FeedCollectionView, MixedArticleView, ArticleCollectionView){
	
	var App = function(){
		var _this = this;
		
		this.$content = $("#content");
		this.socket = io.connect('http://localhost:8080');
        this.views = [];
		
		this.views["feeds"] = new FeedCollectionView();
		
		Dispatch.on("subscribe:feed", function(id){
    		_this.socket.emit("subscribe", { "room": "feed-" + id });
		});
		
		this.socket.on("newArticle", function(data){
		    Dispatch.trigger("article:add", data);
		});
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