
define(["backbone", "underscore", "templates", "dispatcher", "collections/feedCollection"], function(Backbone, _, Templates, Dispatch, FeedCollection){
	var FeedCollectionView = Backbone.View.extend({
		
		el: "#feeds",
		
		initialize: function(options){
			var _this = this;
			this.feeds = new FeedCollection();
			
			_.bindAll(this); // <- do i need this?
			
			this.fetching = this.feeds.fetch();
			this.fetching.done(function(){
				_this.render();
			});
			
			Dispatch.on("show:feed", function(id){
				_this.updateActiveLink(id);
			});
			
			Dispatch.on("show:index", function(){
				_this.updateActiveLink(0);
			});
		},
		
		render: function(){
			var _this = this;
			
			this.$el.html(Templates.feedCollectionView({
				feeds: this.feeds.toArrayOfAttributes()
			}));
			
			return this;
		},
		
		updateActiveLink: function(id){
			var _this = this;
			this.fetching.done(function(){
				_this.$("a").removeClass("active");
				_this.$("a[data-feed-id=" + id + "]").addClass("active");				
			});
		}
	});
	
	return FeedCollectionView;
});