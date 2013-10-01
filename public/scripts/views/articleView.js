
define(["backbone", "templates"], function(Backbone, Templates){
	var ArticleView = Backbone.View.extend({
		
		tagName: "article",
		
		initialize: function(){
			var _this = this;
		},
		
		render: function(){
			this.$el.attr('data-id', this.model.get('id'));
			
			this.$el.html( Templates.articleView( this.model.getAttributes() ) );
			
			return this;
		}
	});
	
	return ArticleView;
});