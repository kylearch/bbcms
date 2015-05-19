		<!-- Javascript -->
		<!-- These will be concatenated and minified for production -->
		<script type="text/javascript" src="public/js/libs/jquery.min.js"></script>
		<script type="text/javascript" src="public/js/libs/underscore.min.js"></script>
		<script type="text/javascript" src="public/js/libs/backbone.min.js"></script>
		<script type="text/javascript" src="public/js/views/NodeView.js"></script>
		<script type="text/javascript" src="public/js/models/BaseNode.js"></script>
		<script type="text/javascript" src="public/js/models/TextNode.js"></script>
		<script type="text/javascript">
			var nodes = document.getElementsByClassName("node");
			for (var i = 0; i < nodes.length; i++) {
				new NodeView({ el: nodes[i] });
			}
		</script>

	</body>
</html>