<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Administration
	</h1>

</div>

<ul class="nav nav-pills">
	<li><a href="<?php echo site_url('admin'); ?>"><i class="icon-dashboard"></i> Overview</a></li>
	<li><a href="<?php echo site_url('admin/applications'); ?>"><i class="icon-list-alt"></i> Applications</a></li>
	<li><a href="<?php echo site_url('admin/recipes'); ?>"><i class="icon-book"></i> Recipes</a></li>
	<li class="active"><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-file"></i> Pages</a></li>
	<li><a href="<?php echo site_url('admin/page_categories'); ?>"><i class="icon-file"></i> Categories</a></li>
</ul>

<hr>
		
<table class="table table-bordered table-striped">
	<thead>
		<tr><th>Title</th><th>Type</th><th>Protected</th><th>Options</th></tr>
	</thead>
	<tbody>
	
	<?php
	
	foreach($pages as $page)
	{
		?>
			
		<tr>
			<td><?php echo $page->title; ?></td>
			<td><?php
			
			switch ($page->mode)
			{
				
				case 'git':
					echo '<span class="label label-inverse">GitHub</span>';
					break;
					
				case 'redirect':
					echo '<span class="label label-inverse">Redirect</span>';
					break;
					
				default:
					echo '<span class="label">Normal</span>';
					break;
				
			}
			
			?></td>
			<td><?php echo (bool) $page->protected ? '<span class="label label-important">Yes</span>' : '<span class="label label-success">No</span>'; ?></td>
			<td><a class="btn btn-small" href="<?php echo site_url('admin/page/' . $page->id); ?>"><i class="icon-pencil"></i> Edit</a><?php echo (bool) $page->protected ? '' : ' <a class="btn btn-small btn-danger" href="' . site_url('admin/delete_page/' . $page->id) . '"><i class="icon-trash"></i> Delete</a>'; ?></td>
		</tr>
		
		<?php
		}					
	?>
	</tbody>
</table>

<p><a class="btn btn-success" href="<?php echo site_url('admin/page/add'); ?>"><i class="icon-plus"></i> Add Page</a></p>