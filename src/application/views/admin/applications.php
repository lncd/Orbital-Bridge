<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Administration
	</h1>

</div>

<ul class="nav nav-pills">
	<li><a href="<?php echo site_url('admin'); ?>"><i class="icon-dashboard"></i> Overview</a></li>
	<li class="active"><a href="<?php echo site_url('admin/applications'); ?>"><i class="icon-list-alt"></i> Applications</a></li>
	<li><a href="<?php echo site_url('admin/recipes'); ?>"><i class="icon-book"></i> Recipes</a></li>
	<li><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-file"></i> Pages</a></li>
	<li><a href="<?php echo site_url('admin/page_categories'); ?>"><i class="icon-file"></i> Categories</a></li>
</ul>

<hr>
		
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