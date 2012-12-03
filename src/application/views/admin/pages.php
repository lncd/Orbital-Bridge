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
</ul>

<hr>
		
<table class="table table-bordered table-striped">
	<thead>
		<tr><th>Title</th><th>Options</th></tr>
	</thead>
	<tbody>
	
	<?php
	
		foreach($pages as $page)
		{
			echo '<tr>' . '<td>' . $page->title . '</td><td><a class="btn btn-small" href="' . site_url('admin/page/' . $page->id) . '">
			<i class="icon-pencil"></i> Edit</a> <a class="btn btn-small btn-danger" href="' . site_url('admin/delete_page/' . $page->id) . '">
			<i class="icon-trash"></i> Delete</a></td></tr>';
		}					
	?>
	</tbody>
</table>