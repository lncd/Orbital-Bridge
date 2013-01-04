<div class="page-header">

	<h1>
		<i class="icon-beaker"></i> My Projects
	</h1>

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
					echo "<td><a href = '#'>" . $project->title . '</a></td>';
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
					echo "<td><a href = '#'>" . $project->title . '</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
			
</div>