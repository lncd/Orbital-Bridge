<div class="page-header">

	<h1>
		<i class="icon-beaker"></i> <?php
		
			echo($project['title']);
			
			if ($project['ams_id'] !== NULL)
			{
				echo ' <small>#' . $project['ams_id'] . '</small>';
			}
		?>
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
<?php
	if(isset($project['website']) AND $project['website'] !== '')
	{
		echo '<div class="span8">';
		echo '<h3>Website</h3>';
		echo '<a href="' . $project['website'] .'">' . $project['website'] . '</a>';
		echo '</div>';
	}
?>
</div>
<div class="row">

	<div class="span8">
		
		<h3>Summary</h3>
		<?php echo $project['summary_html']; ?>
		
	</div>
	
	<div class="span4">

		<h3>Options</h3>
		<ul class="nav nav-pills nav-stacked">
		
		<?php

		if($project['ckan_url'] !== NULL)
		{
			echo '<li><a href="' . $project['ckan_url'] . '" target="_blank"><i class="icon-external-link"></i> View project on CKAN</a></li>';
		}
		
		if ($project['current_user_permission'] === 'Administrator')
		{
			if($project['ckan_group_id'] === NULL)
			{
				echo '<li><a data-toggle="modal" href="#createEnvironment"><i class="icon-magic"></i> Create Research Data Environment</a> ';
			}
			echo '<li><a href="' . site_url('project/' . $project['id'] . '/edit')  . '"><i class="icon-pencil"></i> Edit Project Details</a></li>';
		}
		if ($project['current_user_permission'] === 'Administrator' AND $project['source'] !== 'ams' AND isset($project['end_date_unix']) AND $project['end_date_unix'] < Time())
		{
			echo '<li><a data-toggle="modal" href="#archiveProject"><i class="icon-folder-close"></i> Archive Project</a></li>';
		}
		if ($project['current_user_permission'] === 'Super Administrator')
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

<div class="row">
	
	<div class="span6">
	
		<h3>Datasets</h3>
		
		<div class="alert alert-info alert-block">
			<h4>Data Management Plan</h4>
			<p>We haven't yet detected a Data Management Plan for this research project. Creating a DMP might be mandated by your funder, and is always a good idea since it helps you determine the types and volumes of data you'll be handling and how to best store and archive it.</p>
		</div>
		
		<?php if (count($project['datasets']) > 0): ?>
		
		<table class="table table-bordered table-striped table-condensed">
			<thead><tr><th>Title</th><th>Options</th></tr></thead>
			<tbody>
			
				<?php
				foreach ($project['datasets'] as $dataset)
				{
					echo '<tr>';
					echo '<td><a href="' . $dataset['ckan_url'] . '">' . $dataset['title'] . '</a></td><td>';

					if ($project['current_user_permission'] === 'Administrator')
					{
						echo '<a href="' . site_url('dataset/' . $dataset['id'] . '/deposit') . '" class="btn btn-small"><i class="icon-upload"></i> Publish to Lincoln Repository</a>';
					}

					echo '</td></tr>';
				}
				?>
			
			</tbody>
		</table>
		
		<?php else: ?>
		
		<p>There aren't currently any datasets in CKAN which are associated with this project's group.</p>
		
		<?php endif; ?>
		
		<p><a class="btn btn-mini" data-toggle="modal" href="#requestDSRefresh"><i class="icon-refresh"></i> Refresh Datasets</a></p>
	
	</div>
	
	<div class="span6">
	
		<h3>Publications</h3>
		
		<?php if (count($project['publications']) > 0): ?>
		
		<ul class="nav nav-pills nav-stacked">
			
			<?php
			foreach ($project['publications'] as $publication)
			{
				echo '<li><a href="' . $publication['eprints_uri'] . '">' . $publication['reference_plain'] . '</a></li>';
			}
			?>
			
		</ul>
		
		<?php else: ?>
		
		<p>There aren't currently any publications in the Lincoln Repository which are associated with this project.</p>
		
		<?php endif; ?>
	
	</div>
		
</div>

<div class="row">
	
	<div class="span12">
	
	<h3>Project Team</h3>
		<table class="table table-bordered table-striped table-condensed">
			<thead><tr><th>Member</th><th>Permission</th></tr></thead>
			<tbody>
			
				<?php
					if (isset($project['research_project_members']))
					{
						foreach ($project['research_project_members'] as $member)
						{
							echo '<tr>';
							echo '<td>' . $member['person']['first_name'] . ' ' . $member['person']['last_name'] . '</td><td>' . $member['permission']['name'] . '</td>';
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

<div class="modal fade" id="requestDSRefresh">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>Refresh Datasets</h3>
	</div>
	<div class="modal-body">
		Although the datasets for a project are updated regularly, if you have recently made some changes they might not have been detected yet. Choose to refresh the datasets for these changes to be detected and brought into your Researcher Dashboard. This process might take a few seconds to complete once you click the button.
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Cancel</a>
		<a href=" <?php echo(site_url('project/' . $project['id'] . '/refresh_datasets')); ?>" class="btn btn-primary"><i class="icon-refresh"></i> Refresh Datasets</a>
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
		<a href=" <?php echo(site_url('project/' . $project['id'] . '/create_ckan_group')); ?>" class="btn btn-primary"><i class="icon-magic"></i> Create Research Data Environment</a>
	</div>
</div>