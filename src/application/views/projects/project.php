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
						echo '<td>Funding</td><td>' . $project->funding->currency_symbol . $project->funding->amount . ' (' .  $project->funding->currency_name . ')</td>';
						echo '</tr>';
					}
				?>
			
			</tbody>
		</table>
	</div>
	
	<div class="span8">
		<h3>Project Lead</h3>
		<ul class="nav nav-pills nav-stacked">
			<li>Project Lead</li>
			<li>dfghjk</li>
		</ul>
	</div>

	<div class="span4">
		<h3>Other Links</h3>
		<ul class="nav nav-pills nav-stacked">
			<li>Other Links</li>
			<li>dfghjk</li>
		</ul>
	</div>
</div>