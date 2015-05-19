<div class="container">
	<header>
		<a href="/">BBCMS</a>
	</header>

	<div class="content">
		<div class="node" data-id="<?php echo $node->id; ?>" data-name="<?php echo $node->name; ?>" data-type="<?php echo $node->type; ?>">
			<?php echo $node->content; ?>
		</div>
	</div>

	<?php $this->load("includes/sidebar"); ?>
</div>