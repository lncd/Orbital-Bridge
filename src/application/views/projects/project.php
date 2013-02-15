<div class="page-header">

	<h1>
		<i class="icon-beaker"></i> <?php echo($project['title']) ?>
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

<div class="row">
	<div class="span12">

		<?php
			$bar_style='';
			if( ! isset($project['end_date_unix']))
			{
				$bar_style='progress-striped';
			}
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
		
		<div class="progress <?php echo $bar_style ?> margin-top">
		  <div class="bar bar-success" style="width: <?php echo $bar_percent ?>%;"></div>
		</div>
		
	</div>
	
</div>

<hr>

<div class="row">

	<div class="span8">
		
		<h3>Summary</h3>
		<?php echo markdown($project['summary']); ?>
		
	</div>
	
	<div class="span4">

		<h3>Options</h3>
		<ul class="nav nav-pills nav-stacked">
		
		<?php

		if($project['ckan_url'] !== NULL)
		{
			echo '<li><a href="' . $project['ckan_url'] . '" target="_blank"><i class="icon-external-link"></i> View project on CKAN</a></li>';
		}
		
		if ($project['current_user_role'] === 'Administrator')
		{
			if($project['ckan_group_id'] === NULL)
			{
				echo '<li><a data-toggle="modal" href="#createEnvironment"><i class="icon-magic"></i> Create Research Data Environment</a> ';
			}
			echo '<li><a href="' . site_url('project/' . $project['id'] . '/edit')  . '"><i class="icon-pencil"></i> Edit Project Details</a></li>';
		}
		if ($project['current_user_role'] === 'Administrator' AND $project['source'] !== 'ams' AND isset($project['end_date_unix']) AND $project['end_date_unix'] < Time())
		{
			echo '<li><a data-toggle="modal" href="#archiveProject"><i class="icon-folder-close"></i> Archive Project</a></li>';
		}
		if ($project['current_user_role'] === 'Super Administrator')
		{
			echo '<li><a href="' . site_url('project/' . $project['id'] . '/delete') . '"><i class="icon-trash"></i> Delete Project</a></li>';
		}
		?>
			
		</ul>
	
	</div>
</div>

<div class="row">
	<div class="span12">
		<h3>Funding</h3>
			<table class="table table-bordered table-striped table-condensed">
				<tbody>			
					<?php
					
					if( ! (bool) $project['funded'])
					{
						echo '<tr>';
						echo '<th scope="row">Funding Type</th><td>Unfunded</td>';
						echo '</tr>';
					}
					else
					{
						if(isset($project['funding_amount']))
						{
							echo '<tr>';
							echo '<th scope="row">Funding Amount</th><td>' . $project['funding_currency']['symbol'] . $project['funding_amount'] . '</td>';
							echo '</tr>';
						}
						if(isset($project['research_funding_type']))
						{
							echo '<tr>';
							echo '<th scope="row">Funding Type</th><td>' . $project['research_funding_type']['title'] . '</td>';
							echo '</tr>';
						}
						if(isset($project['research_funding_body']))
						{
							echo '<tr>';
							echo '<th scope="row">Funding Body</th><td>' . $project['research_funding_body']['title'] . '</td>';
							echo '</tr>';
						}
						if(isset($project['bid_submitted_date']))
						{
							echo '<tr>';
							echo '<th scope="row">Bid Submitted Date</th><td>' . date('jS F Y', strtotime($project['bid_submitted_date'])) . '</td>';
							echo '</tr>';
						}
						if(isset($project['bid_award_date']))
						{
							echo '<tr>';
							echo '<th scope="row">Bid Award Date</th><td>' . date('jS F Y', strtotime($project['bid_award_date'])) . '</td>';
							echo '</tr>';
						}
						if(isset($project['ams_success']))
						{
							echo '<tr>';
							echo '<th scope="row">Funding Status</th><td>' . $project['ams_success'] . '</td>';
							echo '</tr>';
						}
						if(count($project['schools']) > 0)
						{
							echo '<tr>';
							echo '<th scope="row">Involved Schools</th>';
							echo '<td>';
							
							foreach ($project['schools'] as $school)
							{
								echo $school['title'] . '<br>';
							}
							
							echo '</td>';
							echo '</tr>';
						}
						if(count($project['colleges']) > 0)
						{
							echo '<tr>';
							echo '<th scope="row">Involved Colleges</th>';
							echo '<td>';
							
							foreach ($project['colleges'] as $college)
							{
								echo $college['title'] . '<br>';
							}
							
							echo '</td>';
							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>
	</div>
</div>

<?php if (count($project['datasets']) > 0): ?>

<div class="row">
	
	<div class="span12">
	
	<h3>Datasets</h3>
		<table class="table table-bordered table-striped table-condensed">
			<thead><tr><th>Title</th><th>Options</th></tr></thead>
			<tbody>
			
				<?php
				foreach ($project['datasets'] as $dataset)
				{
					echo '<tr>';
					echo '<td><a href="' . $dataset['ckan_url'] . '">' . $dataset['title'] . '</a></td><td><a class="btn btn-small disabled"><i class="icon-upload"></i> Publish to Lincoln Repository</a></td>';
					echo '</tr>';
				}
				?>
			
			</tbody>
		</table>
	
	</div>	
</div>

<?php endif; ?>

<div class="row">
	
	<div class="span12">
	
	<h3>Project Team</h3>
		<table class="table table-bordered table-striped table-condensed">
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

<div class="modal fade" id="archiveProject">
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
</div>

<div class="modal fade" id="createEnvironment">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>Create Research Environment</h3>
	</div>
	<div class="modal-body">
		Creating this project's research data environment will automatically create a group for this project's data in CKAN, the University's research data repository. Once created, this environment will be linked to your Researcher Dashboard to simplify the process of sharing your research data (if required), as well as giving you an improved overview of your research data.
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Cancel</a>
		<a href=" <?php site_url('project/' . $project['id'] . '/create_ckan_group'); ?>" class="btn btn-primary"><i class="icon-magic"></i> Create Research Data Environment</a>
	</div>
</div>