<div class="page-header">

	<h1>
		<?php echo($project['title']) ?>
	</h1>

</div>
<div class="row">
	
	<div class="span12">
		
		<table class="table table-bordered table-striped">
			<tbody>
			
				<?php
					echo '<tr>';
					echo '<td>Start Date</td><td>' . $project['start_date'] . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>End Date</td><td>' . $project['end_date'] . '</td>';
					echo '</tr>';
					if ($project['funded'])
					{
						echo '<tr>';
						echo '<td>Funding</td><td>' . $project['funding_currency']['symbol'] . $project['funding_amount'] . ' (' .  $project['funding_currency']['name'] . ')</td>';
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
					echo '<td>Lead</td><td>' . $project['project_lead']['name'] . '</td>';
					echo '</tr>';
					if (isset($project['research_project_members']))
					{
						foreach ($project['research_project_members'] as $member)
						{
							echo '<tr>';
							echo '<td>Member</td><td>' . $member['person']['first_name'] . ' ' . $member['person']['last_name'] . '</td>';
							echo '</tr>';
						}
					}
				?>
			
			</tbody>
		</table>
	
	</div>

	<div class="span4">
		<h3>Other Links</h3>
		<ul class="nav nav-pills nav-stacked">
			<?php
			if($project['ckan_uri'] !== 'https://ckan.lincoln.ac.uk/group/')
			{
				echo '<li><a href="' . $project['ckan_uri'] . '">' . $project['ckan_uri'] . '</a></li>';
			}
			else
			{
				echo '<li>None to display</li>';
			}
			?>
		</ul>
	</div>
	
</div>

<?php
if ($project['project_lead']['employee_id'] === $this->session->userdata('user_employee_id'))
{
	echo '<a href="' . site_url('project/' . $project['id'] . '/edit')  . '" class="btn btn"><i class="icon-pencil"></i> Edit Details</a> ';
	echo '<a href="' . site_url('project/' . $project['id'] . '/delete') . '" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>';
}
?>