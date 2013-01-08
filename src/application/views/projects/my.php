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

<div id="projectsTimeline" class="gantt"></div>

<div class="row">
	
	<div class="span12">
		
		<p><a class="btn btn-success" href="#"><i class="icon-plus"></i> Add</a></p>
		
		<h2>Current Projects</h2>
		
		<table class="table table-bordered table-striped">
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
		
		<h2>Past Projects</h2>
		<button id="inactive_button" class="icon-cog"> Show / Hide</button>
		
		<table id="inactive" class="table table-bordered table-striped" style="display:none">
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
			
</div>