var NodeView = Backbone.View.extend({
	
	initialize: function() {
		var self = this,
			$nodes = $(this.el).find(".bb-node");
			nodes = [];

		NodeView.ctx = null;

		this.collection = new NodeCollection();
		$nodes.each(function(i, el) {
			nodes.push({ id: $(el).data("id"), type: $(el).data("type"), name: $(el).data("name") });
			var modelType = $(el).data("type").charAt(0).toUpperCase() + $(el).data("type").slice(1) + "Model",
				viewType = $(el).data("type").charAt(0).toUpperCase() + $(el).data("type").slice(1) + "View";
				model = new window[modelType]({ id: $(el).data("id") });
			self.collection.add(model);
			new window[viewType]({ el: $(el), model: model });
		});

		this.listenTo(this.collection, "sync", function() {
			if (this.collection.length == $nodes.length) {
				// All models loaded... dont know if anything needs to be done here yet
				// console.log(this.collection);
			}
		});
	},

	deBubble: function(e) {
		if (e && e.preventDefault && e.stopPropagation) {
			e.preventDefault(); 
			e.stopPropagation();
		}
	},

	click: function(e) {
		this.deBubble(e);
		NodeView.ctx = this.cid;
		if ( ! this.isEditing) {
			this.createEditor();
			$(document).on("keydown", this.keyMapper);
			this.isEditing = true;
		}
	},

	destroy: function(e) {
		this.deBubble(e);
		$(document).off("keydown");
		this.destroyEditor();
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
			case 27: this.destroy(); break;
		}
		// console.log(e.keyCode);
	}

});