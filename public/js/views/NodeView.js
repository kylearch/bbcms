var NodeView = Backbone.View.extend({
	
	initialize: function() {
		var self = this,
			type = $(this.el).data("type");
			modelName = (typeof type !== "undefined") ? type.charAt(0).toUpperCase() + type.slice(1) + "Node" : "BaseNode" ,
			id = $(this.el).data("id"),
			name = $(this.el).data("name");
		this.model = new window[modelName]({id: id});
		this.model.fetch();

		this.$content = $(this.el).wrapInner($("<div class='bb-editable'></div>")).children();
		this.$save = $("<button class='button button-blue node-save'>Save</button>");
		this.$cancel = $("<button class='button button-red node-cancel'>Cancel</button>");

		this.isEditing = false;

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

	deBubble: function(e) {
		if (e && e.preventDefault && e.stopPropagation) {
			e.preventDefault(); 
			e.stopPropagation();
		}
	},

	click: function(e) {
		this.deBubble(e);
		if ( ! this.isEditing) {
			this.$content.prop("contenteditable", true);
			$(this.el).append(this.$save);
			$(this.el).append(this.$cancel);
			$(document).on("keydown", this.keyMapper);
			this.isEditing = true;
		}
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

	destroy: function(e) {
		this.deBubble(e);
		$(document).off("keydown");
		this.$content.html(this.model.get("content")).prop("contenteditable", false);
		this.$save.remove();
		this.$cancel.remove();
		this.deselect();
		this.isEditing = false;
	},

	deselect: function() {
	    if (document.selection) {
	        document.selection.empty();
	    } else if (window.getSelection) {
	        window.getSelection().removeAllRanges();
	    }
	},

	keyMapper: function(e) {
		switch (e.keyCode) {
			case 27: 
				this.destroy();
			break;
		}
		// console.log(e.keyCode);
	}

});