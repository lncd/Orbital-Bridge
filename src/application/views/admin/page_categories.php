<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Administration
	</h1>

</div>

<ul class="nav nav-pills">
	<li><a href="<?php echo site_url('admin'); ?>"><i class="icon-dashboard"></i> Overview</a></li>
	<li><a href="<?php echo site_url('admin/applications'); ?>"><i class="icon-list-alt"></i> Applications</a></li>
	<li><a href="<?php echo site_url('admin/recipes'); ?>"><i class="icon-book"></i> Recipes</a></li>
	<li><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-file"></i> Pages</a></li>
	<li class="active"><a href="<?php echo site_url('admin/page_categories'); ?>"><i class="icon-file"></i> Categories</a></li>
</ul>

<hr>
		
<table class="table table-bordered table-striped">
	<thead>
		<tr><th>Title</th><th>Active</th><th>Options</th></tr>
	</thead>
	<tbody>
	
	<?php
	
	foreach ($categories as $category)
	{
		?>
	
		<tr>
			<td><?php echo $category->title; ?></td>
			<td><?php echo (bool) $category->active ? '<span class="label label-success">Yes</span>' : '<span class="label label-important">No</span>'; ?></td>
			<td><a class="btn btn-small" href="<?php echo site_url('admin/page_category/' . $category->id); ?>"><i class="icon-pencil"></i> Edit</a> <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/delete_page_category/' . $category->id); ?>"><i class="icon-trash"></i> Delete</a></td></tr>
	
			<?php
	}
	
	?>
	
	</tbody>
</table>

<p><a class="btn btn-success" href="<?php echo site_url('admin/category/add'); ?>"><i class="icon-plus"></i> Add Category</a> <a class="btn" href="<?php echo site_url('admin/page_categories/order'); ?>"><i class="icon-list-ol"></i> Reorder Categories</a></p>