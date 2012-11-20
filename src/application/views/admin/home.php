<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Administration
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
		<h3><i class="icon-list-alt"></i> Applications</h3>
		
		<?php if($db_apps->count() > 0): ?>
		
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Configured</th>
					<th>Instances</th>
					<th>Available for Users</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				
			<?php
			
			foreach ($db_apps as $app)
			{
				?>
				
				<tr>
					<td><?php echo $app->name; ?></td>
					<td><?php echo (bool) $app->configuration_valid ? '<span class="label label-success">Yes</span>' : '<span class="label label-important">No</span>'; ?></td>
					<td><span class="badge badge-info">?</span></td>
					<td><?php echo (bool) $app->available_for_users ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>'; ?></td>
					<td><a class="btn btn-small disabled">Configure</a> <a class="btn btn-danger btn-small disabled">Delete</a></td>
				</tr>
				
				<?php
			}
			
			?>
				
			</tbody>
		</table>
		
		<?php else: ?>
		
		<p class="lead">There are no applications currently configured to work with Orbital.</p>
		
		<?php endif; ?>
		
		<p><a href="<?php echo site_url('admin/scan'); ?>"class="btn btn-primary"><i class="icon-search"></i> Scan for Applications</a></p>
		
	</div>
			
</div>

<hr>

<div class="row">
	
	<div class="span12">
	
		<h3><i class="icon-magic"></i> Recipes</h3>
		
		<p class="lead">There are no recipes stored in Orbital.</p>
		
		<p><a class="btn btn-success disabled"><i class="icon-plus"></i> Create Recipe</a></p>
		
	</div>
			
</div>