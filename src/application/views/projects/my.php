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
	
		<h4>Total Funding</h4>
	
		<?php
		foreach($total_funding as $funding)
		{
			echo '<p><span class="bignumber">' . $funding['symbol'] . number_format($funding['value']) .'</span></p>';

		}
		?>
	
	
	</div>

</div>

<?php if (count($active) > 0): ?>

<div id="projectsTimeline" class="gantt"></div>

<?php endif; ?>
		
<p><a class="btn btn-success" href="projects/start"><i class="icon-plus"></i> Add a Research Project</a></p>

<?php if (count($active) > 0): ?>

<h3>Active Projects</h3>

<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Project Name</th>
			<th>Project ID</th>
		</tr>
	</thead>
	<tbody>
	
	<?php
		foreach($active as $project)
		{
			echo '<tr>';
			echo '<td><a href = ' . site_url('project/' . $project['id']) . '>' . $project['title'] . '</a></td>';
			if ($project['ams_id'] !== NULL)
			{
				echo '<td>#' . $project['ams_id'] . '</td>';
			}
			else
			{
				echo '<td><span style="color:#999">N/A</span></td>';
			}
			echo '</tr>';
		}
	?>
	
	</tbody>
</table>

<?php

endif;

if (count($inactive) > 0):

?>

<h3>Archived Projects <small><a id="inactive_button"><i class="icon-double-angle-down"></i> Show / Hide</a></small></h3>

<div id="inactive" style="display:none">

<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Project Name</th>
			<th>Project ID</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($inactive as $project)
			{
				echo '<tr>';
				echo '<td><a href = ' . site_url('project/' . $project['id']) . '>' . $project['title'] . '</a></td>';
				if ($project['ams_id'] !== NULL)
				{
					echo '<td>#' . $project['ams_id'] . '</td>';
				}
				else
				{
					echo '<td><span style="color:#999">N/A</span></td>';
				}
				echo '</tr>';
			}
		?>
	</tbody>
</table>

</div>

<?php endif; 	