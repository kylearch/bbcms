<div class="container">
  <header>
    <a href="/">BBCMS</a>
  </header>

  <div class="content">
    <h1>This is a test page</h1>
    <div class="node" data-id="<?php echo $node->id; ?>" data-name="<?php echo $node->name; ?>" data-type="<?php echo $node->type; ?>">
      <?php echo $node->content; ?>
    </div>
  </div>
</div>