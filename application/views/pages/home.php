<div class="container">
	<header>
		<a href="/">Joust CMS</a>
	</header>

	<div class="content">
		<div class="bb-node" data-id="<?php echo $node->id; ?>" data-name="<?php echo $node->name; ?>" data-type="<?php echo $node->type; ?>">
			<?php echo $node->content; ?>
		</div>
		<div class="bb-node" data-id="<?php echo $image->id; ?>" data-name="<?php echo $image->name; ?>" data-type="<?php echo $image->type; ?>">
			<img class="main-image" src="<?php echo $image->content; ?>">
		</div>
	</div>

	<?php $this->load("includes/sidebar"); ?>
</div>