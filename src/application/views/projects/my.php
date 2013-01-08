<div class="page-header">

	<h1>
		<i class="icon-beaker"></i> My Projects
	</h1>

</div>

<div class="row">

	<div class="span4">
	
		<h4>Total Projects</h4>
	
		<p class="bignumber"><?php echo number_format($total_projects); ?></p>
	
	</div>

	<div class="span4">
	
		<h4>Current Projects</h4>
	
		<p><span class="bignumber"><?php echo number_format($total_current_projects); ?></span></p>
	
	</div>
	
	<div class="span4">
	
		<h4>Total Funding (Sterling)</h4>
	
		<p><span class="bignumber">&pound;<?php echo number_format($total_funding); ?></span></p>
	
	</div>

</div>

<?php if (count($active) > 0): ?>

<div id="projectsTimeline" class="gantt"></div>

<?php endif; ?>
		
<p><a class="btn btn-success" href="#"><i class="icon-plus"></i> Add New Project</a></p>

<?php if (count($active) > 0): ?>

<h2>Current Projects</h2>

<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Project Name</th>
		</tr>
	</thead>
	<tbody>
	
	<?php
		foreach($active as $project)
		{
			echo '<tr>';
			echo '<td><a href = ' . site_url('projects/' . $project->id) . '>' . $project->title . '</a></td>';
			echo '</tr>';
		}
	?>
	
	</tbody>
</table>

<?php

endif;

if (count($inactive) > 0):

?>

<h2>Past Projects</h2>

<p><a id="inactive_button"><i class="icon-double-angle-down"></i> Show / Hide</a></p>

<div id="inactive" style="display:none">

<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Project Name</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($inactive as $project)
			{
				echo '<tr>';
				echo '<td><a href = ' . site_url('projects/' . $project->id) . '>' . $project->title . '</a></td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table>

</div>

<?php endif; ?>