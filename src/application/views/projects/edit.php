<div class="page-header">

	<h1>
		<i class="icon-pencil"></i> <?php echo $project['title']; ?><small> Edit</small>
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
	<?php 
		echo validation_errors();
	
		echo form_open('project/' . $project_id . '/edit', array('class' => 'form-horizontal'));
	
		if ($project['research_project_status']['text'] !== 'Archived')
		{	
			if ($project['source'] !== 'ams')
			{	
				$form_title = array(
					'name'			=> 'project_title',
					'required'   	=> 'required',
					'value'			=> $project['title'],
					'id'			=> 'project_title',
					'maxlength'		=> '200',
					'class'			=> 'input-xlarge'
				);
			
				echo '<div class="control-group">';
				echo form_label('Title', 'project_title', array('class' => 'control-label'));
				echo '<div class="controls">';
				echo form_input($form_title);
				echo '<span class="help-block">The title of the project.</span>';
				echo '</div></div>';
			
				$form_description = array(
					'name'			=> 'project_description',
					'id'			=> 'project_description',
					'value'			=> $project['summary'],
					'rows'			=> '5',
					'class'			=> 'input-block-level',
					'style'			=> 'width:100%;'
				);
			
				echo '<div class="control-group">';
				echo form_label('Description', 'project_description', array('class' => 'control-label'));
				echo '<div class="controls">';
				echo form_textarea($form_description);
				echo '<span class="help-block">A short description of this research project.</span>';
				echo '</div></div>';
			
				$form_website = array(
					'name'			=> 'project_website',
					'value'			=> $project['website'],
					'id'			=> 'project_website',
					'maxlength'		=> '200',
					'class'			=> 'input-xlarge'
				);
			
				echo '<div class="control-group">';
				echo form_label('Website', 'project_website', array('class' => 'control-label'));
				echo '<div class="controls">';
				echo form_input($form_website);
				echo '<span class="help-block">If the project has one, a website where people can find out more.</span>';
				echo '</div></div>';
				
				$form_start_date = array(
					'name'			=> 'project_start_date',
					'required'   	=> 'required',
					'id'			=> 'project_start_date',
					'value'			=> date('Y-m-d', $project['start_date_unix']),
					'maxlength'		=> '200',
					'class'			=> 'input-xlarge datepicker'
				);
			
				echo '<div class="control-group">';
				echo form_label('Start Date', 'project_start_date', array('class' => 'control-label'));
				echo '<div class="controls">';
				echo form_input($form_start_date);
				echo '<span class="help-block">The date the project starts or started.</span>';
				echo '</div></div>';
				
				if (isset($project['end_date_unix']))
				{
					$end_date = date('Y-m-d', $project['end_date_unix']);
				}
				else
				{
					$end_date = NULL;
				}
				
				$form_end_date = array(
					'name'			=> 'project_end_date',
					'id'			=> 'project_end_date',
					'value'			=> $end_date,
					'maxlength'		=> '200',
					'class'			=> 'input-xlarge datepicker'
				);
			
				echo '<div class="control-group">';
				echo form_label('End Date', 'project_end_date', array('class' => 'control-label'));
				echo '<div class="controls">';
				echo form_input($form_end_date);
				echo '<span class="help-block">If the project has one, an end date for the project.</span>';
				echo '</div></div>';
			}
			
			if ($project['source'] === 'ams')
			{
				echo '<div class="alert alert-info">This project comes from the AMS. If you want to edit details, do it in the AMS.</div>';
			}
			
	        $research_interests = array();
	        
	        if (isset($project['research_interests']))
	        {
				foreach ($project['research_interests'] as $key)
				{
				    $research_interests[] = $key['title'];
				}
	        }
	        
			$form_research_interests = array(
				'name'			=> 'research_interests',
				'id'			=> 'research_interests',
				'value'			=> implode(',', $research_interests),
				'maxlength'		=> '200',
				'class'		=> 'form_width'
			);
		
			echo '<div class="control-group">';
			echo form_label('Areas of Interest', 'research_interests', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_research_interests);
				echo '<span class="help-block">Areas of research that this project covers.</span>';
			echo '</div></div>';
		}
		if ($project['publicly_visible'])
		{
			$visible = 'visible';
		}
		else
		{
			$visible = 'hidden';
		}
		
		if ($project['research_project_status']['text'] === 'Archived')
		{
			echo '<div class="alert alert-info">This project has been completed and archived. You can only edit the visibility.</div>';
		}
		
		$project_visibilty['visible'] = 'Publicly Visible';
		$project_visibilty['hidden'] = 'Hidden';
	
		echo '<div class="control-group">';
		echo form_label('Project Visibility', 'project_visibility', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('project_visibility', $project_visibilty, set_value('project_visibility', $visible), 'id="project_visibility" class="span4"');
				echo '<span class="help-block">Displays the project  publicly, or keeps it hidden and private.</span>';
		echo '</div></div>';
			
		if ($project['research_project_status']['text'] !== 'Archived')
		{
			echo '<h2>';
			echo '<i class="icon-cogs"></i>' . ' Project Team';
			echo '</h2>';
			
			echo form_label('Project Members', 'project_members', array('class' => 'control-label'));
			echo '<div class="controls">';
	
			echo '<table class = "table table-bordered table-striped" id="members_table" name="members_table">';
			echo '<thead><tr><th>Members</th><th>Permission</th><th>Role</th><th>Options</th></tr></thead>';
			echo '<tbody>';
			
			$member_id = 0;
			
			foreach($project['research_project_members'] as $project_member)
			{
				$title = NULL;
				if(isset($project_member['person']['title']))
				{
					$title = $project_member['person']['title'] . ' ';
				}
				echo '<tr id="member_row_' . $member_id . '"><td>' . $title . $project_member['person']['first_name'] . ' ' . $project_member['person']['last_name'] . '<input type="hidden" name="members[' . $member_id . '][id]" value="' . $project_member['person']['id'] . '"</td><td><select name="members[' . $member_id . '][permission]">';
				foreach ($permissions as $permission)
				{
			       echo '<option value="'. $permission['id'] .'"';
			       
			       if($project_member['permission']['id'] === $permission['id'])
			       {
				       echo ' selected';
			       }		       
			       echo '>'. $permission['name'] .'</option>';
				}
				echo '</td><td><input type="text" id="members[' . $member_id . '][role]" name="members[' . $member_id . '][role]" value="' . $project_member['role'] . '"><td><a class="btn btn-danger btn-small removeMemberButton"><i class = "icon-remove icon-white"></i> Remove</td></tr>';
				$member_id++;
			}
			?>
			</tbody>
			</table>
			
			<p><a class="btn" id="addMember" ><i class = "icon-plus"></i> Add Project Member</a></p>
			
			<?php
		} 
		?>
		<div class="form-actions">
		<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Project Details</button>
		</div>
			
		</form>
		<?php

		echo form_close();

	?>
		
	</div>
</div>