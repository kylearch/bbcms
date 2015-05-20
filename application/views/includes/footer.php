		<!-- Javascript -->
		<!-- These will be concatenated and minified for production -->
		<script type="text/javascript" src="public/js/libs/jquery.min.js"></script>
		<script type="text/javascript" src="public/js/libs/underscore.min.js"></script>
		<script type="text/javascript" src="public/js/libs/backbone.min.js"></script>
		<script type="text/javascript" src="public/js/views/NodeView.js"></script>
		<script type="text/javascript" src="public/js/views/TextView.js"></script>
		<script type="text/javascript" src="public/js/views/ImageView.js"></script>
		<script type="text/javascript" src="public/js/models/NodeModel.js"></script>
		<script type="text/javascript" src="public/js/models/TextModel.js"></script>
		<script type="text/javascript" src="public/js/models/ImageModel.js"></script>
		<script type="text/javascript" src="public/js/collections/NodeCollection.js"></script>
		<script type="text/javascript">
			new NodeView({ el: $(document) });
		</script>

	</body>
</html>