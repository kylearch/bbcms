var ImageView = NodeView.extend({

	initialize: function() {
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

		this.uploadModel = new UploadModel();

		this.listenTo(this.model, 'sync', this.render);
		this.listenTo(this.uploadModel, 'progress', this.progress);
		_.bindAll(this, 'render', 'keyMapper', 'destroy', 'startUpload', 'complete');
	},

	events: {
		'click': 'click',

		'click .node-replace': 'replaceImage',
		'click .node-remove': 'removeImage',
		'click .bb-file': 'triggerBrowse',
	},

	elements: function() {
		this.$content = $(this.el).wrapInner($("<div class='bb-editable'></div>")).children();
		this.$buttons = $("<div class='bb-buttons'></div>");
		this.$replace = $("<button class='button button-blue node-replace'>Replace</button>");
		this.$remove = $("<button class='button button-red node-remove'>Remove</button>");
		this.$file = $("<input type='file' name='bb-file' class='bb-file' accept='image/jpg,image/gif,image/png'>");
		this.$file.on("change", { self: this }, this.startUpload);
		this.$img = this.$content.find("img");
	},

	render: function() {
		var img = new Image();
		img.onload = function() {
			this.$img.attr("src", this.model.get("src")).animate({ opacity: 1 });
			this.$content.css({ background: "none", backgroundColor: "transparent" });
		};
		img.src = this.model.get("src");
	},

	createEditor: function() {
		this.$content.addClass("bb-editing");
		this.$buttons.append(this.$replace);
		this.$buttons.append(this.$remove);
		$("body").append(this.$file);
		$(this.el).append(this.$buttons);
	},

	destroyEditor: function() {
		if (this.cid === NodeView.ctx) {
			//this.$content.html(this.model.get("content")).prop("contenteditable", false).removeClass("bb-editing");
			this.$content.removeClass("bb-editing");
			this.$replace.remove();
			this.$remove.remove();
			this.$file.remove();
			this.deselect();
		}
	},

	replaceImage: function(e) {
		this.deBubble(e);
		this.$file.val("").trigger("click");
	},

	removeImage: function(e) {
		this.destroy();
	},

	startUpload: function(e) {
		var self = e.data.self,
			height = self.$img.height,
			width = self.$img.width; 
		self.$content.css({ background: "url('/src/img/placeholder.png') center center no-repeat", backgroundColor: "#CCCCCC", backgroundSize: "contain" });
		self.$img.animate({ opacity: 0 }, function() {
			self.doUpload();
		});
		var i = 0;
		var loop = setInterval(function() {
			
			if (i < 100) {
				i += 1;
			} else {
				clearInterval(loop);
			}
		}, 10);
	},

	doUpload: function() {
		var self = this;
		if (this.$file[0].files && this.$file[0].files[0]) {
			var file = this.$file[0].files[0];
			this.uploadModel.save({ file: file, node: this.model.get("id") }, {
				success: this.complete,
				error: function(model, response, options) {
					console.log(response);
				}
			});
		}
	},

	progress: function(progress) {
		this.animateBackgroundGradient(this.$replace, progress, "#4A8BEE");
	},

	complete: function(model, response, options) {
		this.model.save({ content: model.get("src") });
	},

	animateBackgroundGradient: function($el, percent, color1, color2) {
		color1 = (typeof color1 == "undefined") ? $el.css("backgroundColor") : color1 ;
		color2 = (typeof color2 == "undefined") ? "#FFFFFF" : color2 ;
		var chase = (percent < 1 || percent > 99) ? percent : percent - 1 ;
		$el.css({ background: color1 });
		$el.css({ background: "-moz-linear-gradient(left, " + color1 + " " + chase + "%, " + color2 + " " + percent + "%)" });
		$el.css({ background: "-webkit-gradient(linear, left top, right top, color-stop(0%, " + color1 + "), color-stop(" + percent + "%, " + color2 + "))" });
		$el.css({ background: "-webkit-linear-gradient(left, " + color1 + " " + chase + "%, " + color2 + " " + percent + "%)" });
		$el.css({ background: "-o-linear-gradient(left, " + color1 + " " + chase + "%, " + color2 + " " + percent + "%)" });
		$el.css({ background: "-ms-linear-gradient(left, " + color1 + " " + chase + "%, " + color2 + " " + percent + "%)" });
		$el.css({ background: "linear-gradient(to right, " + color1 + " " + chase + "%, " + color2 + " " + percent + "%)" });
	},

});