
define(["backbone", "templates"], function(Backbone, templates){
	var MixedArticleView = Backbone.View.extend({
		
		className: "mixed-articles",
		
		initialize: function(){
			var _this = this;
			this.render();
		},
		
		render: function(){
			var _this = this;
			
			this.$el.html(templates.mixedArticleView());
			
			return this;
		}
	});
	
	return MixedArticleView;
});