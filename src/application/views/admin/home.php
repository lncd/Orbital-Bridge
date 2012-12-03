<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Administration
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
		<ul class="nav nav-tabs">
			<li class="active"><a href="#overview" data-toggle="tab"><i class="icon-dashboard"></i> Overview</a></li>
			<li><a href="#applications" data-toggle="tab"><i class="icon-list-alt"></i> Applications</a></li>
			<li><a href="#recipes" data-toggle="tab"><i class="icon-book"></i> Recipes</a></li>
			<li><a href="#pages" data-toggle="tab"><i class="icon-file"></i> Pages</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="overview">
				
				<h3><i class="icon-dashboard"></i> Overview</h3>
				
				<p class="lead">No system notices.</p>
				
			</div>
			<div class="tab-pane fade" id="applications">
			
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
			<div class="tab-pane fade" id="recipes">
			
				<h3><i class="icon-book"></i> Recipes</h3>
		
				<p class="lead">There are no recipes stored in Orbital.</p>
				
				<p><a class="btn btn-success disabled"><i class="icon-plus"></i> Create Recipe</a></p>
				
			</div>
			<div class="tab-pane fade" id="pages">
			
				<h3><i class="icon-file"></i> Pages</h3>
				<table class="table">
				
				<?php
				foreach($categories as $category)
				{
					foreach($category_pages[$category->id] as $page)
					{
						echo '<tr>' . '<td>' . $page->title . '</td><td><p><a class="btn btn" href="' . site_url('admin/page/' . $page->id) . '"><i class="icon-p"></i> Edit</a></p></td></tr>';
					}
				}
				?>

				</table>
			</div>
		</div>		
	</div>			
</div>