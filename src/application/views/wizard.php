<div class="page-header">

	<h1>
		<i class="icon-magic"></i> Project Wizard <small>Beta</small>
	</h1>

</div>

<div class="row">
			
	<div class="span12">
	
		<h2><?php echo $title; ?></h2>
		
		<?php echo $this->typography->auto_typography($content) ?>
	
	</div>
	
</div>

<?php if (count($options) > 0): ?>

<hr>

<?php foreach($options as $option): ?>

<div class="row">
			
	<div class="span12">
	
		<div class="well">
		
			<p class="pull-right"><a href="#" class="btn btn-primary"><i class="icon-arrow-right"></i> <?php echo $option['button']; ?></a></p>
			
			<?php echo $this->typography->auto_typography($option['text']) ?>
		
		</div>
	
	</div>
	
</div>

<?php

endforeach;
endif;

?>