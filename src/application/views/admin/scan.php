<div class="page-header">

	<h1>
		<i class="icon-search"></i> Scan for Applications
	</h1>

</div>

<p class="lead">Discovered <?php echo count($discovered); ?> application plugins.</p>

<?php

foreach ($discovered as $app):

?>

<h3><?php echo $app['name']; ?></h3>

<?php if ($app['error']): ?>

<div class="alert alert-error alert-block">
  <h4>Oops!</h4>
  <?php echo $app['error_message']; ?>
</div>

<?php endif; ?>

<?php

endforeach;

?>