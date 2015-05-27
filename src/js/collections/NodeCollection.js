var NodeCollection = Backbone.Collection.extend({

	initialize: function(options) {
		// console.log("collection initialized");
	},

	model: NodeModel,

	url: function() {
		return "/api/nodes/";
	},

});