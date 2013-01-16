<div class="page-header">

	<h1>
		<?php echo($project->title) ?>
	</h1>

</div>
<div class="row">
	
	<div class="span12">
		
		<table class="table table-bordered table-striped">
			<tbody>
			
				<?php
					echo '<tr>';
					echo '<td>Start Date</td><td>' . $project->start_date . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>End Date</td><td>' . $project->end_date . '</td>';
					echo '</tr>';
					if ($project->funded)
					{
						echo '<tr>';
						echo '<td>Funding</td><td>' . $project->funding->currency->symbol . $project->funding->amount . ' (' .  $project->funding->currency->name . ')</td>';
						echo '</tr>';
					}
				?>
			
			</tbody>
		</table>
	</div>
	
	<div class="span8">
	
	<h3>Project Team</h3>
		<table class="table table-bordered table-striped">
			<tbody>
			
				<?php
					echo '<tr>';
					echo '<td>Name</td><td>' . $project->project_lead->title . ' ' . $project->project_lead->name . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Name</td><td>' . 'Project Member' . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Name</td><td>' . 'Project Member' . '</td>';
					echo '</tr>';
				?>
			
			</tbody>
		</table>
	
	</div>

	<div class="span4">
		<h3>Other Links</h3>
		<ul class="nav nav-pills nav-stacked">
			<li><a href="#">Other Links</a></li>
			<li><a href="#">Other Links</a></li>
			<li><a href="#">Other Links</a></li>
		</ul>
	</div>
	
</div>

<a href="<?php echo site_url('project/' . $project->id . '/edit'); ?>" class="btn btn"><i class="icon-pencil"></i> Edit</a>
<a href="<?php echo site_url('project/' . $project->id . '/delete'); ?>" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>