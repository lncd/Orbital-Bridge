<div class="page-header">

	<h1>
		<?php echo($project['title']) ?>
	</h1>

</div>

<h4>Status</h4>
<div class="row">

	<div class="span4">
	
		<?php echo '<p class="lead">';
		if ($project['research_project_status']['needs_attention'])
		{
			echo '<span style="color:red">';
		}
		else
		{
			echo '<span>';
		}
		echo $project['research_project_status']['text'] . '</span>';
		?>
		
	</div>

	<div class="span8">
		
<p><?php echo $project['research_project_status']['description']; ?></p>
	</div>

</div>

<hr>

<div class="row">

	<div class="span4">
	
		<h4>Start Date</h4>
	
		<?php echo date('jS F Y', $project['start_date_unix']); ?>
	
	</div>
	
	<div class="span4">
	</div>
	
	<div class="span4 align-right">
	
		<?php if($project['end_date']):
		echo '<h4>End Date</h4>';
	
		echo date('jS F Y', $project['end_date_unix']);
		
		endif; ?>
		
	</div>

</div>

<?php

	if (time() < $project['start_date_unix'])
	{
		$bar_percent = 0;
	}
	else if (time() > $project['end_date_unix'])
	{
		$bar_percent = 100;
	}
	else
	{
		$bar_percent = ((time() - $project['start_date_unix']) / ($project['end_date_unix'] - $project['start_date_unix'])) * 100;
	}
?>

<div class="progress margin-top">
  <div class="bar bar-success" style="width: <?php echo $bar_percent ?>%;"></div>
</div>

<hr>
<?php if(isset($project['summary']))
{
	echo'
		<h4>Summary</h4>
		<div class="row">
			<div class="span12 align-left">
		
				' . markdown($project['summary']) . '
			</div>
		</div>
	<hr>
	';
}
?>

<div class="row">
	<div class="span8">
		<h3>Funding</h3>
			<table class="table table-bordered table-striped">
				<tbody>			
					<?php
					echo '<tr>';
					echo '<th scope="row">Funding Amount</th><td>' . $project['funding_amount'] . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<th scope="row">Funding Type</th><td>' . $project['research_funding_type']['title'] . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<th scope="row">Funding Body</th><td>' . $project['research_funding_body']['title'] . '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<th scope="row">Involved Schools</th>';
					echo '<td>';
					
					foreach ($project['schools'] as $school)
					{
						echo $school['title'] . '<br>';
					}
					
					echo '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<th scope="row">Involved Colleges</th>';
					echo '<td>';
					
					foreach ($project['colleges'] as $college)
					{
						echo $college['title'] . '<br>';
					}
					
					echo '</td>';
					echo '</tr>';
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
				echo '<li><a href="' . $project['ckan_uri'] . '">View group on CKAN</a></li>';
			}
			else
			{
				echo '<li>None to display</li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="row">
	
	<div class="span12">
	
	<h3>Project Team</h3>
		<table class="table table-bordered table-striped">
			<thead><tr><th>Member</th><th>Role</th></tr></thead>
			<tbody>
			
				<?php
					if (isset($project['research_project_members']))
					{
						foreach ($project['research_project_members'] as $member)
						{
							echo '<tr>';
							echo '<td>' . $member['person']['first_name'] . ' ' . $member['person']['last_name'] . '</td><td>' . $member['role']['name'] . '</td>';
							echo '</tr>';
						}
					}
				?>
			
			</tbody>
		</table>
	
	</div>	
</div>

			

		
<!-- Archive Project -->

<form class="modal fade" id="archiveProject">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>Archive</h3>
	</div>
	<div class="modal-body">
		Are you sure you want to Archive this project? It will remain visible, but no longer editable
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Cancel</a>
		<a href=" <?php echo(site_url('project/' . $project['id'] . '/archive')); ?>" class="btn btn-warning"><i class="icon-folder-close"></i> Archive</a>
	</div>
</form>

<?php

if ($project['current_user_role'] === 'Administrator')
{
	echo '<a href="' . site_url('project/' . $project['id'] . '/edit')  . '" class="btn btn"><i class="icon-pencil"></i> Edit Details</a> ';
	echo '<a class="btn btn-warning" data-toggle="modal" href="#archiveProject" ><i class = "icon-folder-close"></i> Archive</a>';
}
if ($project['current_user_role'] === 'Super Administrator')
{
	echo '<a href="' . site_url('project/' . $project['id'] . '/delete') . '" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>';
}
?>