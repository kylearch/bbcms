var TextView = NodeView.extend({

	initialize: function(options) {
		this.model.fetch({
			success: function(model, response) {
				//console.log(response);
			},
			error: function(model, e) {
				console.error(e.responseText);
			}
		});
		this.isEditing = false;
		this.elements();

		this.listenTo(this.model, 'change', this.render);
		_.bindAll(this, 'render', 'keyMapper', 'destroy');
	},

	events: {
		'click': 'click',

		'click .node-save': 'save',
		'click .node-cancel': 'destroy',
	},

	render: function(model) {
		this.$content.html(model.get("content"));
	},
	
	elements: function() {
		this.$content = $(this.el).wrapInner($("<div class='bb-editable'></div>")).children();
		this.$buttons = $("<div class='bb-buttons'></div>");
		this.$save = $("<button class='button button-blue node-save'>Save</button>");
		this.$cancel = $("<button class='button button-red node-cancel'>Cancel</button>");
	},

	createEditor: function() {
		this.$content.prop("contenteditable", true).addClass("bb-editing");;
		this.$buttons.append(this.$save);
		this.$buttons.append(this.$cancel);
		$(this.el).append(this.$buttons);
	},

	save: function(e) {
		var content = this.$content.html();
		this.model.save({"content": content}, {
			success: this.destroy,
			error: function(model, e) {
				console.error(e.responseText);
			}
		});
	},

});