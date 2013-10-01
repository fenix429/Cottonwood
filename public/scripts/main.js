
require.config({
	paths: {
		"jquery": "/components/jquery/jquery",
		"underscore": "/components/lodash/dist/lodash",
		"backbone": "/components/backbone-amd/backbone",
		"bootstrap": "/components/bootstrap/dist/js/bootstrap",
		"handlebars": "/components/handlebars/handlebars",
		"moment": "/components/momentjs/moment",
		"socket.io": "/components/socket.io-client/dist/socket.io"
	},
	shim: {
		"handlebars": {
			exports: "Handlebars"
		},
		"bootstrap": {
			deps: ["jquery"]
		}
	}
});

define(["backbone", "app"], function(Backbone, App){
	$("document").ready(function(){
		// attach to global for dev
		window.CottonwoodApp = new App();
		
		var Router = Backbone.Router.extend({
			routes: {
				"": "index",
				"feed/:id": "show"
			},
			
			index: function(){
				CottonwoodApp.index();
			},
			
			show: function(id){
				CottonwoodApp.show(parseInt(id));
			}
		});
		
		var router = new Router();
		Backbone.history.start();
	});
});
