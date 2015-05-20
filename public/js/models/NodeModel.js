var NodeModel = Backbone.Model.extend({
	
	defaults: {
		id: '',
		content: '',
		name: '',
		type: '',
	},

	url: function() {
		return '/api/node/' + this.id;
	},

	initialize: function(options) {
	},

});