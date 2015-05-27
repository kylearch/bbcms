var UploadModel = Backbone.Model.extend({

	defaults: {
		file: '',
		node: '',
	},

	url: "/api/file",

});