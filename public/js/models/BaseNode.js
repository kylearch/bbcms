var BaseNode = Backbone.Model.extend({
	
	defaults: {
		id: '',
		content: '',
	},

	url: function() {
		return '/api/node/' + this.id;
	},

	initialize: function() {
	},

});